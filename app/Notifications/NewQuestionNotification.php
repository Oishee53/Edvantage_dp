<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewQuestionNotification extends Notification
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
            ->subject('New Question Posted')
            ->greeting('Hello!')
            ->line('A student has posted a question on your course/module.')
            ->line('Question: ' . $this->question->content)
            ->action('View Question',
                route('instructor.questions.show', $this->question->id))
            ->line('Thank you for being an instructor!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'question_id' => $this->question->id,
            'student_name' => $this->question->user->name,
            'content' => $this->question->content,
            'course_id' => $this->question->course_id,
            'module_number' => $this->question->module_number,
        ];
    }
}

