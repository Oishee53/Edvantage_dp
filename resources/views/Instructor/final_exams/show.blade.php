<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - Exam Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accent { color: #0E1B33; }
        .bg-accent { background-color: #0E1B33; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $exam->title }}</h1>
                    <p class="text-gray-600 mt-1">{{ $exam->course->title }}</p>
                </div>
                <div>
                    @if($exam->status === 'draft')
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 font-semibold rounded-full">
                            📄 Draft
                        </span>
                    @else
                        <span class="px-4 py-2 bg-green-100 text-green-800 font-semibold rounded-full">
                            ✅ Published
                        </span>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($exam->description)
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <p class="text-gray-700">{{ $exam->description }}</p>
                </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <div class="text-xs text-blue-700 uppercase mb-1">Questions</div>
                    <div class="text-2xl font-bold text-blue-900">{{ $exam->questions()->count() }}</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-center">
                    <div class="text-xs text-purple-700 uppercase mb-1">Total Marks</div>
                    <div class="text-2xl font-bold text-purple-900">{{ $exam->total_marks }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <div class="text-xs text-green-700 uppercase mb-1">Passing Marks</div>
                    <div class="text-2xl font-bold text-green-900">{{ $exam->passing_marks }}</div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg text-center">
                    <div class="text-xs text-orange-700 uppercase mb-1">Duration</div>
                    <div class="text-2xl font-bold text-orange-900">{{ $exam->duration_minutes }} min</div>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg text-center">
                    <div class="text-xs text-indigo-700 uppercase mb-1">Submissions</div>
                    <div class="text-2xl font-bold text-indigo-900">{{ $totalSubmissions }}</div>
                    @if($pendingGrading > 0)
                        <div class="text-xs text-red-600 font-semibold mt-1">{{ $pendingGrading }} pending</div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-6">
                <a href="{{ route('instructor.final-exams.submissions', $exam->id) }}" 
                   class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold text-center transition">
                    📊 View Submissions
                    @if($pendingGrading > 0)
                        <span class="ml-2 bg-red-500 px-2 py-1 rounded-full text-xs">{{ $pendingGrading }}</span>
                    @endif
                </a>

                @if($totalSubmissions == 0)
                    <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        ✏️ Edit Exam
                    </a>
                @endif

                <a href="/instructor/manage_courses" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold transition">
                    ← Back
                </a>
            </div>
        </div>

        <!-- Questions List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📝 Exam Questions</h2>

            @foreach($exam->questions as $question)
                <div class="border-b border-gray-200 pb-4 mb-4 last:border-0">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Question {{ $question->question_number }}
                        </h3>
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $question->marks }} marks
                        </span>
                    </div>

                    <p class="text-gray-700 mb-2">{{ $question->question_text }}</p>

                    @if($question->marking_criteria)
                        <div class="bg-green-50 border-l-4 border-green-500 p-3 mt-2">
                            <div class="text-xs text-green-700 font-semibold uppercase mb-1">Marking Criteria</div>
                            <p class="text-sm text-green-800">{{ $question->marking_criteria }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Submissions Stats (if any) -->
        @if($totalSubmissions > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">📈 Submission Statistics</h2>

                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-3xl font-bold text-yellow-900">{{ $pendingGrading }}</div>
                        <div class="text-sm text-yellow-700 mt-1">Pending Grading</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-900">{{ $graded }}</div>
                        <div class="text-sm text-green-700 mt-1">Graded</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-900">{{ $passed }}</div>
                        <div class="text-sm text-blue-700 mt-1">Passed (70%+)</div>
                        @if($graded > 0)
                            <div class="text-xs text-gray-600 mt-1">
                                {{ round(($passed / $graded) * 100) }}% pass rate
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html>