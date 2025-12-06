<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resources';
    protected $fillable = [
        'courseId',
        'moduleId',
        'videos',
        'pdf'
    ];
    public function course()
    {
        return $this->belongsTo(Courses::class, 'courseId');
    }
    
}
