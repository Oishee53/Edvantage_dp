<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Submissions - {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $exam->title }}</h1>
            <p class="text-gray-600">{{ $exam->course->title }} - Exam Submissions</p>
            
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div class="bg-blue-50 p-3 rounded-lg">
                    <div class="text-xs text-blue-700 uppercase">Total Submissions</div>
                    <div class="text-2xl font-bold text-blue-900">{{ $submissions->count() }}</div>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <div class="text-xs text-yellow-700 uppercase">Pending</div>
                    <div class="text-2xl font-bold text-yellow-900">{{ $submissions->where('status', 'submitted')->count() }}</div>
                </div>
                <div class="bg-green-50 p-3 rounded-lg">
                    <div class="text-xs text-green-700 uppercase">Graded</div>
                    <div class="text-2xl font-bold text-green-900">{{ $submissions->where('status', 'graded')->count() }}</div>
                </div>
                <div class="bg-purple-50 p-3 rounded-lg">
                    <div class="text-xs text-purple-700 uppercase">Pass Rate</div>
                    <div class="text-2xl font-bold text-purple-900">
                        @php
                            $graded = $submissions->where('status', 'graded')->count();
                            $passed = $submissions->where('status', 'graded')->where('percentage', '>=', 70)->count();
                            $passRate = $graded > 0 ? round(($passed / $graded) * 100) : 0;
                        @endphp
                        {{ $passRate }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $submission->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $submission->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y g:i A') : 'Not submitted' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($submission->status === 'submitted')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">
                                        ⏳ Pending
                                    </span>
                                @elseif($submission->status === 'graded')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                        ✅ Graded
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($submission->status === 'graded')
                                    <div class="font-semibold text-gray-900">
                                        {{ $submission->total_score }}/{{ $exam->total_marks }}
                                    </div>
                                    <div class="text-sm {{ $submission->percentage >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($submission->percentage, 1) }}%
                                    </div>
                                @else
                                    <span class="text-gray-400">Not graded</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($submission->status === 'submitted')
                                    <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                                        📝 Grade Now
                                    </a>
                                @elseif($submission->status === 'graded')
                                    <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                                        👁️ View Grading
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No submissions yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="/instructor/manage_courses" 
               class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                ← Back to Courses
            </a>
        </div>
    </div>
</body>
</html>