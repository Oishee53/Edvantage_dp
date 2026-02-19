<?php


// =============================================
// App/Models/NotebookConversation.php
// =============================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotebookConversation extends Model
{
    protected $fillable = [
        'course_id', 'user_id', 'question', 'answer', 'source_chunks',
    ];

    protected $casts = [
        'source_chunks' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}