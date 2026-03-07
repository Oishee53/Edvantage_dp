<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Enrollment;
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

    /**
     * Main chat endpoint - handles conversation with function calling
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array', // conversation history from frontend
        ]);

        $userMessage = $request->message;
        $history = $request->history ?? [];

        try {
            // Build conversation with system prompt
            $messages = $this->buildMessages($userMessage, $history);

            // Call Gemini with function calling enabled
            $response = $this->callGeminiWithTools($messages);

            return response()->json([
                'success' => true,
                'message' => $response['message'],
                'function_used' => $response['function_used'] ?? null,
            ]);

        } catch (\Exception $e) {
            Log::error('Platform chatbot error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sorry, I encountered an error. Please try again.',
            ], 500);
        }
    }

    /**
     * Build messages array with system prompt
     */
    private function buildMessages(string $userMessage, array $history): array
    {
        $systemPrompt = $this->getSystemPrompt();

        $messages = [];

        // Add system context as first user message (Gemini doesn't have system role)
        if (empty($history)) {
            $messages[] = [
                'role' => 'user',
                'parts' => [['text' => $systemPrompt]]
            ];
            $messages[] = [
                'role' => 'model',
                'parts' => [['text' => 'Hello! I\'m your Edvantage assistant. I can help you find courses, get course details, answer platform questions, and more. What would you like to know?']]
            ];
        }

        // Add conversation history
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'], // 'user' or 'model'
                'parts' => [['text' => $msg['content']]]
            ];
        }

        // Add current user message
        $messages[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        return $messages;
    }

    /**
     * Call Gemini API with function calling (tools)
     */
    private function callGeminiWithTools(array $messages): array
    {
        $tools = $this->getAvailableTools();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(30)->post("{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}", [
            'contents' => $messages,
            'tools' => [$tools],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
            ],
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gemini API error: ' . $response->body());
        }

        $data = $response->json();
        $candidate = $data['candidates'][0] ?? null;

        if (!$candidate) {
            throw new \Exception('No response from Gemini');
        }

        // Check if Gemini wants to call a function
        $functionCall = $candidate['content']['parts'][0]['functionCall'] ?? null;

        if ($functionCall) {
            // Execute the function
            $functionResult = $this->executeFunction(
                $functionCall['name'],
                $functionCall['args'] ?? []
            );

            // Send function result back to Gemini for final answer
            $messages[] = [
                'role' => 'model',
                'parts' => [['functionCall' => $functionCall]]
            ];

            $messages[] = [
                'role' => 'user',
                'parts' => [[
                    'functionResponse' => [
                        'name' => $functionCall['name'],
                        'response' => ['result' => $functionResult]
                    ]
                ]]
            ];

            // Get final response from Gemini
            $finalResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(30)->post("{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}", [
                'contents' => $messages,
                'tools' => [$tools],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1024,
                ],
            ]);

            $finalData = $finalResponse->json();
            $finalText = $finalData['candidates'][0]['content']['parts'][0]['text'] ?? 'I found the information but had trouble formatting the response.';

            return [
                'message' => $finalText,
                'function_used' => $functionCall['name'],
            ];
        }

        // No function call - return direct text response
        $text = $candidate['content']['parts'][0]['text'] ?? 'I\'m not sure how to respond to that.';

        return [
            'message' => $text,
        ];
    }

    /**
     * Define available functions (tools) for Gemini
     */
    private function getAvailableTools(): array
    {
        return [
            'function_declarations' => [
                [
                    'name' => 'searchCourses',
                    'description' => 'Search for courses by keyword. Returns a list of matching courses with titles, descriptions, prices, and URLs.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'query' => [
                                'type' => 'string',
                                'description' => 'Search keyword or topic (e.g., "machine learning", "web development", "python")',
                            ],
                            'limit' => [
                                'type' => 'integer',
                                'description' => 'Maximum number of results to return (default 5)',
                            ],
                        ],
                        'required' => ['query'],
                    ],
                ],
                [
                    'name' => 'getCourseDetails',
                    'description' => 'Get detailed information about a specific course by its ID or title.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'course_id' => [
                                'type' => 'integer',
                                'description' => 'The course ID',
                            ],
                        ],
                        'required' => ['course_id'],
                    ],
                ],
                [
                    'name' => 'getMyEnrollments',
                    'description' => 'Get list of courses the current user is enrolled in. Only use if user asks about "my courses" or "enrolled courses".',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
                [
                    'name' => 'getBrowseLink',
                    'description' => 'Get the URL to browse all courses on the platform.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * Execute function calls from Gemini
     */
    private function executeFunction(string $functionName, array $args): array
    {
        return match ($functionName) {
            'searchCourses' => $this->searchCourses(
                $args['query'] ?? '',
                $args['limit'] ?? 5
            ),
            'getCourseDetails' => $this->getCourseDetails(
                $args['course_id'] ?? null
            ),
            'getMyEnrollments' => $this->getMyEnrollments(),
            'getBrowseLink' => $this->getBrowseLink(),
            default => ['error' => 'Unknown function'],
        };
    }

    /**
     * Search courses by keyword
     */
    private function searchCourses(string $query, int $limit = 5): array
    {
        $courses = Courses::where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('name', 'LIKE', "%{$query}%");
            })
            ->limit($limit)
            ->get();

        if ($courses->isEmpty()) {
            return [
                'found' => false,
                'message' => "No courses found matching '{$query}'",
            ];
        }

        return [
            'found' => true,
            'count' => $courses->count(),
            'courses' => $courses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'name' => $course->name,
                    'description' => substr($course->description, 0, 200),
                    'price' => $course->price,
                    'instructor' => $course->instructor->name ?? 'Unknown',
                    'url' => route('courses.details', $course->id),
                ];
            })->toArray(),
        ];
    }

    /**
     * Get course details by ID
     */
    private function getCourseDetails(?int $courseId): array
    {
        if (!$courseId) {
            return ['error' => 'Course ID is required'];
        }

        $course = Courses::with('instructor')->find($courseId);

        if (!$course) {
            return ['error' => 'Course not found'];
        }

        return [
            'id' => $course->id,
            'title' => $course->title,
            'name' => $course->name,
            'description' => $course->description,
            'price' => $course->price,
            'video_count' => $course->video_count,
            'duration' => $course->duration ?? 'Not specified',
            'level' => $course->level ?? 'All levels',
            'instructor' => [
                'name' => $course->instructor->name ?? 'Unknown',
                'bio' => $course->instructor->bio ?? null,
            ],
            'url' => route('courses.details', $course->id),
            'enroll_url' => route('cart.add', $course->id),
        ];
    }

    /**
     * Get user's enrolled courses
     */
    private function getMyEnrollments(): array
    {
        if (!auth()->check()) {
            return [
                'error' => 'User not logged in',
                'message' => 'Please log in to see your enrolled courses.',
            ];
        }

        $enrollments = Enrollment::where('user_id', auth()->id())
            ->with('course')
            ->get();

        if ($enrollments->isEmpty()) {
            return [
                'found' => false,
                'message' => 'You are not enrolled in any courses yet.',
            ];
        }

        return [
            'found' => true,
            'count' => $enrollments->count(),
            'courses' => $enrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->course->id,
                    'title' => $enrollment->course->title,
                    'name' => $enrollment->course->name,
                    'url' => route('user.course.modules', $enrollment->course->id),
                ];
            })->toArray(),
        ];
    }

    /**
     * Get browse all courses link
     */
    private function getBrowseLink(): array
    {
        return [
            'url' => route('courses.all'),
            'text' => 'Browse All Courses',
        ];
    }

    /**
     * System prompt that defines chatbot behavior
     */
    private function getSystemPrompt(): string
    {
        return <<<PROMPT
You are a helpful assistant for Edvantage, an online learning platform.

Your capabilities:
- Search for courses by topic/keyword
- Get detailed information about specific courses
- Show user's enrolled courses (if logged in)
- Answer general questions about the platform

Guidelines:
- Be friendly, concise, and helpful
- When users ask about courses, use the searchCourses function
- When users ask for course details, use getCourseDetails function
- Always provide clickable links when mentioning courses
- If users ask about their enrollments, use getMyEnrollments function
- For questions about platform features, answer based on common e-learning platform features
- If you don't know something, be honest and suggest browsing all courses

Platform info:
- Platform name: Edvantage
- Features: Video lectures, quizzes, discussion forums, certificates, AI study assistant
- Payment: One-time purchase per course
PROMPT;
    }
}