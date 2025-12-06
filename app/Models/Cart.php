<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
public function course()
{
    return $this->belongsTo(Courses::class, 'course_id');
}


protected $fillable = [
        'user_id',
        'course_id',
        // add other columns if needed
    ];

}
