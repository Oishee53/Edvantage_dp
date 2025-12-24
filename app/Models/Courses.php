<?php

namespace App\Models;
use App\Models\CourseRating;
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
    public function ratings()
    {
        return $this->hasMany(CourseRating::class, 'course_id');
    }

public function averageRating()
{
    return round($this->ratings()->avg('rating'), 1);
}

}
