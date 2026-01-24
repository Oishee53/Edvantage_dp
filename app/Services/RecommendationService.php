<?php

namespace App\Services;

use App\Models\Courses;
use App\Models\UserSearch;
use App\Models\Enrollment;

class RecommendationService
{
    public function getRecommendedCourses($userId, $limit = 6)
    {
        // 1️⃣ Courses already bought
        $enrolledCourseIds = Enrollment::where('user_id', $userId)
            ->pluck('course_id');

        // 2️⃣ Categories from purchased courses
        $purchasedCategories = Courses::whereIn('id', $enrolledCourseIds)
            ->pluck('category')
            ->unique();

        // 3️⃣ Recent search keywords
        $keywords = UserSearch::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->pluck('keyword');

        // 🛑 STOP: new user → NO recommendation
        if ($purchasedCategories->isEmpty() && $keywords->isEmpty()) {
            return collect();
        }

        // 4️⃣ Build recommendation query
        $query = Courses::whereNotIn('id', $enrolledCourseIds);

        $query->where(function ($q) use ($purchasedCategories, $keywords) {

            // 🔥 Priority 1: Purchased category
            if ($purchasedCategories->count()) {
                $q->orWhereIn('category', $purchasedCategories);
            }

            // 🔥 Priority 2: Search keywords
            foreach ($keywords as $keyword) {
                $q->orWhere('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhere('category', 'LIKE', "%{$keyword}%");
            }
        });

        return $query->latest()->limit($limit)->get();
    }
}
