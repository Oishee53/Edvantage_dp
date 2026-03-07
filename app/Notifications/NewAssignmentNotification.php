<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Assignment;

class NewAssignmentNotification extends Notification
{
    use Queueable;

    public $assignment;

    public function __construct(Assignment $assignment)
    {
        $this->assignment = $assignment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
{
    return [
        'title' => 'New Assignment Posted',
        'message' => $this->assignment->title,
        'assignment_id' => $this->assignment->id,
        'course_id' => $this->assignment->course_id,
        'deadline' => $this->assignment->deadline,
    ];
}
}
