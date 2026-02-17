<?php

namespace App\Notifications;

use App\Models\DiscussionPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscussionNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(DiscussionPost $post)
    {
        $this->post = $post;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $rootThread = $this->post->getRootThread();
        
        $message = $this->post->isReply() 
            ? "{$this->post->user->name} has replied to the discussion: \"{$rootThread->title}\"."
            : "{$this->post->user->name} has created a new discussion: \"{$this->post->title}\".";

        return (new MailMessage)
            ->line($message)
            ->action('View Discussion', route('discussion.thread.show', [
                'forum' => $this->post->forum_id, 
                'thread' => $rootThread->id
            ]))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $rootThread = $this->post->getRootThread();
        
        $message = $this->post->isReply() 
            ? "{$this->post->user->name} has replied to the discussion: \"{$rootThread->title}\"."
            : "{$this->post->user->name} has created a new discussion: \"{$this->post->title}\".";

        return [
            'post_id' => $this->post->id,
            'thread_id' => $rootThread->id,
            'forum_id' => $this->post->forum_id,
            'posted_by' => $this->post->user->name,
            'message' => $message,
        ];
    }
}