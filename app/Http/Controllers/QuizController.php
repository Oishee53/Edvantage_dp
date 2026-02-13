<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;  // ← ADD THIS LINE
use App\Models\Courses;
use App\Models\Question;
use App\Models\Option;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function create(Request $request)
    {
        $courseId = $request->course;
        $moduleNumber = $request->module;

        $course = Courses::findOrFail($courseId);

        return view('Resources.add_quiz', [
            'course' => $course,
            'moduleNumber' => $moduleNumber,
        ]);
    }

    public function store(Request $request, $courseId, $moduleNumber)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'question_count' => 'required|integer|min:1|max:20',
                'questions' => 'required|array',
                'questions.*.text' => 'required|string',
                'questions.*.correct' => 'required',
                'questions.*.options' => 'required|array|min:2',
                'questions.*.options.*.text' => 'required|string',
            ]);

            // 1. Create or update quiz
            $quiz = Quiz::updateOrCreate(
                [
                    'course_id' => $courseId,
                    'module_number' => $moduleNumber,
                ],
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'total_marks' => $request->question_count,
                ]
            );

            // 2. Delete old questions & options
            $quiz->questions()->each(function ($q) {
                $q->options()->delete();
                $q->delete();
            });

            // 3. Add new questions and options
            foreach ($request->questions as $qIndex => $qData) {
                $question = Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $qData['text'],
                ]);

                // Get the correct answer index
                $correctAnswer = $qData['correct'];

                foreach ($qData['options'] as $optIndex => $optData) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $optData['text'],
                        // FIXED: Compare string values correctly
                        'is_correct' => ($correctAnswer == $optIndex),
                    ]);
                }
            }

            // 4. If admin (role = 2), notify instructor
            $user = auth()->user();
            if ($user->role == 2) {
                $course = Courses::findOrFail($courseId);

                // Assuming `Courses` has a relation like `instructor()`
                $instructor = $course->instructor;

                if ($instructor) {
                    $instructor->notify(new \App\Notifications\CourseUpdatedNotification($course));
                }
            }

            return redirect()->route('modules.show', ['course_id' => $courseId])
                ->with('success', 'Quiz created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Quiz validation failed:', [
                'errors' => $e->errors(),
                'course_id' => $courseId,
                'module' => $moduleNumber
            ]);
            return back()
                ->withErrors($e->errors())
                ->withInput();

        } catch (\Exception $e) {
            Log::error('Database operation failed:', [
                'error' => $e->getMessage(),
                'course_id' => $courseId,
                'module' => $moduleNumber,
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withErrors(['database' => 'Failed to save quiz. Please try again.'])
                ->withInput();
        }
    }

    // Optional: Add method to handle quiz updates
    public function update(Request $request, $quizId)
    {
        try {
            $quiz = Quiz::findOrFail($quizId);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            $quiz->update($validated);

            return redirect()->back()
                ->with('success', 'Quiz updated successfully!');

        } catch (\Exception $e) {
            Log::error('Quiz update failed:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to update quiz.']);
        }
    }

    // Optional: Add method to delete quiz
    public function destroy($quizId)
    {
        try {
            $quiz = Quiz::findOrFail($quizId);
            
            // Delete all related questions and options
            $quiz->questions()->each(function ($q) {
                $q->options()->delete();
                $q->delete();
            });
            
            $quiz->delete();

            return redirect()->back()
                ->with('success', 'Quiz deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Quiz deletion failed:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to delete quiz.']);
        }
    }
}