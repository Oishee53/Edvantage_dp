<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AssignmentGradedNotification extends Notification
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
            'assignment_id' => $this->submission->assignment->id,
            'assignment_title' => $this->submission->assignment->title,
            'score' => $this->submission->score,
            'total_marks' => $this->submission->assignment->marks,
            'message' => 'Your assignment has been graded.'
        ];
    }
}