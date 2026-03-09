<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Certificate;
use App\Models\Courses;
use App\Models\FinalExam;
use App\Models\FinalExamSubmission;
use App\Models\QuizSubmission;
use App\Models\VideoProgress;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Log;

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

        if ($user->id != $userId) {
            abort(403, 'Unauthorized action.');
        }

        $course = Courses::findOrFail($courseId);

        // ──────────────────────────────────────────────────────────────────────
        // LIVE COURSE — eligibility based on assignments + final exam
        // ──────────────────────────────────────────────────────────────────────
        if ($course->course_type === 'live') {
            return $this->generateLiveCertificate($user, $course);
        }

        // ──────────────────────────────────────────────────────────────────────
        // RECORDED COURSE — existing logic unchanged
        // ──────────────────────────────────────────────────────────────────────
        return $this->generateRecordedCertificate($user, $course);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LIVE COURSE CERTIFICATE
    // ──────────────────────────────────────────────────────────────────────────
    private function generateLiveCertificate($user, $course)
    {
        // ── 1. Check final exam is graded and passed ───────────────────────
        $finalExam = FinalExam::where('course_id', $course->id)
            ->where('status', 'published')
            ->first();

        if (!$finalExam) {
            return back()->with('error',
                'No published final exam found for this course. Please contact your instructor.');
        }

        $finalExamSubmission = FinalExamSubmission::where('final_exam_id', $finalExam->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$finalExamSubmission) {
            return back()->with('error',
                'You have not submitted the final exam yet.');
        }

        if ($finalExamSubmission->status !== 'graded') {
            return back()->with('error',
                'Your final exam has not been graded yet. Please check back later.');
        }

        $finalExamPercentage = round($finalExamSubmission->percentage, 2);

        if ($finalExamPercentage < 70) {
            return back()->with('error',
                "You need at least 70% on the final exam to earn a certificate. "
                . "Your score: {$finalExamPercentage}%.");
        }

        // ── 2. Check all assignments are graded and each scored ≥ 70% ──────
        $assignments = Assignment::where('course_id', $course->id)->get();

        foreach ($assignments as $assignment) {
            $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('student_id', $user->id)
                ->first();

            if (!$submission) {
                return back()->with('error',
                    "Assignment {$assignment->title} has not been submitted yet.");
            }

            if ($submission->status !== 'graded') {
                return back()->with('error',
                    "Assignment {$assignment->title} has not been graded yet. Please check back later.");
            }

            $totalMarks  = $assignment->marks ?? 0;
            $assignmentPct = $totalMarks > 0
                ? round(($submission->score / $totalMarks) * 100, 2)
                : 0;

            if ($assignmentPct < 70) {
                return back()->with('error',
                    "You need at least 70% on all assignments to earn a certificate. "
                    . "Assignment '{$assignment->title}': {$assignmentPct}%.");
            }
        }

        // ── 3. Compute overall average for the certificate record ──────────
        // Average of all assignment percentages + final exam percentage
        $assignmentPercentages = $assignments->map(function ($assignment) use ($user) {
            $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('student_id', $user->id)
                ->first();
            $totalMarks = $assignment->marks ?? 0;
            return $totalMarks > 0
                ? ($submission->score / $totalMarks) * 100
                : 0;
        });

        $allScores    = $assignmentPercentages->push($finalExamPercentage);
        $averageScore = round($allScores->avg(), 2);

        // ── 4. Create or fetch certificate record ──────────────────────────
        $certificate = Certificate::firstOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ],
            [
                'certificate_id'  => strtoupper(uniqid('CERT-')),
                'average_score'   => $averageScore,
                'completion_date' => now(),
            ]
        );

        // ── 5. Generate PDF ────────────────────────────────────────────────
        $width  = 900 * 0.75;
        $height = 650 * 0.75;

        $pdf = Pdf::loadView('Resources.certificate', [
            'user'        => $user,
            'course'      => $course,
            'certificate' => $certificate,
        ]);

        $pdf->setPaper([0, 0, $width, $height]);

        return $pdf->stream('certificate_' . $course->title . '.pdf');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // RECORDED COURSE CERTIFICATE (original logic, untouched)
    // ──────────────────────────────────────────────────────────────────────────
    private function generateRecordedCertificate($user, $course)
    {
        $sampleResource = $course->resources()->first();

        if (!$sampleResource) {
            return redirect()->back()->with('error', 'No resources found for this course.');
        }

        $resourceColumns = DB::getSchemaBuilder()->getColumnListing('resources');

        \Log::info("Database Structure Debug", [
            'resource_columns'    => $resourceColumns,
            'sample_resource_data'=> $sampleResource->toArray(),
            'course_id'           => $course->id,
        ]);

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

        $courseQuizzes    = $course->quizzes()->pluck('id');
        $quizSubmissions  = QuizSubmission::where('user_id', $user->id)
            ->whereIn('quiz_id', $courseQuizzes)
            ->with('quiz')
            ->get();

        $quizPercentages = $quizSubmissions->map(function ($submission) {
            $totalMarks = $submission->quiz->total_marks ?? 0;
            return $totalMarks > 0
                ? round(($submission->score / $totalMarks) * 100, 2)
                : 0;
        });

        $averageScore = $quizPercentages->count() > 0
            ? round($quizPercentages->avg())
            : 0;

        \Log::info("Certificate Debug for User {$user->id}, Course {$course->id}", [
            'total_videos'       => $totalVideos,
            'completed_videos'   => $completedVideos,
            'completion_pct'     => $completionPercentage,
            'average_percentage' => $averageScore,
        ]);

        // Check all assignments submitted
        $assignments = $course->assignments;
        foreach ($assignments as $assignment) {
            $submitted = AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('student_id', $user->id)
                ->exists();

            if (!$submitted) {
                return back()->with('error', 'Complete all assignments first.');
            }
        }

        if ($completionPercentage < 100 || $averageScore < 70) {
            return redirect()->back()->with('error',
                "You are not eligible for this certificate. "
                . "Video completion: {$completionPercentage}%, Quiz average: {$averageScore}%. "
                . "Requirements: 100% videos + 70% quiz average."
            );
        }

        $certificate = Certificate::firstOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ],
            [
                'certificate_id'  => strtoupper(uniqid('CERT-')),
                'average_score'   => $averageScore,
                'completion_date' => now(),
            ]
        );

        $width  = 900 * 0.75;
        $height = 650 * 0.75;

        $pdf = Pdf::loadView('Resources.certificate', [
            'user'        => $user,
            'course'      => $course,
            'certificate' => $certificate,
        ]);

        $pdf->setPaper([0, 0, $width, $height]);

        return $pdf->stream('certificate_' . $course->title . '.pdf');
    }
}