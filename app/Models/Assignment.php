<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Courses;
use App\Models\AssignmentSubmission;

class Assignment extends Model
{
    protected $fillable = [
        'course_id',
        'created_by',
        'title',
        'description',
        'marks',
        'deadline'
    ];

    public function course()
{
    return $this->belongsTo(Courses::class, 'course_id');
}

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}