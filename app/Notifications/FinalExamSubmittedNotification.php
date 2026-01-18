<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FinalExamSubmission;

class FinalExamSubmittedNotification extends Notification
{
    use Queueable;

    protected $submission;

    public function __construct(FinalExamSubmission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Final Exam Submission - ' . $this->submission->exam->course->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line($this->submission->user->name . ' has submitted their final exam for ' . $this->submission->exam->course->title)
            ->line('Exam: ' . $this->submission->exam->title)
            ->line('Submitted at: ' . $this->submission->submitted_at->format('M d, Y h:i A'))
            ->action('Grade Submission', route('instructor.final-exams.grade', $this->submission->id))
            ->line('Please review and grade the submission at your earliest convenience.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'final_exam_submitted',
            'submission_id' => $this->submission->id,
            'exam_id' => $this->submission->final_exam_id,
            'course_id' => $this->submission->exam->course_id,
            'course_title' => $this->submission->exam->course->title,
            'exam_title' => $this->submission->exam->title,
            'student_name' => $this->submission->user->name,
            'student_id' => $this->submission->user_id,
            'submitted_at' => $this->submission->submitted_at->toDateTimeString(),
            'message' => $this->submission->user->name . ' submitted final exam for ' . $this->submission->exam->course->title
        ];
    }
}