<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Models\PendingCourses;
use App\Models\PendingResources;
use App\Models\CourseNotification;
use Illuminate\Support\Facades\DB;
use App\Notifications\rejectCourseNotification;
use App\Notifications\approveCourseNotification;
use App\Notifications\editCourseNotification;

class CourseNotificatioController extends Controller
{
     public function sendNotification($courseId)
    {
        // find course
        $course = PendingCourses::findOrFail($courseId);

        // create notification entry
        CourseNotification::updateOrCreate(
    [
        'pending_course_id' => $course->id, // condition to find existing record
    ],
    [
        'instructor_id' => $course->instructor_id,
        'status'        => 'pending', // not approved yet
        'is_read'       => false,
    ]
);
        return redirect('/instructor_homepage')
                         ->with('success', 'Course submitted for review successfully.');
    }
     public function index()
    {
        $pendingCourses = CourseNotification::where('status', 'pending')->get();

        return view('admin.pending_courses', compact('pendingCourses'));
    }
    public function show_modules($course_id)
    {
        $course = PendingCourses::findOrFail($course_id);

        if ($course->course_type === 'live') {
            $modules = $course->liveSessions()->orderBy('session_number')->get();
        } else {
            $modules = range(1, $course->video_count);
        }

        return view('Admin.show_modules', compact('course', 'modules'));
    }

public function approve($course_id)
{
    DB::transaction(function () use ($course_id) {
        $pendingCourse = PendingCourses::findOrFail($course_id);
        $isLive = $pendingCourse->course_type === 'live';

        // 1. Move pending course to courses table
        $course = Courses::create([
            'course_type'         => $pendingCourse->course_type,
            'image'               => $pendingCourse->image,
            'title'               => $pendingCourse->title,
            'description'         => $pendingCourse->description,
            'category'            => $pendingCourse->category,
            'level'               => $pendingCourse->level,
            'video_count'         => $pendingCourse->video_count,
            'approx_video_length' => $pendingCourse->approx_video_length,
            'total_duration'      => $pendingCourse->total_duration,
            'price'               => $pendingCourse->price,
            'instructor_id'       => $pendingCourse->instructor_id,
        ]);

        if ($isLive) {
            // 2a. Move live sessions → course_live_sessions
            $pendingSessions = \App\Models\LiveSession::where('course_id', $course_id)->get();

            foreach ($pendingSessions as $session) {
                \App\Models\CourseLiveSession::create([
                    'course_id'        => $course->id,
                    'session_number'   => $session->session_number,
                    'title'            => $session->title,
                    'date'             => $session->date,
                    'start_time'       => $session->start_time,
                    'duration_minutes' => $session->duration_minutes,
                    'pdf'              => $session->pdf,
                    'status'           => 'scheduled',
                ]);
            }

            // 3a. Remove from live_sessions
            \App\Models\LiveSession::where('course_id', $course_id)->delete();

        } else {
            // 2b. Move recorded resources → resources
            $pendingResources = PendingResources::where('courseId', $course_id)->get();

            foreach ($pendingResources as $res) {
                Resource::create([
                    'courseId' => $course->id,
                    'moduleId' => $res->moduleId,
                    'videos'   => $res->videos,
                    'pdf'      => $res->pdf,
                ]);
            }

            // 3b. Remove from pending_resources
            PendingResources::where('courseId', $course_id)->delete();
        }

        // 4. Delete the pending course
        PendingCourses::findOrFail($course_id)->delete();

        // 5. Update course notification
        $notification = CourseNotification::where('pending_course_id', $course_id)->first();
        if ($notification) {
            $notification->update([
                'status'  => 'accepted',
                'is_read' => false,
            ]);
        }

        // 6. Notify instructor
        $instructor = $course->instructor;
        if ($instructor) {
            $instructor->notify(new approveCourseNotification($course));
        }
    });

    return redirect('/pending-courses')->with('success', 'Course approved and moved to main courses.');
}

public function reject(Request $request, $course_id)
{
    DB::transaction(function () use ($course_id, $request) {
        $course = PendingCourses::findOrFail($course_id);
        $isLive = $course->course_type === 'live';

        if ($isLive) {
            // Delete live sessions
            \App\Models\LiveSession::where('course_id', $course_id)->delete();
        } else {
            // Delete pending resources
            PendingResources::where('courseId', $course_id)->delete();
        }

        // Delete pending course
        $course->delete();

        // Update course notification
        $notification = CourseNotification::where('pending_course_id', $course_id)->first();
        if ($notification) {
            $notification->update(['status' => 'rejected']);
        }

        // Notify instructor
        $instructor = $course->instructor;
        if ($instructor) {
            $instructor->notify(new rejectCourseNotification(
                $course,
                $request->rejection_message
            ));
        }
    });

    return redirect('/pending-courses');
}
public function askForEdit(Request $request, PendingCourses $course)
{
    $request->validate([
        'edit_message' => 'required|string|max:1000'
    ]);
     $course->update([
            'status' => 'asked for review',
        ]);
    
    
    // Send notification to instructor
    $course->instructor->notify(new editCourseNotification(
        $course,
        $request->edit_message,
        auth()->user()->name
    ));
    
    return redirect()->back()->with('success', 'Edit request sent to instructor successfully!');
}

public function reviewLiveSession($course_id, $session_number)
{
    $course  = PendingCourses::findOrFail($course_id);
    $session = \App\Models\LiveSession::where('course_id', $course_id)
                                      ->where('session_number', $session_number)
                                      ->firstOrFail();

    return view('Admin.review_live_session', compact('course', 'session'));
}
}