<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoProgress extends Model
{
    use HasFactory;
    
protected $fillable = ['user_id', 'course_id', 'resource_id', 'progress', 'is_completed'];

}

