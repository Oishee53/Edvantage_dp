<?php

namespace App\Observers;

use App\Models\Resource;
use App\Models\DiscussionForum;
use Illuminate\Support\Facades\Cache;

class ResourceObserver
{
    /**
     * Handle the Resource "created" event.
     */
    public function created(Resource $resource): void
    {
        // Auto-create a discussion forum for this module/resource
        DiscussionForum::create([
            'course_id' => $resource->courseId,
            'module_id' => $resource->id,
            'title' => 'Module ' . $resource->moduleId . ' - Discussion',
            'is_active' => true,
        ]);
    }

    /**
     * Handle the Resource "updated" event.
     */
    public function updated(Resource $resource): void
    {
        // Optional: Update forum title if module changes
        // $resource->forum?->update([
        //     'title' => 'Module ' . $resource->moduleId . ' - Discussion',
        // ]);
    }

    /**
     * Handle the Resource "deleted" event.
     */
    public function deleted(Resource $resource): void
    {
        // Forum will auto-delete due to cascade, but you can add logging here
        Cache::forget("forum_threads_{$resource->id}");
    }

    /**
     * Handle the Resource "restored" event.
     */
    public function restored(Resource $resource): void
    {
        //
    }

    /**
     * Handle the Resource "force deleted" event.
     */
    public function forceDeleted(Resource $resource): void
    {
        //
    }
}