<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CourseLiveSession;
use App\Models\Courses;
use App\Models\DiscussionForum;
use App\Models\Enrollment;
use App\Models\PendingResources;
use App\Models\Quiz;
use App\Models\Resource;
use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use App\Models\NotebookDocument;
use App\Models\NotebookConversation;

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

    public function userEnrolledCourses()
    {
        $user = Auth::user();

        // Load the instructor relationship
        $enrolledCourses = $user->enrollments()
            ->with(['course.instructor'])
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

        if ($course->course_type === 'live') {
            // Load live sessions from DB
            $sessions = CourseLiveSession::where('course_id', $courseId)
                ->orderBy('session_number')
                ->get()
                ->keyBy('session_number');

            $modules = [];
            for ($i = 1; $i <= (int) $course->video_count; $i++) {
                $session   = $sessions->get($i);
                $modules[] = [
                    'id'            => $i,
                    'title'         => $session?->title ?? 'Session ' . $i,
                    'date'          => $session?->date,
                    'start_time'    => $session?->start_time,
                    'duration'      => $session?->duration_minutes,
                    'status'        => $session?->status ?? 'scheduled',
                    'recording_url' => $session?->recording_url,
                    'pdf'           => $session?->pdf,
                    'is_live'       => true,
                ];
            }

            return view('user.course_modules', compact('course', 'modules'));
        }

        // Recorded course — keep original simple range
        $videoCount = $course->video_count;
        $modules    = range(1, $videoCount);

        return view('user.course_modules', compact('course', 'modules'));
    }

    public function showInsideModule($courseId, $moduleNumber)
    {
        $resource = Resource::where('courseId', $courseId)
            ->where('moduleId', $moduleNumber)
            ->firstOrFail();

        $course = Courses::findOrFail($courseId);

        $quiz = Quiz::where('course_id', $courseId)
            ->where('module_number', $moduleNumber)
            ->first();

        $questions = $quiz ? $quiz->questions : collect();

        $forum = DiscussionForum::where('course_id', $courseId)
            ->where('module_id', $resource->id)
            ->first();

        // Get notebook documents for this student + course
        $nbDocuments = NotebookDocument::where('course_id', $courseId)
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->map(function ($d) {
                return [
                    'id'          => $d->id,
                    'title'       => $d->title,
                    'file_name'   => $d->file_name,
                    'file_type'   => $d->file_type,
                    'chunk_count' => $d->chunk_count,
                    'status'      => $d->status,
                ];
            });

        // Get conversation history for this student + course
        $nbConversations = NotebookConversation::where('course_id', $courseId)
            ->where('user_id', auth()->id())
            ->latest()
            ->take(30)
            ->get()
            ->reverse()
            ->values()
            ->map(function ($c) {
                return [
                    'question' => $c->question,
                    'answer'   => $c->answer,
                    'sources'  => [],
                    'showSrc'  => false,
                ];
            });

        return view('Resources.inside_module', [
            'course'          => $course,
            'quiz'            => $quiz,
            'questions'       => $questions,
            'moduleNumber'    => $moduleNumber,
            'resource'        => $resource,
            'forum'           => $forum,
            'nbDocuments'     => $nbDocuments,
            'nbConversations' => $nbConversations,
        ]);
    }

    public function viewPDF($id)
    {
        $resource = Resource::find($id);

        // If not found, fallback to pending resources
        if (!$resource) {
            $resource = PendingResources::findOrFail($id);
        }

        // Cloudinary public URL
        $pdfUrl = $resource->pdf;

        // Stream the file securely through your server
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