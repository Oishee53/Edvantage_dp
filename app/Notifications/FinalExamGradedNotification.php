<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\FinalExamSubmission;

class FinalExamGradedNotification extends Notification
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
        $passed = $this->submission->percentage >= 70;
        
        return (new MailMessage)
            ->subject('Final Exam Graded - ' . $this->submission->exam->course->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your final exam for ' . $this->submission->exam->course->title . ' has been graded.')
            ->line('Exam: ' . $this->submission->exam->title)
            ->line('Score: ' . $this->submission->total_score . '/' . $this->submission->exam->total_marks . ' (' . $this->submission->percentage . '%)')
            ->line('Status: ' . ($passed ? '✓ Passed' : '✗ Failed'))
            ->action('View Results', route('student.final-exam.result', $this->submission->id))
            ->line($passed ? 'Congratulations on passing!' : 'Keep working hard!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        $passed = $this->submission->percentage >= 70;
        
        return [
            'type' => 'final_exam_graded',
            'submission_id' => $this->submission->id,
            'exam_id' => $this->submission->final_exam_id,
            'course_id' => $this->submission->exam->course_id,
            'course_title' => $this->submission->exam->course->title,
            'exam_title' => $this->submission->exam->title,
            'total_score' => $this->submission->total_score,
            'total_marks' => $this->submission->exam->total_marks,
            'percentage' => $this->submission->percentage,
            'passed' => $passed,
            'graded_at' => $this->submission->graded_at->toDateTimeString(),
            'message' => 'Your final exam for ' . $this->submission->exam->course->title . ' has been graded - ' . $this->submission->percentage . '%'
        ];
    }
}