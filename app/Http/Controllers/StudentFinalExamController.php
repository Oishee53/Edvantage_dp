<?php

namespace App\Http\Controllers;

use App\Models\FinalExam;
use App\Models\FinalExamSubmission;
use App\Models\FinalExamAnswer;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class StudentFinalExamController extends Controller
{
    /**
     * Show final exam for a course (if exists and approved)
     */
    public function show($courseId)
    {
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

        return view('User.final_exam.show', compact('exam', 'submission'));
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
        $submission = FinalExamSubmission::firstOrCreate(
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

        return view('User.final_exam.take', compact('exam', 'submission'));
    }

    /**
     * Upload answer images for a question
     */
    public function uploadAnswer(Request $request, $submissionId, $questionId)
    {
        $submission = FinalExamSubmission::findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Cannot upload if already submitted
        if ($submission->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot upload answers after submission'
            ], 400);
        }

        $request->validate([
            'images' => 'required|array|min:1|max:5', // Max 5 images per question
            'images.*' => 'image|mimes:jpeg,png,jpg|max:5120' // 5MB per image
        ]);

        try {
            $imageUrls = [];

            // Upload each image to Cloudinary
            foreach ($request->file('images') as $image) {
                $result = Cloudinary::upload($image->getRealPath(), [
                    'folder' => "final_exams/submission_{$submissionId}/question_{$questionId}",
                    'resource_type' => 'image'
                ]);

                $imageUrls[] = $result->getSecurePath();
            }

            // Save or update answer
            $answer = FinalExamAnswer::updateOrCreate(
                [
                    'submission_id' => $submissionId,
                    'question_id' => $questionId
                ],
                [
                    'answer_images' => $imageUrls
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Answer uploaded successfully',
                'images' => $imageUrls
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload images: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an uploaded answer image
     */
    public function deleteAnswerImage(Request $request, $submissionId, $questionId)
    {
        $submission = FinalExamSubmission::findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Cannot delete if already submitted
        if ($submission->status !== 'in_progress') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify answers after submission'
            ], 400);
        }

        $request->validate([
            'image_url' => 'required|string'
        ]);

        $answer = FinalExamAnswer::where('submission_id', $submissionId)
            ->where('question_id', $questionId)
            ->first();

        if (!$answer) {
            return response()->json([
                'success' => false,
                'message' => 'Answer not found'
            ], 404);
        }

        // Remove image from array
        $images = $answer->answer_images;
        $images = array_values(array_filter($images, function($url) use ($request) {
            return $url !== $request->image_url;
        }));

        $answer->update(['answer_images' => $images]);

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }

    /**
     * Submit the exam
     */
    public function submit($submissionId)
    {
        $submission = FinalExamSubmission::with('exam.questions')
            ->findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if already submitted
        if ($submission->status !== 'in_progress') {
            return redirect()->route('student.final-exam.result', $submissionId)
                ->with('info', 'Exam already submitted');
        }

        // Validate all questions have answers
        $totalQuestions = $submission->exam->questions()->count();
        $answeredQuestions = FinalExamAnswer::where('submission_id', $submissionId)
            ->whereNotNull('answer_images')
            ->count();

        if ($answeredQuestions < $totalQuestions) {
            return back()->with('error', 
                "Please answer all questions. ($answeredQuestions/$totalQuestions answered)"
            );
        }

        // Submit the exam
        $submission->update([
            'status' => 'submitted',
            'submitted_at' => now()
        ]);

        return redirect()->route('student.final-exam.result', $submissionId)
            ->with('success', 'Exam submitted successfully! Your answers will be graded within 7 days.');
    }

    /**
     * View exam results
     */
    public function result($submissionId)
    {
        $submission = FinalExamSubmission::with([
            'exam.questions',
            'answers.question',
            'grader'
        ])->findOrFail($submissionId);

        // Check authorization
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('User.final_exam.result', compact('submission'));
    }

    /**
     * View my final exam submissions across all courses
     */
    public function mySubmissions()
    {
        $submissions = FinalExamSubmission::where('user_id', Auth::id())
            ->with(['exam.course'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('User.final_exam.my_submissions', compact('submissions'));
    }
}