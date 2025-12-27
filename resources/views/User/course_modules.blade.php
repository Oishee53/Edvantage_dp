<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - lectures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accent { color: #0E1B33; }
        .bg-accent { background-color: #0E1B33; }
        .border-accent { border-color: #0E1B33; }
        .hover\:bg-accent:hover { background-color: #0E1B33; }
        .hover\:text-accent:hover { color: #0E1B33; }
        .hover\:border-accent:hover { border-color: #0E1B33; }
        
        .final-exam-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: .8;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Course Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                    <p class="text-gray-600 mt-1">Course lectures</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ count($modules) }} Lectures</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Self-paced</span>
                </div>
            </div>
        </div>

        <!-- Modules List -->
        <div class="space-y-4">
            @forelse ($modules as $moduleNumber)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-accent/20 transition-all duration-200 group">
                    <a href="{{ route('inside.module', ['courseId' => $course->id, 'moduleNumber' => $moduleNumber]) }}" 
                       class="block p-6 hover:bg-gray-50/50 rounded-lg transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <!-- Module Number Badge -->
                                <div class="w-12 h-12 bg-gray-100 group-hover:bg-accent group-hover:text-white rounded-lg flex items-center justify-center font-semibold text-gray-700 transition-all duration-200">
                                    {{ $moduleNumber }}
                                </div>
                                
                                <!-- Module Info -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-accent transition-colors duration-200">
                                        Lecture {{ $moduleNumber }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Click to access lectures content
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status and Arrow -->
                            <div class="flex items-center gap-3">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                    Available
                                </span>
                                
                                <!-- Arrow Icon -->
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-accent group-hover:translate-x-1 transition-all duration-200" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No lectures found</h3>
                    <p class="text-gray-600">This course doesn't have any lectures yet. Check back later!</p>
                </div>
            @endforelse
        </div>

        <!-- 🆕 FINAL EXAM SECTION -->
        @php
            // Check if course has a published final exam
            $finalExam = \App\Models\FinalExam::where('course_id', $course->id)
                ->where('status', 'published')
                ->first();
            
            // Get user's submission if exists
            $submission = null;
            if ($finalExam && auth()->check()) {
                $submission = \App\Models\FinalExamSubmission::where('final_exam_id', $finalExam->id)
                    ->where('user_id', auth()->id())
                    ->first();
            }
        @endphp

        @if($finalExam)
            <div class="mt-8">
                <!-- Divider -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex-1 h-px bg-gray-300"></div>
                    <span class="text-gray-500 font-medium text-sm uppercase tracking-wide">Final Assessment</span>
                    <div class="flex-1 h-px bg-gray-300"></div>
                </div>

                <!-- Final Exam Card -->
                <div class="final-exam-banner rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8 text-white">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold">📝 Final Exam</h2>
                                    <p class="text-white/90 text-sm mt-1">{{ $finalExam->title }}</p>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            @if($submission)
                                @if($submission->status === 'not_started' || $submission->status === 'in_progress')
                                    <span class="px-4 py-2 bg-yellow-500/20 backdrop-blur-sm text-yellow-100 text-sm font-semibold rounded-full border border-yellow-400/30">
                                        Not Completed
                                    </span>
                                @elseif($submission->status === 'submitted')
                                    <span class="px-4 py-2 bg-blue-500/20 backdrop-blur-sm text-blue-100 text-sm font-semibold rounded-full border border-blue-400/30 pulse-animation">
                                        ⏳ Awaiting Grading
                                    </span>
                                @elseif($submission->status === 'graded')
                                    @if($submission->percentage >= 70)
                                        <span class="px-4 py-2 bg-green-500/20 backdrop-blur-sm text-green-100 text-sm font-semibold rounded-full border border-green-400/30">
                                            ✅ Passed ({{ $submission->percentage }}%)
                                        </span>
                                    @else
                                        <span class="px-4 py-2 bg-red-500/20 backdrop-blur-sm text-red-100 text-sm font-semibold rounded-full border border-red-400/30">
                                            ❌ Failed ({{ $submission->percentage }}%)
                                        </span>
                                    @endif
                                @endif
                            @else
                                <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-full border border-white/30">
                                    Not Started
                                </span>
                            @endif
                        </div>

                        @if($finalExam->description)
                            <p class="text-white/90 mb-6">{{ $finalExam->description }}</p>
                        @endif

                        <!-- Exam Stats -->
                        <div class="grid grid-cols-4 gap-4 mb-6">
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-white/70 text-xs uppercase tracking-wide mb-1">Questions</div>
                                <div class="text-2xl font-bold">{{ $finalExam->questions()->count() }}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-white/70 text-xs uppercase tracking-wide mb-1">Total Marks</div>
                                <div class="text-2xl font-bold">{{ $finalExam->total_marks }}</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-white/70 text-xs uppercase tracking-wide mb-1">Duration</div>
                                <div class="text-2xl font-bold">{{ $finalExam->duration_minutes }}m</div>
                            </div>
                            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                                <div class="text-white/70 text-xs uppercase tracking-wide mb-1">Passing</div>
                                <div class="text-2xl font-bold">70%</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-4">
                            @if(!$submission || $submission->status === 'not_started')
                                <!-- Not Started -->
                                <a href="{{ route('student.final-exam.show', $course->id) }}" 
                                   class="flex-1 bg-white text-purple-700 font-semibold py-4 px-6 rounded-lg hover:bg-gray-100 transition-all duration-200 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    🚀 Start Final Exam
                                </a>
                                
                            @elseif($submission->status === 'in_progress')
                                <!-- In Progress -->
                                <a href="{{ route('student.final-exam.start', $finalExam->id) }}" 
                                   class="flex-1 bg-yellow-500 text-white font-semibold py-4 px-6 rounded-lg hover:bg-yellow-600 transition-all duration-200 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    ⏯️ Continue Exam (In Progress)
                                </a>
                                
                            @elseif($submission->status === 'submitted')
                                <!-- Submitted - Awaiting Grading -->
                                <div class="flex-1 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white font-semibold py-4 px-6 rounded-lg text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Submitted - Awaiting Grading</span>
                                    </div>
                                    <div class="text-sm text-white/70 mt-2">
                                        Submitted on {{ $submission->submitted_at->format('M d, Y - g:i A') }}
                                    </div>
                                </div>
                                
                            @elseif($submission->status === 'graded')
                                <!-- Graded - View Results -->
                                <a href="{{ route('student.final-exam.result', $submission->id) }}" 
                                   class="flex-1 bg-white text-purple-700 font-semibold py-4 px-6 rounded-lg hover:bg-gray-100 transition-all duration-200 text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    📊 View Results & Feedback
                                </a>
                            @endif

                            <!-- Info Button -->
                            <a href="{{ route('student.final-exam.show', $course->id) }}" 
                               class="bg-white/10 backdrop-blur-sm border border-white/30 text-white font-semibold py-4 px-6 rounded-lg hover:bg-white/20 transition-all duration-200 text-center">
                                ℹ️ Details
                            </a>
                        </div>

                        <!-- Important Notice -->
                        @if(!$submission || $submission->status === 'not_started')
                            <div class="mt-6 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg p-4">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <div class="text-sm text-white/90">
                                        <strong class="text-white">Important:</strong> Complete all lectures before taking the final exam. 
                                        You'll need to upload photos of your handwritten answers. Passing score is 70%.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html>