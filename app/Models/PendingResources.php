<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingResources extends Model
{
     protected $table = 'pending_resources';
    protected $fillable = [
        'courseId',
        'moduleId',
        'videos',
        'pdf'
    ];
    public function pending_course()
    {
        return $this->belongsTo(PendingCourses::class, 'courseId');
    }
}
