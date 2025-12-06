<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Resource;

class Courses extends Model
{
    protected $table = 'courses';
    protected $fillable = [
        'image',
        'title',
        'description',
        'category',
        'video_count',
        'approx_video_length',
        'total_duration',
        'price',
        'instructor_id'
    ];
    
 public function resources()
    {
        return $this->hasMany(Resource::class, 'courseId', 'id');
    }

    public function students()
{
    return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
}

   public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'id');
    }

public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id', 'id');
    }

 public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
     protected static function booted()
    {
        static::deleting(function ($course) {
            $course->resources()->delete();
            $course->enrollments()->delete(); // optional
        });
    }
}
