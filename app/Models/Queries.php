<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queries extends Model
{
    protected $fillable = ['user_id', 'instructor_id', 'course_id', 'module_number', 'content'];

    public function instructor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function course() {
        return $this->belongsTo(Courses::class);
    }
}
