<?php

namespace App\Http\Controllers;

use App\Models\Queries;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function viewNotification($id)
{
    $notification = auth()->user()->notifications()->find($id);

    // Redirect or show the related question
    return redirect()->route('instructor.questions.show', $notification->data['question_id']);
}

public function show($id)
{
    $question = Queries::findOrFail($id);

    // Allow only the student who asked the question
    if (auth()->user()->id !== $question->user_id) {
        abort(403, 'Unauthorized');
    }

    // Mark related notification as read (for both answered and rejected)
    foreach (auth()->user()->unreadNotifications as $notification) {
        if (
            in_array($notification->type, [
                \App\Notifications\QuestionAnsweredNotification::class,
                \App\Notifications\QuestionRejectedNotification::class
            ]) &&
            $notification->data['question_id'] == $id
        ) {
            $notification->markAsRead();
        }
    }

    return view('Student.view_question', compact('question'));
}

}
