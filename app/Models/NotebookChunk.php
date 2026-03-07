<?php


// =============================================
// App/Models/NotebookChunk.php
// =============================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotebookChunk extends Model
{
    protected $fillable = [
        'document_id', 'course_id', 'content', 'embedding', 'chunk_index',
    ];

    // Store/retrieve embedding as PHP array automatically
    protected $casts = [
        'embedding' => 'array',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(NotebookDocument::class, 'document_id');
    }
}