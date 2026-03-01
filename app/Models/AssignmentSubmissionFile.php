<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmissionFile extends Model
{
    protected $fillable = [
        'submission_id',
        'file_path'
    ];

    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class, 'submission_id');
    }
}