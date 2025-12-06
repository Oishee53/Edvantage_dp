<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseNotification extends Model
{
    protected $table = 'course_notifications';

    protected $fillable = [
        'pending_course_id',
        'instructor_id',
        'status',
        'is_read',
    ];
    public function course()
    {
        return $this->belongsTo(PendingCourses::class, 'pending_course_id', 'id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id', 'id');
    }
}
