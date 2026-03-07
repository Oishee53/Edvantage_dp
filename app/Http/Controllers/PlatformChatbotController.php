<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Enrollment;
use App\Models\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlatformChatbotController extends Controller
{
    private string $apiKey;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function chat(Request $request)
    {
        try {
            if (!$this->apiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chatbot is not configured. Please contact administrator.',
                ], 500);
            }

            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $userMessage = $request->message;

            // Save search query if user is logged in
            if (auth()->check()) {
                UserSearch::create([
                    'user_id' => auth()->id(),
                    'keyword' => substr($userMessage, 0, 191),
                ]);
            }

            // Handle course-related queries
            if ($this->isAskingAboutCourses($userMessage)) {
                $response = $this->handleCourseQuery($userMessage);
                return response()->json([
                    'success' => true,
                    'message' => $response,
                ]);
            }

            // Handle "my courses" query
            if ($this->isAskingAboutMyEnrollments($userMessage)) {
                $response = $this->handleMyEnrollments();
                return response()->json([
                    'success' => true,
                    'message' => $response,
                ]);
            }

            // General questions - use Gemini
            $response = $this->callGemini($userMessage);
            return response()->json([
                'success' => true,
                'message' => $response,
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error. Please try again.',
            ], 500);
        }
    }

    private function isAskingAboutCourses(string $message): bool
    {
        $keywords = [
            'course', 'courses', 'find course', 'search course', 'show course',
            'machine learning', 'web development', 'python', 'data science',
            'programming', 'learn', 'learning', 'tutorial', 'class',
            'beginner', 'intermediate', 'advanced',
            'development', 'design', 'marketing', 'business',
            'javascript', 'react', 'node', 'django', 'java'
        ];

        $messageLower = strtolower($message);
        foreach ($keywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isAskingAboutMyEnrollments(string $message): bool
    {
        $messageLower = strtolower($message);
        return strpos($messageLower, 'my course') !== false || 
               strpos($messageLower, 'enrolled') !== false ||
               strpos($messageLower, 'my enrollment') !== false;
    }

    private function handleCourseQuery(string $message): string
    {
        $searchTerms = $this->extractSearchTerms($message);
        $query = Courses::query();
        
        // Search by keywords
        if (!empty($searchTerms)) {
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('title', 'LIKE', "%{$term}%")
                      ->orWhere('description', 'LIKE', "%{$term}%")
                      ->orWhere('category', 'LIKE', "%{$term}%");
                }
            });
        }

        // Filter by level if mentioned
        if (stripos($message, 'beginner') !== false) {
            $query->where('level', 'beginner');
        } elseif (stripos($message, 'intermediate') !== false) {
            $query->where('level', 'intermediate');
        } elseif (stripos($message, 'advanced') !== false) {
            $query->where('level', 'advanced');
        }

        // Filter by course type if mentioned
        if (stripos($message, 'live') !== false) {
            $query->where('course_type', 'live');
        } elseif (stripos($message, 'recorded') !== false) {
            $query->where('course_type', 'recorded');
        }

        $courses = $query->limit(5)->get();

        if ($courses->isEmpty()) {
            return "I couldn't find any courses matching your query. Browse all courses here: [View All Courses](" . route('courses.all') . ")";
        }

        $response = "**Here are some courses I found:**\n\n";
        
        foreach ($courses as $course) {
            $response .= "📚 **{$course->title}**\n";
            
            // Category badge
            if ($course->category) {
                $response .= "🏷️ Category: {$course->category}\n";
            }
            
            // Level
            $levelEmoji = [
                'beginner' => '🌱',
                'intermediate' => '📈',
                'advanced' => '🚀'
            ];
            $response .= ($levelEmoji[$course->level] ?? '📖') . " Level: " . ucfirst($course->level) . "\n";
            
            // Type
            $typeEmoji = $course->course_type === 'live' ? '🔴 Live' : '📹 Recorded';
            $response .= "{$typeEmoji}\n";
            
            // Duration
            if ($course->total_duration) {
                $response .= "⏱️ Duration: {$course->total_duration}\n";
            }
            
            // Price
            $response .= "💰 Price: **৳" . number_format($course->price, 0) . "**\n";
            
            // Links
            $response .= "[View Details](" . route('courses.details', $course->id) . ") | ";
            $response .= "[Add to Cart](" . route('cart.add', $course->id) . ")\n\n";
        }

        $response .= "---\n[🔍 Browse All Courses](" . route('courses.all') . ")";

        return $response;
    }

    private function handleMyEnrollments(): string
    {
        if (!auth()->check()) {
            return "🔒 Please log in to see your enrolled courses.\n\n[Login Here](/login)";
        }

        $enrollments = Enrollment::where('user_id', auth()->id())
            ->where('status', 'enrolled')
            ->with('course')
            ->get();

        if ($enrollments->isEmpty()) {
            return "📚 You haven't enrolled in any courses yet.\n\n[Browse Courses](" . route('courses.all') . ") to get started!";
        }

        $response = "**📚 Your Enrolled Courses:**\n\n";
        
        foreach ($enrollments as $enrollment) {
            $course = $enrollment->course;
            $response .= "• **{$course->title}**\n";
            $response .= "  Level: " . ucfirst($course->level) . " | ";
            $response .= ($course->course_type === 'live' ? '🔴 Live' : '📹 Recorded') . "\n";
            $response .= "  [📖 Go to Course](" . route('user.course.modules', $course->id) . ")\n\n";
        }

        return $response;
    }

    private function extractSearchTerms(string $message): array
    {
        $commonTopics = [
            'machine learning', 'ml', 'artificial intelligence', 'ai',
            'web development', 'frontend', 'backend', 'fullstack', 'full stack',
            'data science', 'data analysis', 'analytics',
            'python', 'java', 'javascript', 'js', 'typescript',
            'react', 'reactjs', 'angular', 'vue', 'vuejs',
            'node', 'nodejs', 'express', 'django', 'flask', 'laravel',
            'php', 'ruby', 'c++', 'c#', 'swift', 'kotlin',
            'marketing', 'digital marketing', 'seo', 'social media',
            'business', 'management', 'finance', 'accounting',
            'design', 'graphic design', 'ui', 'ux', 'ui/ux',
            'photoshop', 'illustrator', 'figma', 'sketch',
            'mobile', 'android', 'ios', 'flutter', 'react native'
        ];

        $messageLower = strtolower($message);
        $found = [];

        foreach ($commonTopics as $topic) {
            if (strpos($messageLower, $topic) !== false) {
                $found[] = $topic;
            }
        }

        // If no specific topics found, extract general words
        if (empty($found)) {
            $words = explode(' ', $messageLower);
            $stopWords = ['do', 'you', 'have', 'any', 'show', 'me', 'find', 'search', 'for', 'about', 'course', 'courses'];
            foreach ($words as $word) {
                if (strlen($word) > 3 && !in_array($word, $stopWords)) {
                    $found[] = $word;
                }
            }
        }

        return array_unique($found);
    }

    private function callGemini(string $userMessage): string
    {
        $systemPrompt = "You are a helpful assistant for Edvantage, an online learning platform. " .
                       "Be friendly, concise, and helpful. " .
                       "Platform features: Video lectures, quizzes, discussion forums, certificates, AI study assistant. " .
                       "We offer both live and recorded courses. " .
                       "Payment: One-time purchase per course. " .
                       "Keep responses brief (2-3 sentences) and friendly.";

        $response = Http::timeout(30)->post(
            "{$this->baseUrl}/models/gemini-2.5-flash:generateContent?key={$this->apiKey}",
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemPrompt . "\n\nUser question: " . $userMessage]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 256,
                ]
            ]
        );

        if (!$response->successful()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return "I can help you find courses! What topic are you interested in learning? 📚";
        }

        $data = $response->json();
        return $data['candidates'][0]['content']['parts'][0]['text'] ?? "I can help you find courses! What would you like to learn?";
    }
}