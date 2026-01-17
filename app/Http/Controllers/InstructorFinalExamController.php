<?php

namespace App\Http\Controllers;

use App\Models\FinalExam;
use App\Models\FinalExamQuestion;
use App\Models\FinalExamSubmission;
use App\Models\FinalExamAnswer;
use App\Models\Courses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstructorFinalExamController extends Controller
{
    /**
     * Display list of exams for instructor's courses
     */
    public function index()
    {
        $instructor = Auth::user();
        
        // Get instructor's courses
        $courseIds = Courses::where('instructor_id', $instructor->id)
            ->pluck('id')
            ->toArray();
        
        // Get all final exams for these courses
        $exams = FinalExam::whereIn('course_id', $courseIds)
            ->with(['course', 'questions'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Instructor.final_exams.index', compact('exams'));
    }

    /**
     * Show form to create new exam - ULTRA SIMPLE VERSION
     */
    public function create(Request $request)
    {
        $instructor = Auth::user();
        
        // Get course_id from query parameter if provided
        $preSelectedCourseId = $request->query('course_id');
        
        // Get ALL instructor's courses - simple query
        $allCourses = Courses::where('instructor_id', $instructor->id)
            ->get();
        
        if ($allCourses->isEmpty()) {
            return redirect()->back()
                ->with('error', 'You have no courses. Please create a course first.');
        }
        
        // Get ALL final exams - simple query
        $allExams = FinalExam::all();
        
        // Build array of course IDs that already have exams
        $coursesWithExams = [];
        foreach ($allExams as $exam) {
            $coursesWithExams[] = $exam->course_id;
        }
        
        // Filter courses manually
        $availableCourses = [];
        foreach ($allCourses as $course) {
            if (!in_array($course->id, $coursesWithExams)) {
                $availableCourses[] = $course;
            }
        }
        
        if (empty($availableCourses)) {
            return redirect()->back()
                ->with('info', 'All your courses already have final exams.');
        }

        // Convert back to collection
        $courses = collect($availableCourses);

        return view('Instructor.final_exams.create', compact('courses', 'preSelectedCourseId'));
    }

    /**
     * Store new exam
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:30|max:480',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.marks' => 'required|integer|min:1',
            'questions.*.marking_criteria' => 'nullable|string',
            'publish_now' => 'nullable|boolean'
        ]);

        // Check if course already has an exam - simple check
        $existingExam = FinalExam::where('course_id', $validated['course_id'])->first();
        if ($existingExam) {
            return back()->withErrors(['course_id' => 'This course already has a final exam.'])->withInput();
        }

        // Verify the instructor owns this course
        $course = Courses::find($validated['course_id']);
        if (!$course || $course->instructor_id !== Auth::id()) {
            return back()->withErrors(['course_id' => 'You do not own this course.'])->withInput();
        }

        // Calculate passing marks (70% of total)
        $passingMarks = ceil($validated['total_marks'] * 0.7);

        // Verify sum of question marks equals total marks
        $sumMarks = 0;
        foreach ($validated['questions'] as $question) {
            $sumMarks += $question['marks'];
        }
        
        if ($sumMarks != $validated['total_marks']) {
            return back()->withErrors([
                'total_marks' => "Sum of question marks ($sumMarks) must equal total marks ({$validated['total_marks']})"
            ])->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Determine status
            $status = isset($validated['publish_now']) && $validated['publish_now'] ? 'published' : 'draft';
            
            // Create the exam
            $exam = new FinalExam();
            $exam->course_id = $validated['course_id'];
            $exam->instructor_id = Auth::id();
            $exam->title = $validated['title'];
            $exam->description = $validated['description'];
            $exam->total_marks = $validated['total_marks'];
            $exam->passing_marks = $passingMarks;
            $exam->duration_minutes = $validated['duration_minutes'];
            $exam->status = $status;
            $exam->published_at = $status === 'published' ? now() : null;
            $exam->save();

            // Create questions
            $questionNumber = 1;
            foreach ($validated['questions'] as $question) {
                $examQuestion = new FinalExamQuestion();
                $examQuestion->final_exam_id = $exam->id;
                $examQuestion->question_number = $questionNumber;
                $examQuestion->question_text = $question['question_text'];
                $examQuestion->marks = $question['marks'];
                $examQuestion->marking_criteria = $question['marking_criteria'] ?? null;
                $examQuestion->save();
                
                $questionNumber++;
            }
            
            DB::commit();

            $message = isset($validated['publish_now']) && $validated['publish_now'] 
                ? 'Final exam created and published successfully!'
                : 'Final exam created as draft. Publish it when ready.';

            return redirect('/instructor/manage_courses')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['error' => 'Failed to create exam: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Show specific exam details
     */
    public function show($id)
    {
        $exam = FinalExam::with(['course', 'questions'])
            ->findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Get submissions statistics - simple queries
        $allSubmissions = FinalExamSubmission::where('final_exam_id', $exam->id)->get();
        
        $totalSubmissions = $allSubmissions->count();
        $pendingGrading = 0;
        $graded = 0;
        $passed = 0;
        
        foreach ($allSubmissions as $submission) {
            if ($submission->status === 'submitted') {
                $pendingGrading++;
            }
            if ($submission->status === 'graded') {
                $graded++;
                if ($submission->percentage >= 70) {
                    $passed++;
                }
            }
        }

        return view('Instructor.final_exams.show', compact(
            'exam', 
            'totalSubmissions', 
            'pendingGrading', 
            'graded', 
            'passed'
        ));
    }

    /**
     * Edit exam
     */
    public function edit($id)
    {
        $exam = FinalExam::with('questions')->findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Can only edit if no submissions exist
        $hasSubmissions = FinalExamSubmission::where('final_exam_id', $exam->id)->exists();
        if ($hasSubmissions) {
            return redirect()->route('instructor.final-exams.show', $exam->id)
                ->with('error', 'Cannot edit exam with existing student submissions');
        }

        $courses = Courses::where('instructor_id', Auth::id())->get();

        return view('Instructor.final_exams.edit', compact('exam', 'courses'));
    }

    /**
     * Update exam
     */
    public function update(Request $request, $id)
    {
        $exam = FinalExam::findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Can only update if no submissions
        $hasSubmissions = FinalExamSubmission::where('final_exam_id', $exam->id)->exists();
        if ($hasSubmissions) {
            return redirect()->route('instructor.final-exams.show', $exam->id)
                ->with('error', 'Cannot update exam with existing student submissions');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:30|max:480',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.marks' => 'required|integer|min:1',
            'questions.*.marking_criteria' => 'nullable|string'
        ]);

        // Calculate passing marks
        $passingMarks = ceil($validated['total_marks'] * 0.7);

        // Verify sum of question marks
        $sumMarks = 0;
        foreach ($validated['questions'] as $question) {
            $sumMarks += $question['marks'];
        }
        
        if ($sumMarks != $validated['total_marks']) {
            return back()->withErrors([
                'total_marks' => "Sum of question marks must equal total marks"
            ])->withInput();
        }

        try {
            DB::beginTransaction();
            
            // Update exam
            $exam->title = $validated['title'];
            $exam->description = $validated['description'];
            $exam->total_marks = $validated['total_marks'];
            $exam->passing_marks = $passingMarks;
            $exam->duration_minutes = $validated['duration_minutes'];
            $exam->save();

            // Delete old questions
            FinalExamQuestion::where('final_exam_id', $exam->id)->delete();

            // Create new questions
            $questionNumber = 1;
            foreach ($validated['questions'] as $question) {
                $examQuestion = new FinalExamQuestion();
                $examQuestion->final_exam_id = $exam->id;
                $examQuestion->question_number = $questionNumber;
                $examQuestion->question_text = $question['question_text'];
                $examQuestion->marks = $question['marks'];
                $examQuestion->marking_criteria = $question['marking_criteria'] ?? null;
                $examQuestion->save();
                
                $questionNumber++;
            }
            
            DB::commit();

            return redirect()->route('instructor.final-exams.show', $exam->id)
                ->with('success', 'Exam updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withErrors(['error' => 'Failed to update exam: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Publish exam
     */
    public function publish($id)
    {
        $exam = FinalExam::findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($exam->status !== 'draft') {
            return back()->with('error', 'Exam is already published');
        }

        $exam->status = 'published';
        $exam->published_at = now();
        $exam->save();

        return redirect('/instructor/manage_courses')
            ->with('success', 'Exam published successfully! Students can now take it.');
    }

    /**
     * Unpublish exam
     */
    public function unpublish($id)
    {
        $exam = FinalExam::findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Cannot unpublish if submissions exist
        $hasSubmittedOrGraded = FinalExamSubmission::where('final_exam_id', $exam->id)
            ->whereIn('status', ['submitted', 'graded'])
            ->exists();
            
        if ($hasSubmittedOrGraded) {
            return back()->with('error', 'Cannot unpublish exam with submitted/graded answers');
        }

        $exam->status = 'draft';
        $exam->published_at = null;
        $exam->save();

        return redirect('/instructor/manage_courses')
            ->with('success', 'Exam unpublished successfully');
    }

    /**
     * Delete exam
     */
    public function destroy($id)
    {
        $exam = FinalExam::findOrFail($id);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Cannot delete if submissions exist
        $hasSubmissions = FinalExamSubmission::where('final_exam_id', $exam->id)->exists();
        if ($hasSubmissions) {
            return back()->with('error', 'Cannot delete exam with student submissions');
        }

        // Delete questions first
        FinalExamQuestion::where('final_exam_id', $exam->id)->delete();
        
        // Delete exam
        $exam->delete();

        return redirect('/instructor/manage_courses')
            ->with('success', 'Exam deleted successfully');
    }

    /**
     * View submissions for an exam
     */
    public function viewSubmissions($examId)
    {
        $exam = FinalExam::with(['course'])->findOrFail($examId);

        // Check authorization
        if ($exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $submissions = FinalExamSubmission::where('final_exam_id', $examId)
            ->whereIn('status', ['submitted', 'graded'])
            ->with('user')
            ->orderBy('submitted_at', 'asc')
            ->get();

        return view('Instructor.final_exams.submissions', compact('exam', 'submissions'));
    }

    /**
     * View and grade a specific submission
     */
    public function gradeSubmission($submissionId)
    {
        $submission = FinalExamSubmission::with([
            'exam.questions',
            'user',
            'answers.question'
        ])->findOrFail($submissionId);

        // Check authorization
        if ($submission->exam->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('Instructor.final_exams.grade', compact('submission'));
    }

    /**
     * Save grades for a submission
     */
   public function saveGrades(Request $request, $submissionId)
{
    $submission = FinalExamSubmission::with(['exam.questions', 'answers.question'])
        ->findOrFail($submissionId);

    // Check authorization
    if ($submission->exam->instructor_id !== Auth::id()) {
        abort(403, 'Unauthorized');
    }

    // Validate input
    $validated = $request->validate([
        'marks' => 'required|array',
        'marks.*' => 'required|numeric|min:0',
        'comments' => 'nullable|array',
        'comments.*' => 'nullable|string',
        'overall_feedback' => 'nullable|string|max:2000'
    ]);

    try {
        DB::beginTransaction();
        
        $totalScore = 0;

        // Process each answer
        foreach ($validated['marks'] as $answerId => $marksObtained) {
            $answer = FinalExamAnswer::findOrFail($answerId);
            
            // Validate marks don't exceed question max marks
            if ($marksObtained > $answer->question->marks) {
                DB::rollBack();
                return back()->withErrors([
                    'marks' => "Marks for Question {$answer->question->question_number} cannot exceed {$answer->question->marks}"
                ])->withInput();
            }

            // Update answer with marks and comment
            $answer->marks_obtained = $marksObtained;
            $answer->instructor_comment = $validated['comments'][$answerId] ?? null;
            $answer->save();

            $totalScore += $marksObtained;
        }

        // Calculate percentage
        $percentage = ($totalScore / $submission->exam->total_marks) * 100;

        // Update submission with grading info
        $submission->status = 'graded';
        $submission->total_score = $totalScore;
        $submission->percentage = round($percentage, 2);
        $submission->instructor_feedback = $validated['overall_feedback'] ?? null;
        $submission->graded_at = now();
        $submission->graded_by = Auth::id();
        $submission->save();
        
        DB::commit();

        return redirect()->route('instructor.final-exams.submissions', $submission->exam->id)
            ->with('success', 'Exam graded successfully! Student has been notified.');
            
    } catch (\Exception $e) {
        DB::rollBack();
        
        \Log::error('Failed to save grades', [
            'error' => $e->getMessage(),
            'submission_id' => $submissionId
        ]);
        
        return back()
            ->withErrors(['error' => 'Failed to save grades: ' . $e->getMessage()])
            ->withInput();
    }
}

























































}