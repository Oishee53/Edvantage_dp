<?php

namespace App\Http\Controllers;

use App\Models\FinalExam;
use App\Models\FinalExamSubmission;
use App\Models\FinalExamAnswer;
use App\Models\Enrollment;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class StudentFinalExamController extends Controller
{
    /**
     * Show final exam overview for a course
     */
    public function show($courseId)
    {
        $course = Courses::findOrFail($courseId);
        
        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            abort(403, 'You must be enrolled in this course');
        }

        // Get published final exam for this course
        $exam = FinalExam::where('course_id', $courseId)
            ->where('status', 'published')
            ->with('questions')
            ->first();

        if (!$exam) {
            return redirect()->route('user.course.modules', $courseId)
                ->with('info', 'No final exam available for this course yet');
        }

        // Get or create submission record
        $submission = FinalExamSubmission::firstOrCreate(
            [
                'final_exam_id' => $exam->id,
                'user_id' => Auth::id()
            ],
            [
                'status' => 'not_started'
            ]
        );

        return view('User.final_exam.show', compact('course', 'exam', 'submission'));
    }

    /**
     * Start the exam
     */
    public function start($examId)
    {
        $exam = FinalExam::with('questions')->findOrFail($examId);

        // Check enrollment
        $enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $exam->course_id)
            ->first();

        if (!$enrollment) {
            abort(403, 'You must be enrolled in this course');
        }

        // Get or create submission
        $submission = FinalExamSubmission::with('answers.question')->firstOrCreate(
            [
                'final_exam_id' => $exam->id,
                'user_id' => Auth::id()
            ],
            [
                'status' => 'not_started'
            ]
        );

        // If already submitted or graded, redirect to results
        if ($submission->status === 'submitted' || $submission->status === 'graded') {
            return redirect()->route('student.final-exam.result', $submission->id);
        }

        // Start the exam
        if ($submission->status === 'not_started') {
            $submission->update([
                'status' => 'in_progress',
                'started_at' => now()
            ]);
        }

        // Create answer records for all questions if they don't exist
        foreach ($exam->questions as $question) {
            FinalExamAnswer::firstOrCreate([
                'submission_id' => $submission->id,
                'question_id' => $question->id
            ]);
        }

        // Reload submission with answers
        $submission->load('answers.question');

        return view('User.final_exam.take', compact('exam', 'submission'));
    }

    /**
     * Upload answer image for a question (AJAX - handles ONE image at a time)
     */
 public function uploadAnswer(Request $request, $submissionId, $questionId)
{
    try {
        // Validate
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        // Get submission
        $submission = FinalExamSubmission::findOrFail($submissionId);

        // Authorization
        if ($submission->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Status check
        if ($submission->status !== 'in_progress') {
            return response()->json(['error' => 'Cannot upload after submission'], 400);
        }

        // Get or create answer record
        $answer = FinalExamAnswer::where('submission_id', $submissionId)
            ->where('question_id', $questionId)
            ->first();

        if (!$answer) {
            $answer = FinalExamAnswer::create([
                'submission_id' => $submissionId,
                'question_id' => $questionId,
                'answer_images' => json_encode([])
            ]);
        }

        // Get existing images
        $existingImages = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
        if (!is_array($existingImages)) {
            $existingImages = [];
        }

        // Check limit
        if (count($existingImages) >= 5) {
            return response()->json(['error' => 'Maximum 5 images per question'], 400);
        }

        // ✅ Upload to Cloudinary - SAME METHOD as your UploadController
        $uploadedFile = $request->file('image');
        
        $result = Cloudinary::uploadApi()->upload($uploadedFile->getRealPath(), [
            'resource_type' => 'image',
            'folder' => "final_exams/submission_{$submissionId}/question_{$questionId}",
        ]);

        $imageUrl = $result['secure_url'];

        // Add to array
        $existingImages[] = $imageUrl;

        // Save
        $answer->answer_images = json_encode($existingImages);
        $answer->save();

        return response()->json([
            'success' => true,
            'message' => 'Image uploaded successfully',
            'image_url' => $imageUrl,
            'images' => $existingImages
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'error' => 'Validation failed',
            'details' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        \Log::error('Upload failed', [
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return response()->json([
            'error' => 'Upload failed: ' . $e->getMessage()
        ], 500);
    }
}









































































    /**
     * Delete an answer image (AJAX)
     */
    public function deleteAnswerImage(Request $request, $submissionId, $questionId)
    {
        $submission = FinalExamSubmission::findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Cannot delete if already submitted
        if ($submission->status !== 'in_progress') {
            return response()->json(['error' => 'Cannot delete after submission'], 400);
        }

        $request->validate([
            'image_url' => 'required|string'
        ]);

        try {
            $answer = FinalExamAnswer::where('submission_id', $submissionId)
                ->where('question_id', $questionId)
                ->first();

            if (!$answer) {
                return response()->json(['error' => 'Answer not found'], 404);
            }

            // Get existing images
            $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];

            // Remove the specified image
            $images = array_values(array_filter($images, function($url) use ($request) {
                return $url !== $request->image_url;
            }));

            // Update answer
            $answer->answer_images = json_encode($images);
            $answer->save();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'images' => $images
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Submit the exam
     */
    public function submit($submissionId)
    {
        $submission = FinalExamSubmission::with('answers')->findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if already submitted
        if ($submission->status === 'submitted' || $submission->status === 'graded') {
            return redirect()->route('student.final-exam.show', $submission->exam->course_id)
                ->with('info', 'Exam already submitted');
        }

        // Validate all questions have at least one image
        foreach ($submission->answers as $answer) {
            $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
            if (empty($images)) {
                return back()->with('error', 'Please upload at least one image for each question');
            }
        }

        // Update submission
        $submission->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return redirect()->route('student.final-exam.show', $submission->exam->course_id)
            ->with('success', 'Exam submitted successfully! Your instructor will grade it soon.');
    }

    /**
     * View exam results
     */
    public function result($submissionId)
    {
        $submission = FinalExamSubmission::with([
            'exam.course',
            'exam.questions',
            'answers.question',
            'user'
        ])->findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if graded
        if ($submission->status !== 'graded') {
            return redirect()->route('student.final-exam.show', $submission->exam->course_id)
                ->with('info', 'Exam not yet graded. Please wait for instructor to grade your submission.');
        }

        return view('User.final_exam.result', compact('submission'));
    }

    /**
     * Get remaining time (AJAX)
     */
    public function getRemainingTime($submissionId)
    {
        $submission = FinalExamSubmission::with('exam')->findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($submission->status !== 'in_progress') {
            return response()->json(['error' => 'Exam not in progress'], 400);
        }

        // Calculate remaining time
        $startedAt = $submission->started_at;
        $durationMinutes = $submission->exam->duration_minutes;
        $endTime = $startedAt->copy()->addMinutes($durationMinutes);
        $remainingSeconds = now()->diffInSeconds($endTime, false);

        // If time expired
        if ($remainingSeconds <= 0) {
            if ($submission->status === 'in_progress') {
                $submission->update([
                    'status' => 'submitted',
                    'submitted_at' => now()
                ]);
            }
            return response()->json([
                'expired' => true,
                'remaining_seconds' => 0
            ]);
        }

        return response()->json([
            'expired' => false,
            'remaining_seconds' => max(0, $remainingSeconds)
        ]);
    }
}