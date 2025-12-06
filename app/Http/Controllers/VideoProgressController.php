<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\Resource;
use App\Models\Courses;
use App\Models\User;



class VideoProgressController extends Controller
{
    public function save(Request $request)
{
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'resource_id' => 'required|exists:resources,id',
        'progress_percent' => 'required|numeric|min:0|max:100',
    ]);

    $userId = auth()->id();

    // Fetch existing progress or create new
    $videoProgress = VideoProgress::firstOrNew([
        'user_id' => $userId,
        'course_id' => $request->course_id,
        'resource_id' => $request->resource_id,
    ]);

    // Update progress only if new percent is higher
    if ($request->progress_percent > $videoProgress->progress_percent) {
        $videoProgress->progress_percent = $request->progress_percent;
    }

  
    if ($videoProgress->progress_percent >= 90) {
        $videoProgress->is_completed = true;
        $videoProgress->progress_percent = 100; // Cap at 100%
    }

    $videoProgress->save();

    return response()->json([
        'success' => true,
        'progress_percent' => $videoProgress->progress_percent,
        'is_completed' => $videoProgress->is_completed,
    ]);
}


}


