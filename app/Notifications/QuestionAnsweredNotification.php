<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAnsweredNotification extends Notification
{

    protected $question;

    /**
     * Create a new notification instance.
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Question Has Been Answered!')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your question has been answered by the instructor.')
            ->line('Question: ' . $this->question->content)
            ->action('View Answer', url('/student/questions/' . $this->question->id))
            ->line('Thank you for using our platform!');
    }

    /**
     * Store the notification in the database.
     */
    public function toDatabase($notifiable): array
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
