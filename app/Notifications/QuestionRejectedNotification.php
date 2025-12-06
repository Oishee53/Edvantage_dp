<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionRejectedNotification extends Notification
{
    use Queueable;

    protected $question;

    public function __construct($question)
    {
        $this->question = $question;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Question Was Rejected')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->action('View Details', url('/student/questions/' . $this->question->id))
            ->line('Unfortunately, your question has been rejected by the instructor.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'question_id' => $this->question->id,
            'student_name' => $this->question->user->name,
            'instructor_name' => $this->question->instructor->name,
            'content' => $this->question->content,
            'course_id' => $this->question->course_id,
            'module_number' => $this->question->module_number,
        ];
    }
}

