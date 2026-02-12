<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'course_id',
        'live_date',
        'live_time',
        'meet_link'
    ];

    public function course()
    {
        return $this->belongsTo(Courses::class,'course_id');
    }
}
