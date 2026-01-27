<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Submissions - {{ $exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0f2f9', 100: '#e3e6f3', 600: '#1a2d52', 700: '#0E1B33', 800: '#0a1426' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        
        @include('layouts.sidebar')

        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            <x-instructor-header 
                :title="'Exam Submissions - ' . $exam->title"
            />

            <div class="p-6 lg:p-8 max-w-7xl mx-auto mr-6">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-3xl font-semibold text-teal-900">{{ $submissions->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-700 uppercase tracking-wide">Total Submissions</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-3xl font-semibold text-teal-900">{{ $submissions->where('status', 'submitted')->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-700 uppercase tracking-wide">Pending Grading</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-3xl font-semibold text-teal-900">{{ $submissions->where('status', 'graded')->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-700 uppercase tracking-wide">Graded</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            @php
                                $graded = $submissions->where('status', 'graded')->count();
                                $passed = $submissions->where('status', 'graded')->where('percentage', '>=', 70)->count();
                                $passRate = $graded > 0 ? round(($passed / $graded) * 100) : 0;
                            @endphp
                            <span class="text-3xl font-semibold text-teal-900">{{ $passRate }}%</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-700 uppercase tracking-wide">Pass Rate</p>
                    </div>
                </div>

                <!-- Submissions Table -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                            All Submissions
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-sm font-bold">
                                {{ $submissions->count() }}
                            </span>
                        </h2>
                        <a href="{{ route('instructor.final-exams.show', $exam->id) }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white text-teal-700 border-2 border-teal-700 rounded-xl font-semibold hover:bg-teal-700 hover:text-white transition-all">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Submitted At</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Score</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($submissions as $submission)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold text-sm">{{ substr($submission->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-teal-900">{{ $submission->user->name }}</div>
                                                    <div class="text-sm text-teal-700">{{ $submission->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-teal-700 font-medium">
                                                {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y') : 'Not submitted' }}
                                            </div>
                                            @if($submission->submitted_at)
                                                <div class="text-sm text-teal-700">{{ $submission->submitted_at->format('g:i A') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($submission->status === 'submitted')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                                    PENDING
                                                </span>
                                            @elseif($submission->status === 'graded')
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                                    GRADED
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                                                    {{ strtoupper($submission->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($submission->status === 'graded')
                                                <div class="font-bold text-teal-900">{{ $submission->total_score }}/{{ $exam->total_marks }}</div>
                                                <div class="text-sm font-semibold {{ $submission->percentage >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ number_format($submission->percentage, 1) }}%
                                                    @if($submission->percentage >= 70)
                                                        <i class="fas fa-check-circle ml-1"></i>
                                                    @else
                                                        <i class="fas fa-times-circle ml-1"></i>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-500 text-sm font-medium">Not graded</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($submission->status === 'submitted')
                                                <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-700 transition-all text-sm">
                                                    <i class="fas fa-pen"></i>
                                                    Grade Now
                                                </a>
                                            @elseif($submission->status === 'graded')
                                                <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-teal-700 border-2 border-teal-700 rounded-lg font-semibold hover:bg-teal-700 hover:text-white transition-all text-sm">
                                                    View Grading
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-teal-900 mb-2">No Submissions Yet</h3>
                                                <p class="text-teal-700">Student submissions will appear here once they submit the exam.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>