<?php

namespace App\Http\Controllers;
use App\Models\Courses;
use App\Services\RecommendationService;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
{
    $user = auth()->user();
    return view('user.profile', compact('user'));
}
public function homepage(RecommendationService $recommendationService)
{
    $user = auth()->user();

    // Existing homepage logic
    $courses = Courses::withCount('quizzes')
        ->get()
        ->filter(function ($course) {
            return $course->quizzes_count == $course->video_count;
        });

    $uniqueCategories = $courses->pluck('category')->unique();

    // 🔥 RECOMMENDED COURSES
    $recommendedCourses = [];

    if ($user) {
        $recommendedCourses = $recommendationService
            ->getRecommendedCourses($user->id);
    }

    return view('homepage', compact(
        'user',
        'courses',
        'uniqueCategories',
        'recommendedCourses'
    ));
}


}
