<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionLike extends Model
{
    protected $fillable = [
        'discussion_post_id',
        'user_id',
        'type',
    ];

     public function post(): BelongsTo
    {
        return $this->belongsTo(DiscussionPost::class, 'discussion_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
