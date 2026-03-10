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
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\FinalExam;
use App\Models\FinalExamSubmission;
use App\Models\CourseLiveSession;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Certificates;

class CertificateController extends Controller
{
    // ──────────────────────────────────────────────────────────────────────────
    // Verify a certificate by its ID (public)
    // ──────────────────────────────────────────────────────────────────────────
    public function verify($certificate_id)
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_id', $certificate_id)
            ->first();

        return view('certificate.verify', compact('certificate', 'certificate_id'));
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Student downloads their own certificate
    // ──────────────────────────────────────────────────────────────────────────
    public function generate($userId, $courseId)
    {
        $user = auth()->user();

        if ($user->id != $userId) {
            abort(403, 'Unauthorized action.');
        }

        $course = Courses::findOrFail($courseId);

        if ($course->course_type === 'live') {
            return $this->generateLiveCertificate($user, $course);
        }

        return $this->generateRecordedCertificate($user, $course);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // INSTRUCTOR: Show publish certificate button / trigger bulk generation
    // GET  → instructor.live_session.publish_certificates_form
    // POST → instructor.live_session.publish_certificates
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Bulk-generate certificates for all eligible students.
     * Triggered by instructor after all sessions are ended.
     */
    public function publishCertificates(Request $request, $course_id)
    {
        $course = Courses::findOrFail($course_id);

        // Guard: only live courses
        if ($course->course_type !== 'live') {
            return back()->with('error', 'Certificates can only be published for live courses.');
        }

        // Guard: all sessions must be ended
        $totalSessions   = (int) $course->video_count;
        $endedSessions   = CourseLiveSession::where('course_id', $course_id)
                               ->where('status', 'ended')
                               ->count();

        if ($endedSessions < $totalSessions) {
            return back()->with('error',
                "All {$totalSessions} sessions must be completed before publishing certificates. "
                . "{$endedSessions} ended so far.");
        }

        // Published assessments — ONLY consider published ones
        $publishedFinalExam  = FinalExam::where('course_id', $course_id)
                                   ->where('status', 'published')
                                   ->first();

        $publishedAssignments = Assignment::where('course_id', $course_id)->get();

        // Enrolled students
        $studentIds = Enrollment::where('course_id', $course_id)->pluck('user_id');
        $students   = User::whereIn('id', $studentIds)->get();

        $issued  = 0;
        $skipped = 0;
        $reasons = [];

        foreach ($students as $student) {
            [$eligible, $reason, $averageScore] = $this->checkLiveEligibility(
                $student, $course_id, $publishedFinalExam, $publishedAssignments
            );

            if (!$eligible) {
                $skipped++;
                $reasons[] = "{$student->name}: {$reason}";
                continue;
            }

            // Issue certificate (idempotent — won't duplicate)
            Certificate::firstOrCreate(
                [
                    'user_id'   => $student->id,
                    'course_id' => $course->id,
                ],
                [
                    'certificate_id'  => strtoupper(uniqid('CERT-')),
                    'average_score'   => $averageScore,
                    'completion_date' => now(),
                ]
            );

            $issued++;
        }

        $message = "Certificates published. Issued: {$issued}, Skipped: {$skipped}.";
        if (!empty($reasons)) {
            $message .= ' Skipped reasons: ' . implode('; ', array_slice($reasons, 0, 5));
            if (count($reasons) > 5) {
                $message .= ' ...and ' . (count($reasons) - 5) . ' more.';
            }
        }

        return back()->with('success', $message);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // LIVE COURSE — student downloads their certificate
    // (certificate must already exist — created by publishCertificates)
    // ──────────────────────────────────────────────────────────────────────────
    private function generateLiveCertificate($user, $course)
    {
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$certificate) {
            return back()->with('error',
                'You are not eligible for a certificate for this course. '
                . 'Certificates are issued by your instructor after all sessions are completed and assessments are graded.');
        }

        return $this->streamCertificatePdf($user, $course, $certificate);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Helper: check if a student is eligible for a live course certificate
    // Returns [bool $eligible, string $reason, float $averageScore]
    // ──────────────────────────────────────────────────────────────────────────
    private function checkLiveEligibility($student, $courseId, $publishedFinalExam, $publishedAssignments): array
    {
        $scores = collect();

        // ── Final exam (only if published) ────────────────────────────────────
        if ($publishedFinalExam) {
            $sub = FinalExamSubmission::where('final_exam_id', $publishedFinalExam->id)
                ->where('user_id', $student->id)
                ->first();

            if (!$sub) {
                return [false, 'Final exam not submitted', 0];
            }
            if ($sub->status !== 'graded') {
                return [false, 'Final exam not graded yet', 0];
            }
            if ($sub->percentage < 70) {
                return [false, "Final exam score {$sub->percentage}% < 70%", 0];
            }

            $scores->push($sub->percentage);
        }

        // ── Assignments (only if any exist for this course) ───────────────────
        foreach ($publishedAssignments as $assignment) {
            $sub = AssignmentSubmission::where('assignment_id', $assignment->id)
                ->where('student_id', $student->id)
                ->first();

            if (!$sub || $sub->status !== 'graded') {
                // Assignment exists but not submitted/graded — skip student
                $reason = !$sub ? "Assignment '{$assignment->title}' not submitted"
                                : "Assignment '{$assignment->title}' not graded yet";
                return [false, $reason, 0];
            }

            $totalMarks = $assignment->marks ?? 0;
            $pct        = $totalMarks > 0
                ? round(($sub->score / $totalMarks) * 100, 2)
                : 0;

            if ($pct < 70) {
                return [false, "Assignment '{$assignment->title}' score {$pct}% < 70%", 0];
            }

            $scores->push($pct);
        }

        // If no published assessments at all, still eligible (instructor discretion)
        $averageScore = $scores->count() > 0 ? round($scores->avg(), 2) : 100.0;

        return [true, '', $averageScore];
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
            'resource_columns'     => $resourceColumns,
            'sample_resource_data' => $sampleResource->toArray(),
            'course_id'            => $course->id,
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

        $courseQuizzes   = $course->quizzes()->pluck('id');
        $quizSubmissions = QuizSubmission::where('user_id', $user->id)
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

        return $this->streamCertificatePdf($user, $course, $certificate);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // Shared PDF stream helper
    // ──────────────────────────────────────────────────────────────────────────
    private function streamCertificatePdf($user, $course, $certificate)
    {
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