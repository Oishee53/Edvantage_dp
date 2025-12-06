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
    public function review(PendingCourses $course)
{
    // Load all modules + their resources
    $modules = $course->modules()->with('materials')->get();

    return view('admin.submitted_courses.review', compact('course', 'modules'));
}
 public function show_modules($course_id)
    {
    $course = PendingCourses::findOrFail($course_id);

    $modules = range(1, $course->video_count); 
    return view('Admin.show_modules', compact('course', 'modules'));
    }
      public function approve($course_id)
    {
        DB::transaction(function () use ($course_id) {
            $pendingCourse = PendingCourses::findOrFail($course_id);

            // 1. Move pending course to courses table
            $course = Courses::create([
                'image' => $pendingCourse->image,
                'title' =>  $pendingCourse->title,
                'description' => $pendingCourse->description,
                'category' => $pendingCourse->category,
                'video_count' => $pendingCourse->video_count,
                'approx_video_length' => $pendingCourse->approx_video_length,
                'total_duration' => $pendingCourse->total_duration,
                'price' => $pendingCourse->price,
                'instructor_id' => $pendingCourse->instructor_id,
                
            ]);

            // 2. Move resources
            $pendingResources = PendingResources::where('courseId', $course_id)->get();

            foreach ($pendingResources as $res) {
                Resource::create([
                    'courseId' => $course->id,
                    'moduleId' => $res->moduleId,
                    'videos' => $res->videos,
                    'pdf' => $res->pdf,
                ]);
            }

            // 3. Remove from pending tables
            PendingResources::where('courseId', $course_id)->delete();
            PendingCourses::findOrFail($course_id)->delete();

            // 4. Update course notification
            $notification = CourseNotification::where('pending_course_id', $course_id)->first();
            if ($notification) {
                $notification->update([
                    'status' => 'accepted',
                    'is_read' => false
                ]);
            }
        $instructor = $course->instructor; // now works

        // Send approval notification (optional)
        if ($instructor) {
            $instructor->notify(new approveCourseNotification($course));
        }
        });
        return redirect('/pending-courses')->with('success', 'Course approved and moved to main courses.');
    }

    // Reject a course
   public function reject(Request $request, $course_id)
{
    DB::transaction(function () use ($course_id, $request) {
        // 1. Fetch pending course before deleting
        $course = PendingCourses::findOrFail($course_id);

        // 2. Delete pending resources
        PendingResources::where('courseId', $course_id)->delete();

        // 3. Delete pending course
        $course->delete();

        // 4. Update course notification
        $notification = CourseNotification::where('pending_course_id', $course_id)->first();
        if ($notification) {
            $notification->update([
                'status' => 'rejected'
            ]);
        }

        // 5. Notify instructor
        $instructor = $course->instructor; // assuming you have relationship in PendingCourses
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
}
