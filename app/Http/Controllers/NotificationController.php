<?php

namespace App\Http\Controllers;

use App\Models\Queries;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

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

    public function markAsReadAndRedirect(DatabaseNotification $notification, Request $request)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Mark the notification as read
        $notification->markAsRead();

        // Get the redirect URL from query parameter
        $redirectUrl = $request->query('redirect');

        // Validate and redirect
        if ($redirectUrl) {
            return redirect($redirectUrl);
        }

        // Fallback redirect based on user role
        if (auth()->user()->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        } elseif (auth()->user()->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('dashboard');
    }

    public function read(DatabaseNotification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Mark as read
        $notification->markAsRead();

        // Redirect based on user role
        return back();
    }

}