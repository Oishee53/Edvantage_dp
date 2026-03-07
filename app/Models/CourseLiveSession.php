<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLiveSession extends Model
{
    protected $table = 'course_live_sessions';

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

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}