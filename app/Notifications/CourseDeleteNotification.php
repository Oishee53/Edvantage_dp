<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CourseDeleteNotification extends Notification
{
    use Queueable;

    protected $courseId;
    protected $courseTitle;
    protected $message;

    public function __construct($course, $message = null)
    {
        $this->courseId    = $course->id;
        $this->courseTitle = $course->title ?? 'Untitled Course';
        $this->message     = $message ?? "Your course '{$this->courseTitle}' was deleted by Admin.";
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id'    => $this->courseId,
            'course_title' => $this->courseTitle,
            'content'      => $this->message,
        ];
    }
}
