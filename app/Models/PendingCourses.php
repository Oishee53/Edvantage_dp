<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PendingResources;
use App\Models\CourseNotification;
use App\Models\User;

class PendingCourses extends Model
{
    protected $table = 'pending_courses';

    // Manually generating IDs
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'image',
        'title',
        'description',
        'category',
        'video_count',
        'approx_video_length',
        'total_duration',
        'price',
        'prerequisite',
        'instructor_id',
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function pendingResources()
    {
        return $this->hasMany(PendingResources::class, 'courseId');
    }

    // Boot method for cascading deletes and ID generation
    protected static function booted()
    {
        // Cascading delete for related pending resources
        static::deleting(function ($course) {
            $course->pendingResources()->delete();
    });

        // Generate unique Pxxxxx ID
        static::creating(function ($model) {
            if (!$model->id) {
                // Get the latest ID from pending_courses
                $latestPending = self::where('id', 'like', 'P%')
                                     ->orderBy('id', 'desc')
                                     ->value('id') ?? 'P00000';

                // Get the latest ID from course_notifications
                $latestNotification = CourseNotification::where('pending_course_id', 'like', 'P%')
                                                       ->orderBy('pending_course_id', 'desc')
                                                       ->value('pending_course_id') ?? 'P00000';

                // Extract numeric parts
                $pendingNumber = intval(substr($latestPending, 1));
                $notificationNumber = intval(substr($latestNotification, 1));

                // Take the maximum and increment
                $nextNumber = max($pendingNumber, $notificationNumber) + 1;

                // Assign new ID
                $model->id = 'P' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
