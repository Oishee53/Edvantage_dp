<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AssignmentSubmittedNotification extends Notification
{
    protected $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'assignment_id' => $this->submission->assignment_id,
            'student_name'  => $this->submission->student->name,
            'assignment_title' => $this->submission->assignment->title,
            'message' => 'A student has submitted an assignment.'
        ];
    }
}