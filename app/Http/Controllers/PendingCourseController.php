<?php

namespace App\Http\Controllers;

use App\Services\MuxService;
use Illuminate\Http\Request;
use App\Models\PendingCourses;
use App\Models\PendingResources;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PendingCourseController extends Controller
{
 public function create()
{
    return view('courses.create_course');
}
public function store(Request $request)
{
    $user = auth()->user();

    // Validation rules
    $rules = [
    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    'title' => 'required',
    'description' => 'nullable',
    'category' => 'required|string',
    'video_count' => 'required|integer',
    'approx_video_length' => 'required|integer',
    'total_duration' => 'required|numeric',
    'price' => 'required|numeric',
    'prerequisite' => 'nullable|string|max:255',
];

    $request->validate($rules);
    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('course_images', 'public');
    }
    // Determine instructor ID
    $instructorId = $user->role === 2 ? $request->input('instructor_id') : $user->id;

    // Create the course
    $course = PendingCourses::create([
        'image' => $imagePath ?? null,
        'title' => $request->title,
        'description' => $request->description,
        'category' => $request->category,
        'video_count' => $request->video_count,
        'approx_video_length' => $request->approx_video_length,
        'total_duration' => $request->total_duration,
        'price' => $request->price,
        'instructor_id' => $instructorId,
        'prerequisite' => $request->prerequisite,
    ]);
    return redirect("/instructor/manage_resources/{$course->id}/modules")
           ->with('success', 'Course added successfully');
}
public function showModules($course_id)
{
    $course = PendingCourses::findOrFail($course_id);

    // Get all module IDs that have at least one resource for this course
    $uploadedModuleIds = DB::table('pending_resources')
        ->where('courseId', $course_id)
        ->pluck('moduleId')       
        ->unique()                 
        ->map(fn ($id) => (int) $id)
        ->values()
        ->all();

    $modules = [];
    $allUploaded = true;
    $alreadySubmitted = \App\Models\CourseNotification::where('pending_course_id', $course->id)->exists();

    for ($i = 1; $i <= (int) $course->video_count; $i++) {
        $isUploaded = in_array($i, $uploadedModuleIds, true);

        $modules[] = [
            'id'       => $i,
            'uploaded' => $isUploaded,
        ];

        if (!$isUploaded) {
            $allUploaded = false;
        }
    }

    return view('Instructor.show_modules', compact('course', 'modules', 'allUploaded','alreadySubmitted'));
}

public function editModule($course_id, $module_id){
    $course = PendingCourses::findOrFail($course_id);
    $moduleExists = PendingResources::where('courseId', $course_id)
        ->where('moduleId', $module_id)
        ->exists();

    if ($module_id < 1 || $module_id > $course->video_count) {
        abort(404); 
    }

    return view('Instructor.edit_module', compact('course', 'module_id','moduleExists'));
}
    private function uploadVideoToCloudinary($videoFile, $course_id, $module_id)
    {
        $result = Cloudinary::uploadApi()->upload($videoFile->getRealPath(), [
            'resource_type' => 'video',
            'folder' => "course_{$course_id}/module_{$module_id}",
        ]);

        return $result['secure_url'];
    }

    private function uploadPdfToCloudinary($pdfFile, $course_id, $module_id)
    {
        try {
            // Get the original filename without extension
            $originalName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            
            $result = Cloudinary::uploadApi()->upload($pdfFile->getRealPath(), [
                'resource_type' => 'raw',  // raw for PDFs
                'folder' => "course_{$course_id}/module_{$module_id}",
                'public_id' => $originalName, // Use clean filename
                'format' => 'pdf', // Explicitly set format as PDF
                'overwrite' => true,
                'use_filename' => true,
                'unique_filename' => false,
            ]);

            // Debug: Log what Cloudinary returns
            Log::info('Cloudinary PDF Upload Result:', ['result' => $result]);

            // Return the URL with .pdf extension for proper preview
            return $result['secure_url'];
        } catch (\Exception $e) {
            Log::error('Cloudinary PDF Upload Error:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function uploadToMux(Request $request, MuxService $muxService)
    {
        $request->validate([
            'video' => 'required|url',
        ]);

        $videoUrl = $request->input('video');

        try {
            // Upload to Mux and get playback ID
            $result = $muxService->uploadVideo($videoUrl);
            
            // Debug: Log what Mux returns
            Log::info('Mux Service Response:', ['result' => $result]);
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Mux Upload Error:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function handleUpload(Request $request, MuxService $muxService, $course_id, $module_id)
    {
        $request->validate([
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200', // 50MB
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ]);

        $data = [
            'courseId' => $course_id,
            'moduleId' => $module_id,
        ];

        // Upload video to Cloudinary and Mux
        if ($request->hasFile('video')) {
            try {
                $cloudinaryUrl = $this->uploadVideoToCloudinary($request->file('video'), $course_id, $module_id);
                Log::info('Video uploaded to Cloudinary:', ['url' => $cloudinaryUrl]);

                // Send to Mux
                $newRequest = new Request(['video' => $cloudinaryUrl]);
                $muxResult = $this->uploadToMux($newRequest, $muxService);
                
                // Extract playback ID from Mux response
                if (is_array($muxResult) && isset($muxResult['playback_id'])) {
                    $data['videos'] = $muxResult['playback_id'];
                } else {
                    Log::error('Unexpected Mux response format:', ['response' => $muxResult]);
                    return back()->withErrors(['video' => 'Failed to process video with Mux']);
                }
                
                Log::info('Final video data to store:', ['videos' => $data['videos']]);
                
            } catch (\Exception $e) {
                Log::error('Video upload failed:', ['error' => $e->getMessage()]);
                return back()->withErrors(['video' => 'Video upload failed: ' . $e->getMessage()]);
            }
        }

        // Upload PDF
        if ($request->hasFile('pdf')) {
            try {
                $pdfUrl = $this->uploadPdfToCloudinary($request->file('pdf'), $course_id, $module_id);
                $data['pdf'] = $pdfUrl;
                Log::info('PDF uploaded:', ['url' => $pdfUrl]);
            } catch (\Exception $e) {
                Log::error('PDF upload failed:', ['error' => $e->getMessage()]);
                return back()->withErrors(['pdf' => 'PDF upload failed: ' . $e->getMessage()]);
            }
        }

        // Debug: Log final data before database operation
        Log::info('Data to be stored in database:', $data);

        // Insert or update using Eloquent
        try {
            $resource = PendingResources::updateOrCreate(
                ['courseId' => $course_id, 'moduleId' => $module_id], // conditions to find existing record
                $data // data to update or create with
            );
            
            Log::info('Resource saved successfully:', ['resource' => $resource->toArray()]);
            
        } catch (\Exception $e) {
            Log::error('Database operation failed:', ['error' => $e->getMessage()]);
            return back()->withErrors(['database' => 'Failed to save resource: ' . $e->getMessage()]);
        }

        return redirect("/instructor/manage_resources/{$course_id}/modules")
       ->with('success', 'Resources uploaded successfully!');
    }

    public function showInsideModule($courseId, $moduleNumber)
{
    $resource = PendingResources::where('courseId', $courseId)->where('moduleId', $moduleNumber)->firstOrFail();
    $course = PendingCourses::findOrFail($courseId);

    return view('Instructor.view_pending_resources', [
        'course' => $course,
        'moduleNumber' => $moduleNumber,
        'resource' => $resource,
    ]);
} 
}
