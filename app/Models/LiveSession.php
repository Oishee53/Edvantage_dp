<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    protected $table = 'live_sessions';

    protected $fillable = [
        'course_id',
        'session_number',
        'title',
        'date',
        'start_time',
        'duration_minutes',
        'pdf',
        'daily_room_name',
        'daily_room_url',
        'recording_url',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function pendingCourse()
    {
        return $this->belongsTo(PendingCourses::class, 'course_id');
    }
}