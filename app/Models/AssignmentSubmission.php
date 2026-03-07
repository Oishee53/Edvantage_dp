<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Assignment;
use App\Models\User;
class AssignmentSubmission extends Model
{
    protected $fillable = [
    'assignment_id',
    'student_id',
    'pdf_path',
    'submitted_at',
    'score',
    'status',
    'graded_at'
];
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function files()
{
    return $this->hasMany(AssignmentSubmissionFile::class, 'submission_id');
}
}