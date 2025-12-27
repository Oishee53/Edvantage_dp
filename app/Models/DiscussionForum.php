<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscussionForum extends Model
{
    protected $fillable = [
        'course_id',
        'module_id',
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Resource::class, 'module_id'); // Points to Resource model
    }

    public function threads(): HasMany
    {
        return $this->hasMany(DiscussionPost::class, 'forum_id');
    }

    // Get thread count
    public function getThreadCountAttribute(): int
    {
        return $this->threads()->whereNull('parent_id')->count();
    }
}