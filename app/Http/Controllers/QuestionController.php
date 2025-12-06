<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Courses;
use App\Models\Queries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewQuestionNotification;
use App\Notifications\QuestionAnsweredNotification;
use App\Notifications\QuestionRejectedNotification;

class QuestionController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'question' => 'required|string|max:1000',
        'course_id' => 'required|exists:courses,id',
        'module_number' => 'required|integer',
    ]);

    $course = Courses::findOrFail($request->course_id);
    $instructorId = $course->instructor_id;

    $question = Queries::create([
        'user_id' => Auth::id(),
        'instructor_id' => $instructorId,
        'course_id' => $request->course_id,
        'module_number' => $request->module_number,
        'content' => $request->question,
    ]);

    $instructor = User::find($instructorId);
    $question->load('user');
    $instructor->notify(new NewQuestionNotification($question)); // Notify once

    return back()->with('success', 'Your question has been sent to the instructor.');
}

public function show($id)
{
    $question = Queries::findOrFail($id);
    
    // Check if the authenticated user is the instructor or the student who posted the question
    if (Auth::user()->id !== $question->instructor_id) {
        abort(403, 'Unauthorized access to this question.');
    }

    return view('instructor.view_question', compact('question'));
}

public function reject($id)
{
    $question = Queries::findOrFail($id);
    
    // Optional: Check if the user is authorized to reject
    if (auth()->id() !== $question->instructor_id) {
        abort(403, 'Unauthorized action.');
    }

    $question->status = 'rejected';
    $question->save();

    // Optional: Notify the student
    $question->user->notify(new QuestionRejectedNotification($question));
    auth()->user()->unreadNotifications
        ->where('type', 'App\Notifications\NewQuestionNotification')
        ->where(function($n) use ($question) {
            $data = $n->data;
            return $data['question_id'] == $question->id;
        })
        ->each->markAsRead();

    return redirect()->back()->with('success', 'Question rejected successfully.');
}
public function answer(Request $request, $id)
{
    $question = Queries::findOrFail($id);
    
    //  Check if the user is authorized to answer
    if (auth()->id() !== $question->instructor_id) {
        abort(403, 'Unauthorized action.');
    }

    $request->validate([
        'answer' => 'required|string|max:1000',
    ]);

    // Save the answer to the question
    $question->answer = $request->answer;
    $question->status = 'answered'; // Update status to answered
    $question->save();

    // Notify the student about the answer
    $question->user->notify(new QuestionAnsweredNotification($question));
    auth()->user()->unreadNotifications
        ->where('type', 'App\Notifications\NewQuestionNotification')
        ->where(function($n) use ($question) {
            $data = $n->data;
            return $data['question_id'] == $question->id;
        })
        ->each->markAsRead();

    return redirect()->back()->with('success', 'Answer submitted successfully.');
}
}