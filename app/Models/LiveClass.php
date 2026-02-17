<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'schedule_datetime',
        'meeting_link'
    ];
}
