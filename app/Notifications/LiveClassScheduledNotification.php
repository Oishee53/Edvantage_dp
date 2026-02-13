<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LiveClassScheduledNotification extends Notification
{
    use Queueable;

    public $liveClass;

    public function __construct($liveClass)
    {
        $this->liveClass = $liveClass;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'course_id' => $this->liveClass->course_id,
            'title' => $this->liveClass->title,
            'schedule' => $this->liveClass->schedule_datetime,
            'meeting_link' => $this->liveClass->meeting_link,
            'message' => 'New live class scheduled.'
        ];
    }
}
