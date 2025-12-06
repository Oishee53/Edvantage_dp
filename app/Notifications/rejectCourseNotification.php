<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class rejectCourseNotification extends Notification
{
    use Queueable;

    protected $course;
    protected $rejectionMessage;

    /**
     * Create a new notification instance.
     */
    public function __construct($course, $rejectionMessage = null)
    {
        $this->course = $course;
        $this->rejectionMessage = $rejectionMessage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Course Submission Rejected - ' . $this->course->title)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We regret to inform you that your course "' . $this->course->title . '" has been rejected.')
            ->line('Course Title: ' . $this->course->title)
            ->line('Course Description: ' . $this->course->description)
            ->line('Course Created At: ' . $this->course->created_at);

        if ($this->rejectionMessage) {
            $mailMessage->line('Reason for rejection:')
                       ->line($this->rejectionMessage);
        }

        return $mailMessage
            ->line('Please review the feedback and make necessary changes before resubmitting.')
            ->action('View Course', url('/instructor/rejected_courses'))
            ->line('Thank you for using Edvantage platform!');
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'course_rejected',
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'course_description' => $this->course->description,
            'created_at' => $this->course->created_at,
            'rejection_message' => $this->rejectionMessage,
            'rejected_at' => now(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'course_rejected',
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'rejection_message' => $this->rejectionMessage,
        ];
    }
}