<?php

namespace App\Services;

use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\UserSearch;

class RecommendationService
{
    private int $BEGINNER_THRESHOLD = 2;
    private int $INTERMEDIATE_THRESHOLD = 2;

    public function getRecommendedCourses(int $userId, int $limit = 6)
    {
        // 1️⃣ Get user's enrolled course IDs
        $enrolledCourseIds = Enrollment::where('user_id', $userId)
            ->pluck('course_id');

        $enrolledCourses = Courses::whereIn('id', $enrolledCourseIds)
            ->get();

        $recommendations = collect();

        // 2️⃣ Content + Level based progression
        $lastCourse = $enrolledCourses->last();
        if ($lastCourse) {
            $targetLevel = $this->determineTargetLevel(
                $lastCourse->category,
                $enrolledCourseIds
            );

            $contentKeywords = $this->extractKeywords($lastCourse);

            $contentBased = Courses::where('level', $targetLevel)
                ->whereNotIn('id', $enrolledCourseIds)
                ->where(function ($q) use ($contentKeywords) {
                    foreach ($contentKeywords as $word) {
                        $q->orWhere('title', 'LIKE', "%{$word}%")
                          ->orWhere('description', 'LIKE', "%{$word}%")
                          ->orWhere('category', 'LIKE', "%{$word}%");
                    }
                })
                ->withCount('quizzes') // ✅ load quizzes_count
                ->take($limit)
                ->get();

            $recommendations = $recommendations->merge($contentBased);
        }

        // 3️⃣ Co-enrollment: courses taken by users who took the same courses
        if ($enrolledCourseIds->isNotEmpty()) {
            $similarUsers = Enrollment::whereIn('course_id', $enrolledCourseIds)
                ->where('user_id', '!=', $userId)
                ->pluck('user_id');

            $coCourseIds = Enrollment::whereIn('user_id', $similarUsers)
                ->whereNotIn('course_id', $enrolledCourseIds)
                ->pluck('course_id');

            if ($coCourseIds->isNotEmpty()) {
                $coCourses = Courses::whereIn('id', $coCourseIds)
                    ->withCount('quizzes') // ✅ load quizzes_count
                    ->take($limit)
                    ->get();

                $recommendations = $recommendations->merge($coCourses);
            }
        }

        // 4️⃣ Search intent matching
        $keywords = UserSearch::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->pluck('keyword');

        if ($keywords->isNotEmpty()) {
            $searchMatches = Courses::whereNotIn('id', $enrolledCourseIds)
                ->where(function ($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('title', 'LIKE', "%{$keyword}%")
                          ->orWhere('description', 'LIKE', "%{$keyword}%")
                          ->orWhere('category', 'LIKE', "%{$keyword}%");
                    }
                })
                ->withCount('quizzes') // ✅ load quizzes_count
                ->take($limit)
                ->get();

            $recommendations = $recommendations->merge($searchMatches);
        }

        // 5️⃣ Cold start fallback: popular courses
        if ($recommendations->isEmpty()) {
            $popular = Courses::whereNotIn('id', $enrolledCourseIds)
                ->withCount('enrollments')  
                ->orderByDesc('enrollments_count')
                ->take($limit)
                ->withCount('quizzes') // ✅ load quizzes_count
                ->get();

            $recommendations = $recommendations->merge($popular);
        }

        // Final: unique + limit
        return $recommendations
            ->unique('id')
            ->take($limit);
    }

    // -------------------------
    // Extract keywords from a course
    private function extractKeywords(Courses $course): array
    {
        $text = strtolower(
            $course->title . ' ' .
            $course->description . ' ' .
            $course->category
        );

        $words = preg_split('/\W+/', $text);

        return collect($words)
            ->filter(fn ($w) => strlen($w) > 3)
            ->unique()
            ->take(6)
            ->toArray();
    }

    // -------------------------
    // Determine next level for a category
    private function determineTargetLevel(string $category, $enrolledCourseIds): string
    {
        $beginnerCount = Courses::whereIn('id', $enrolledCourseIds)
            ->where('category', $category)
            ->where('level', 'beginner')
            ->count();

        if ($beginnerCount < $this->BEGINNER_THRESHOLD) {
            return 'beginner';
        }

        $intermediateCount = Courses::whereIn('id', $enrolledCourseIds)
            ->where('category', $category)
            ->where('level', 'intermediate')
            ->count();

        if ($intermediateCount < $this->INTERMEDIATE_THRESHOLD) {
            return 'intermediate';
        }

        return 'advanced';
    }
}
