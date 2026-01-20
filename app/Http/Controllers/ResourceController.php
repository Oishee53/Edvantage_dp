<?php

namespace App\Http\Controllers;


use App\Models\Quiz;
use App\Models\Courses;
use App\Models\Resource;
use App\Models\DiscussionForum;
use Illuminate\Http\Request;
use App\Models\PendingCourses;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Container\Attributes\Log;

class ResourceController extends Controller
{
    public function viewCourses(){
    if(Auth::user()->role === 2) {
        $courses = Courses::all();
        return view('Resources.course_list', compact('courses'));
    } 
    elseif (Auth::user()->role === 3) {
        $instructorId = auth()->user()->id;
        $courses = Courses::where('instructor_id', $instructorId)->get();
        $pendingCourses = PendingCourses::where('instructor_id', $instructorId)->get();
        return view('Resources.course_list', compact('courses','pendingCourses', 'instructorId'));
    }
    }
    public function viewPage()
    {
    $courses = Courses::all();
    return view('Resources.view_resources', compact('courses'));
    }
public function showModules($course_id)
{
    $course = Courses::findOrFail($course_id);

    $user = auth()->user();

    $quizModules = collect();
    $resourceModules = collect();

    if ($user->role === 3) {
        // Students: only check quizzes
        $quizModules = DB::table('quizzes')
            ->where('course_id', $course_id)
            ->pluck('module_number');
         $user->unreadNotifications()
            ->where('type', 'App\\Notifications\\approveCourseNotification')
            ->where('data->course_id', $course_id) // JSON field check
            ->update(['read_at' => now()]);
    } elseif ($user->role === 2) {
        // Instructors/Admins: check both quizzes and resources separately
        $quizModules = DB::table('quizzes')
            ->where('course_id', $course_id)
            ->pluck('module_number');

        $resourceModules = DB::table('resources')
            ->where('courseId', $course_id)
            ->pluck('moduleId');
    }

    // Normalize IDs to integers
    $quizModules     = $quizModules->map(fn($id) => (int) $id)->values()->all();
    $resourceModules = $resourceModules->map(fn($id) => (int) $id)->values()->all();

    // Build modules with separate upload status
    $modules = [];
    for ($i = 1; $i <= (int) $course->video_count; $i++) {
        $modules[] = [
            'id'        => $i,
            'quiz'      => in_array($i, $quizModules, true),
            'resource'  => in_array($i, $resourceModules, true),
        ];
    }

    return view('Resources.show_modules', compact('course', 'modules'));
}




    public function editModule($course_id, $module_id){
    $course = Courses::findOrFail($course_id);

    if ($module_id < 1 || $module_id > $course->video_count) {
        abort(404); 
    }

    return view('Resources.edit_module', compact('course', 'module_id'));
}
public function addModule(Request $request){
    $courseId = $request->course;
    $moduleNumber = $request->module;

    $course = Courses::findOrFail($courseId);

    // Check if this module has a quiz
    $hasQuiz = DB::table('quizzes')
        ->where('course_id', $courseId)
        ->where('module_number', $moduleNumber)
        ->exists();

    // Check if this module has a resource
    $hasResource = DB::table('resources')
        ->where('courseId', $courseId)
        ->where('moduleId', $moduleNumber)
        ->exists();

    return view('Resources.module_management', [
        'course' => $course,
        'moduleNumber' => $moduleNumber,
        'quiz' => $hasQuiz,
        'resource' => $hasResource,
    ]);
}


    public function showInsideModule($courseId, $moduleNumber)
{
    $resource = Resource::where('courseId', $courseId)->where('moduleId', $moduleNumber)->firstOrFail();
    $course = Courses::findOrFail($courseId);
    $quiz = Quiz::where('course_id', $courseId)
                ->where('module_number', $moduleNumber)
                ->first();
    $questions = $quiz ? $quiz->questions : collect();
    $forum = DiscussionForum::where('course_id', $courseId)
        ->where('module_id', $resource->id) 
        ->first(); 
                

    return view('Admin.inside_module', [
        'course' => $course,
        'quiz' => $quiz,
        'questions' => $questions,
        'moduleNumber' => $moduleNumber,
        'resource' => $resource,
        'forum' => $forum,
    ]);
}

 
}
