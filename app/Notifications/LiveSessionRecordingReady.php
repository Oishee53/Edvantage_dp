<?php

namespace App\Notifications;

use App\Models\CourseLiveSession;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class LiveSessionRecordingReady extends Notification implements ShouldQueue
{
    use Queueable;

    public CourseLiveSession $session;

    public function __construct(CourseLiveSession $session)
    {
        $this->session = $session;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $courseName   = $this->session->course->name ?? 'your course';
        $sessionTitle = $this->session->title ?? 'Session ' . $this->session->session_number;

        return (new MailMessage)
            ->subject("Recording Ready: {$sessionTitle}")
            ->greeting("Hi {$notifiable->name},")
            ->line("The recording for **{$sessionTitle}** from **{$courseName}** is now available.")
            ->line("You can watch it anytime from your course page.")
            ->action('Watch Recording', url("/courses/{$this->session->course_id}/sessions/{$this->session->session_number}/watch"))
            ->line('Thank you for learning with Edvantage!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'           => 'recording_ready',
            'session_id'     => $this->session->id,
            'session_number' => $this->session->session_number,
            'session_title'  => $this->session->title ?? 'Session ' . $this->session->session_number,
            'course_id'      => $this->session->course_id,
            'course_name'    => $this->session->course->name ?? '',
            'playback_id'    => $this->session->mux_playback_id,
            'message'        => 'Recording is now available for ' . ($this->session->title ?? 'Session ' . $this->session->session_number),
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}