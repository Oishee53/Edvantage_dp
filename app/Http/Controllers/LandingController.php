<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

class LandingController extends Controller
{
public function showLanding()
{   
    $courses = Courses::withCount('quizzes')
        ->get()
        ->filter(function ($course) {
            return $course->quizzes_count == $course->video_count;
        });
    $uniqueCategories = $courses->pluck('category')->unique();

    return response()
        ->view('landing', compact('courses', 'uniqueCategories'))
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
}

}
