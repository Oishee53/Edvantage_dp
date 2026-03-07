<?php
// =============================================
// App/Models/NotebookDocument.php
// =============================================
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotebookDocument extends Model
{
    protected $fillable = [
        'course_id', 'user_id', 'title', 'file_name',
        'file_path', 'file_type', 'chunk_count', 'status',
    ];

    public function chunks(): HasMany
    {
        return $this->hasMany(NotebookChunk::class, 'document_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}





