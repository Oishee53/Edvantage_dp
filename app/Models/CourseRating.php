<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    protected $fillable = ['course_id', 'user_id', 'rating', 'review'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Courses::class);
    }
}
