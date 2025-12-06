<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Quiz;
use App\Models\Courses;
use App\Models\Resource;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\VideoProgress;
use App\Models\PendingResources;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class EnrollmentController extends Controller
{
public function checkout()
{
    $user = Auth::user();

    // Get all cart items for the authenticated user
    $cartItems = Cart::where('user_id', $user->id)->get();

    foreach ($cartItems as $item) {
        // Prevent duplicate enrollments
        if (!Enrollment::where('user_id', $user->id)->where('course_id', $item->course_id)->exists()) {
            Enrollment::create([
                'user_id' => $user->id,
                'course_id' => $item->course_id,
            ]);
        }
    }

    // Clear cart after successful enrollment
    Cart::where('user_id', $user->id)->delete();

    return redirect()->route('courses.all')->with('success', 'Checkout successful. You are now enrolled in all selected courses!');
}




public function userEnrolledCourses() {
    $user = Auth::user();
    
    // Load the instructor relationship (assuming User model with role=3)
    $enrolledCourses = $user->enrollments()
        ->with(['course.instructor']) // This will load the instructor
        ->get()
        ->pluck('course');
    
    $courseProgress = [];
    
    foreach ($enrolledCourses as $course) {
        $totalVideos = Resource::where('courseId', $course->id)->count();
        
        $completedVideos = VideoProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('is_completed', 1)
            ->count();
        
        $courseProgress[$course->id] = [
            'completed_videos' => $completedVideos,
            'total_videos' => $totalVideos,
            'completion_percentage' => $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0,
        ];
    }
    
    return view('User.enrolled_courses', compact('user', 'enrolledCourses', 'courseProgress'));
}


public function viewCourseModules($courseId)
{
   

   $course = Courses::findOrFail($courseId);

 
    $videoCount = $course->video_count; 

    $modules = range(1, $videoCount);

    return view('user.course_modules', compact('course', 'modules'));
}

public function showInsideModule($courseId, $moduleNumber)
{
    $resource = Resource::where('courseId', $courseId)->where('moduleId', $moduleNumber)->firstOrFail();
    $course = Courses::findOrFail($courseId);
    $quiz = Quiz::where('course_id', $courseId)
                ->where('module_number', $moduleNumber)
                ->first();
    $questions = $quiz ? $quiz->questions : collect();

    return view('Resources.inside_module', [
        'course' => $course,
        'quiz' => $quiz,
        'questions' => $questions,
        'moduleNumber' => $moduleNumber,
        'resource' => $resource,
    ]);
}



public function viewPDF($id)
{
    $resource = Resource::find($id);

    // If not found, fallback to pending resources
    if (!$resource) {
        $resource = PendingResources::findOrFail($id); // will throw 404 if not found
    }
    
    // Cloudinary public URL
    $pdfUrl = $resource->pdf;

    //Option 2: Stream the file securely through your server (better for privacy, heavier on backend)
    $response = Http::get($pdfUrl);
    return Response::make($response->body(), 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'inline; filename="module-resource.pdf"',
    ]);
}


public function purchaseHistory()
{
    $user = auth()->user();

    // Get all enrolled courses with enrollment info
    $enrollments = Enrollment::with('course')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('user.purchase_history', compact('enrollments'));
}

    
}
