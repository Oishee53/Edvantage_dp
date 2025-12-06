<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Courses;
use App\Models\User;
use App\Models\Certificate;
use App\Models\VideoProgress;
use App\Models\QuizSubmission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Certificates;

class CertificateController extends Controller
{
public function verify($certificate_id)
{
    $certificate = Certificate::with(['user', 'course'])
        ->where('certificate_id', $certificate_id)
        ->first();

    return view('certificate.verify', compact('certificate', 'certificate_id'));
}






public function generate($userId, $courseId)
{
    $user = auth()->user();

    // Make sure user is requesting their own certificate
    if ($user->id != $userId) {
        abort(403, 'Unauthorized action.');
    }

    $course = Courses::findOrFail($courseId);

   
    $sampleResource = $course->resources()->first();
    
    if (!$sampleResource) {
        return redirect()->back()->with('error', 'No resources found for this course.');
    }

    $resourceColumns = DB::getSchemaBuilder()->getColumnListing('resources');
    
    \Log::info("Database Structure Debug", [
        'resource_columns' => $resourceColumns,
        'sample_resource_data' => $sampleResource->toArray(),
        'course_id' => $courseId
    ]);

    // Check video completion 
    $totalVideos = 0;
    
    if (in_array('videos', $resourceColumns)) {
        $totalVideos = $course->resources()->whereNotNull('videos')->count();
    } elseif (in_array('video_path', $resourceColumns)) {
        $totalVideos = $course->resources()->whereNotNull('video_path')->count();
    } elseif (in_array('type', $resourceColumns)) {
        $totalVideos = $course->resources()->where('type', 'video')->count();
    } elseif (in_array('resource_type', $resourceColumns)) {
        $totalVideos = $course->resources()->where('resource_type', 'video')->count();
    } else {
        $totalVideos = $course->resources()->count();
    }
    
    $completedVideos = VideoProgress::where('user_id', $user->id)
        ->whereIn('resource_id', $course->resources()->pluck('id'))
        ->where('is_completed', 1)
        ->count();

    $completionPercentage = $totalVideos > 0 
        ? round(($completedVideos / $totalVideos) * 100) 
        : 0;

    //  Check average quiz score 
    $courseQuizzes = $course->quizzes()->pluck('id');
    $quizSubmissions = QuizSubmission::where('user_id', $user->id)
        ->whereIn('quiz_id', $courseQuizzes)
        ->with('quiz')
        ->get();

    $quizPercentages = $quizSubmissions->map(function ($submission) {
        $totalMarks = $submission->quiz->total_marks ?? 0;
        $percentage = $totalMarks > 0
            ? round(($submission->score / $totalMarks) * 100, 2)
            : 0;
        return $percentage;
    });

    $averageScore = $quizPercentages->count() > 0 
        ? round($quizPercentages->avg()) 
        : 0;

    \Log::info("Certificate Debug for User {$user->id}, Course {$courseId}", [
        'total_videos' => $totalVideos,
        'completed_videos' => $completedVideos,
        'completion_percentage' => $completionPercentage,
        'course_quiz_ids' => $courseQuizzes->toArray(),
        'quiz_submissions_count' => $quizSubmissions->count(),
        'quiz_submissions_with_details' => $quizSubmissions->map(function($sub) {
            return [
                'quiz_id' => $sub->quiz_id,
                'score' => $sub->score,
                'total_marks' => $sub->quiz->total_marks ?? 0,
                'percentage' => $sub->quiz->total_marks > 0 ? round(($sub->score / $sub->quiz->total_marks) * 100, 2) : 0
            ];
        })->toArray(),
        'quiz_percentages' => $quizPercentages->toArray(),
        'average_percentage' => $averageScore,
        'old_wrong_average' => $quizSubmissions->avg('score')
    ]);

    //  Check eligibility -----
    if ($completionPercentage < 100 || $averageScore < 70) {
        return redirect()->back()->with('error', 
            "You are not eligible for this certificate. " .
            "Video completion: {$completionPercentage}%, Quiz average: {$averageScore}%. " .
            "Requirements: 100% videos + 70% quiz average."
        );
    }


   


     $certificate = Certificate::firstOrCreate(
    [
        'user_id' => $user->id,
        'course_id' => $course->id
    ],
    [
        'certificate_id' => strtoupper(uniqid('CERT-')), 
        'average_score' => $averageScore,
        'completion_date' => now(),
        
    ]
);

$width  = 900 * 0.75; 
$height = 650 * 0.75;
    //  Generate Certificate -----
 $pdf = Pdf::loadView('Resources.certificate', [
        'user'   => $user,
        'course' => $course,
        'certificate' => $certificate,
    ]);



$pdf->setPaper([0, 0, $width, $height]);

    return $pdf->stream('certificate_' . $course->title . '.pdf');
}


    
    
   
}