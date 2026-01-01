<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Services\RecommendationService;

class LandingController extends Controller
{
    public function showLanding(RecommendationService $recommendationService)
{   
    $courses = Courses::with(['ratings'])
        ->withCount('quizzes')
        ->get()
        ->filter(function ($course) {
            return $course->quizzes_count == $course->video_count;
        });

    $uniqueCategories = $courses->pluck('category')->unique();

    // 🔥 STEP 6: GET RECOMMENDED COURSES
    $recommendedCourses = [];

    if (auth()->check()) {
        $recommendedCourses = $recommendationService
            ->getRecommendedCourses(auth()->id());
    }

    return response()
        ->view('landing', compact(
            'courses',
            'uniqueCategories',
            'recommendedCourses'
        ))
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
}
}
