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
        $user   = auth()->user();
        $userId = $user->id;

        $courses = Courses::whereHas('enrollments', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['resources', 'quizzes'])
        ->get();

        $courseProgress = [];

        foreach ($courses as $course) {

            // ── LIVE COURSE — no progress tracking, just check if cert exists ─
            if ($course->course_type === 'live') {
                $hasCertificate = \App\Models\Certificate::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->exists();

                $courseProgress[] = [
                    'course_id'              => $course->id,
                    'course_name'            => $course->title,
                    'category'               => $course->category->name ?? null,
                    'course_type'            => 'live',
                    'certificates_published' => $hasCertificate,
                    // Kept for blade compatibility
                    'completion_percentage'  => 0,
                    'average_percentage'     => 0,
                    'completed_videos'       => 0,
                    'total_videos'           => 0,
                    'quiz_marks'             => collect([]),
                ];
                continue;
            }

            // ── RECORDED COURSE — existing logic unchanged ────────────────────
            $totalVideos     = $course->resources->count();
            $completedVideos = VideoProgress::where('user_id', $userId)
                ->whereIn('resource_id', $course->resources->pluck('id'))
                ->where('is_completed', true)
                ->count();

            $quizIds         = $course->quizzes->pluck('id');
            $quizSubmissions = QuizSubmission::where('user_id', $userId)
                ->whereIn('quiz_id', $quizIds)
                ->with('quiz')
                ->get();

            $quizMarks = $quizSubmissions->map(function ($submission) {
                $totalMarks = $submission->quiz->total_marks ?? 0;
                $percentage = $totalMarks > 0
                    ? round(($submission->score / $totalMarks) * 100, 2)
                    : 0;

                return [
                    'quiz_title'  => $submission->quiz->title,
                    'score'       => $submission->score,
                    'total_marks' => $totalMarks,
                    'percentage'  => $percentage,
                ];
            });

            $averagePercentage    = $quizMarks->avg('percentage') ?? 0;
            $completionPercentage = $totalVideos > 0
                ? round(($completedVideos / $totalVideos) * 100, 2)
                : 0;

            $courseProgress[] = [
                'course_id'              => $course->id,
                'course_name'            => $course->title,
                'category'               => $course->category->name ?? null,
                'course_type'            => 'recorded',
                'certificates_published' => false,
                'completed_videos'       => $completedVideos,
                'total_videos'           => $totalVideos,
                'completion_percentage'  => $completionPercentage,
                'quiz_marks'             => $quizMarks,
                'average_percentage'     => $averagePercentage,
            ];
        }

        return view('User.progress', [
            'courseProgress'  => $courseProgress,
            'user'            => $user,
            'enrolledCourses' => $courses,
            'LiveCourse'      => $courses->contains('course_type', 'live'),
        ]);
    }
}