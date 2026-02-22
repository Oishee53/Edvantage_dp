<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class AssignmentDeadlineUpdatedNotification extends Notification
{
    protected $assignment;
    protected $oldDeadline;

    public function __construct($assignment, $oldDeadline)
    {
        $this->assignment = $assignment;
        $this->oldDeadline = $oldDeadline;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'assignment_id' => $this->assignment->id,
            'course_id' => $this->assignment->course_id, 
            'title' => $this->assignment->title,
            'old_deadline' => $this->oldDeadline,
            'new_deadline' => $this->assignment->deadline,
            'message' => 'Assignment deadline has been updated.'
        ];
    }
}