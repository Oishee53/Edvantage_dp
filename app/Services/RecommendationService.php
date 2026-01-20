<?php

namespace App\Services;

use App\Models\Courses;
use App\Models\UserSearch;
use App\Models\Enrollment;

class RecommendationService
{
    public function getRecommendedCourses($userId, $limit = 6)
    {
        //  EXCLUDE ALL BOUGHT / ENROLLED COURSES
        $enrolledCourseIds = Enrollment::where('user_id', $userId)
            ->pluck('course_id');

        //  GET SEARCH KEYWORDS
        $keywords = UserSearch::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->pluck('keyword');

        //  STOP: new user → NO recommendation
        if ($purchasedCategories->isEmpty() && $keywords->isEmpty()) {
            return collect();
        }

        // 4️ Build recommendation query
        $query = Courses::whereNotIn('id', $enrolledCourseIds);

        //  MATCH BY SEARCH
        if ($keywords->count()) {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'LIKE', "%$keyword%")
                      ->orWhere('description', 'LIKE', "%$keyword%")
                      ->orWhere('category', 'LIKE', "%$keyword%");
                }
            });
        }

        return $query->latest()->limit($limit)->get();
    }
}