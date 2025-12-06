<?php
namespace App\Http\Controllers;
use App\Models\Enrollment;
use App\Models\Courses;
use App\Models\VideoProgress;
use App\Models\Resource;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class UserProgressController extends Controller
{
public function index()
{
    $user = auth()->user();
    $userId = $user->id;

    // Fetch all courses the user is enrolled in with resources and quizzes
    $courses = Courses::whereHas('enrollments', function ($q) use ($userId) {
        $q->where('user_id', $userId);
    })
    ->with(['resources', 'quizzes'])
    ->get();

    $courseProgress = [];

    foreach ($courses as $course) {
        // Video progress
        $totalVideos = $course->resources->count();
        $completedVideos = VideoProgress::where('user_id', $userId)
            ->whereIn('resource_id', $course->resources->pluck('id'))
            ->where('is_completed', true)
            ->count();

        // Fetch quizzes for this course
        $quizIds = $course->quizzes->pluck('id');

        // Fetch user's quiz submissions with related quiz
        $quizSubmissions = QuizSubmission::where('user_id', $userId)
            ->whereIn('quiz_id', $quizIds)
            ->with('quiz')
            ->get();

        // Map quiz marks with percentage
        $quizMarks = $quizSubmissions->map(function ($submission) {
            $totalMarks = $submission->quiz->total_marks ?? 0;
            $percentage = $totalMarks > 0
                ? round(($submission->score / $totalMarks) * 100, 2)
                : 0;

            return [
                'quiz_title'   => $submission->quiz->title,
                'score'        => $submission->score,
                'total_marks'  => $totalMarks,
                'percentage'   => $percentage
            ];
        });

        // Average percentage across all quizzes
        $averagePercentage = $quizMarks->avg('percentage') ?? 0;

        // Video completion percentage
        $completionPercentage = $totalVideos > 0
            ? round(($completedVideos / $totalVideos) * 100, 2)
            : 0;

        $courseProgress[] = [
            'course_id'            => $course->id,
            'course_name'          => $course->title,
            'completed_videos'     => $completedVideos,
            'total_videos'         => $totalVideos,
            'completion_percentage'=> $completionPercentage,
            'quiz_marks'           => $quizMarks,
            'average_percentage'   => $averagePercentage
        ];
    }

    return view('User.progress', [
        'courseProgress' => $courseProgress,
        'user'           => $user,
        'enrolledCourses'=> $courses,
    ]);
}


}

