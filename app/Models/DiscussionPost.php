<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class DiscussionPost extends Model
{
    protected $fillable = [
        'forum_id',
        'user_id',
        'parent_id',
        'title',
        'content',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    // ==================== Relationships ====================
    
    public function forum(): BelongsTo
    {
        return $this->belongsTo(DiscussionForum::class, 'forum_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Parent post (if this is a reply)
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DiscussionPost::class, 'parent_id');
    }

    // Child replies (if this is a thread)
    public function replies(): HasMany
    {
        return $this->hasMany(DiscussionPost::class, 'parent_id');
    }

    // Get all replies recursively (for nested comments)
    public function allReplies(): HasMany
    {
        return $this->replies()->with('allReplies');
    }

    // ==================== Scopes ====================
    
    // Get only threads (top-level posts)
    public function scopeThreads(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    // Get only replies
    public function scopeReplies(Builder $query): Builder
    {
        return $query->whereNotNull('parent_id');
    }

    // Get pinned threads
    public function scopePinned(Builder $query): Builder
    {
        return $query->where('is_pinned', true);
    }

    // ==================== Helper Methods ====================
    
    // Check if this is a thread (top-level post)
    public function isThread(): bool
    {
        return $this->parent_id === null;
    }

    // Check if this is a reply
    public function isReply(): bool
    {
        return $this->parent_id !== null;
    }

    // Get reply count
    public function getReplyCountAttribute(): int
    {
        return $this->replies()->count();
    }

    // Get the root thread (for replies)
    public function getRootThread(): ?DiscussionPost
    {
        if ($this->isThread()) {
            return $this;
        }
        
        return $this->parent?->getRootThread();
    }

    // Check if user owns this post
    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    // ==================== Boot Method ====================
    
    protected static function booted()
    {
        // Automatically set is_pinned to false for replies
        static::creating(function ($post) {
            if ($post->parent_id !== null) {
                $post->is_pinned = false;
            }
        });
    }
}