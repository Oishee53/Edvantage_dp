<?php

namespace App\Notifications;

use App\Models\DiscussionPost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscussionReactionNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $reactionType;
    protected $reactedBy;

    public function __construct(DiscussionPost $post, string $reactionType, User $reactedBy)
    {
        $this->post = $post;
        $this->reactionType = $reactionType;
        $this->reactedBy = $reactedBy;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $rootThread = $this->post->getRootThread();
        $reactionText = $this->reactionType === 'like' ? 'liked' : 'disliked';
        
        return (new MailMessage)
            ->line("{$this->reactedBy->name} has {$reactionText} your comment in the discussion: \"{$rootThread->title}\".")
            ->action('View Discussion', route('discussion.thread.show', [
                'forum' => $this->post->forum_id, 
                'thread' => $rootThread->id
            ]))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        $rootThread = $this->post->getRootThread();
        $reactionText = $this->reactionType === 'like' ? 'liked' : 'disliked';
        
        return [
            'post_id' => $this->post->id,
            'thread_id' => $rootThread->id,
            'forum_id' => $this->post->forum_id,
            'reacted_by' => $this->reactedBy->name,
            'reacted_by_id' => $this->reactedBy->id,
            'reaction_type' => $this->reactionType,
            'message' => "{$this->reactedBy->name} has {$reactionText} your comment in the discussion: \"{$rootThread->title}\".",
        ];
    }
}