<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - Exam Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f2f9',
                            100: '#e3e6f3',
                            600: '#1a2d52',
                            700: '#0E1B33',
                            800: '#0a1426',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            <!-- Header -->
            <x-instructor-header 
                :title="$exam->title" 
            />

            <!-- Page Content -->
            <div class="p-6 lg:p-8 max-w-7xl mx-auto">
                <!-- Main Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column: Questions (2/3 width) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Questions Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h2 class="text-xl font-bold text-teal-900 flex items-center justify-between">
                                    <span>Exam Questions</span>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                        {{ $exam->questions()->count() }} Questions
                                    </span>
                                </h2>
                            </div>
                            
                            <div class="p-6">
                                <div class="space-y-4">
                                    @foreach($exam->questions as $question)
                                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                                            <div class="flex items-start justify-between mb-3">
                                                <h3 class="text-base font-bold text-teal-900">Question {{ $question->question_number }}</h3>
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">
                                                    {{ $question->marks }} marks
                                                </span>
                                            </div>
                                            
                                            <p class="text-teal-700 mb-3">{{ $question->question_text }}</p>
                                            
                                            @if($question->marking_criteria)
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3">
                                                    <p class="text-xs font-bold text-blue-900 mb-1">MARKING CRITERIA</p>
                                                    <p class="text-sm text-teal-700">{{ $question->marking_criteria }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Info & Actions (1/3 width) -->
                    <div class="space-y-6">
                        <!-- Quick Actions Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-base font-bold text-teal-900">Quick Actions</h3>
                            </div>
                            
                            <div class="p-6 space-y-3">
                                <a href="{{ route('instructor.final-exams.submissions', $exam->id) }}" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-teal-600 text-white rounded-xl font-semibold hover:bg-teal-700 transition-all">
                                    <i class="fas fa-eye"></i>
                                    <span>View Submissions</span>
                                    @if($pendingGrading > 0)
                                        <span class="ml-auto px-2 py-1 bg-red-500 text-white rounded-full text-xs font-bold">
                                            {{ $pendingGrading }}
                                        </span>
                                    @endif
                                </a>
                                
                                @if($totalSubmissions == 0)
                                    <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-blue-600 border-2 border-blue-600 rounded-xl font-semibold hover:bg-blue-600 hover:text-white transition-all">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit Exam</span>
                                    </a>
                                @endif
                                
                                <a href="/instructor/manage_courses" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white text-teal-700 border-2 border-teal-700 rounded-xl font-semibold hover:bg-teal-700 hover:text-white transition-all">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Back to Courses</span>
                                </a>
                            </div>
                        </div>

                        <!-- Exam Information Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-base font-bold text-teal-900">Exam Information</h3>
                            </div>
                            
                            <div class="p-6 space-y-3">
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm text-teal-600 font-medium">Status</span>
                                    @if($exam->status === 'draft')
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                            DRAFT
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                            PUBLISHED
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm text-teal-600 font-medium">Total Marks</span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->total_marks }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm text-teal-600 font-medium">Passing Marks</span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->passing_marks }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <span class="text-sm text-teal-600 font-medium">Duration</span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->duration_minutes }} min</span>
                                </div>
                                
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm text-teal-600 font-medium">Total Questions</span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->questions()->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description Card -->
                        @if($exam->description)
                            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                    <h3 class="text-base font-bold text-teal-900">Description</h3>
                                </div>
                                
                                <div class="p-6">
                                    <div class="bg-blue-50 border-l-4 border-teal-600 rounded-lg p-4">
                                        <p class="text-sm text-teal-700">{{ $exam->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Submissions Stats Card -->
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-base font-bold text-teal-900">Submissions</h3>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 text-center">
                                        <div class="text-2xl font-bold text-blue-700">{{ $totalSubmissions }}</div>
                                        <div class="text-xs text-blue-600 font-semibold mt-1">Total</div>
                                    </div>
                                    
                                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-200 text-center">
                                        <div class="text-2xl font-bold text-amber-700">{{ $pendingGrading }}</div>
                                        <div class="text-xs text-amber-600 font-semibold mt-1">Pending</div>
                                    </div>
                                    
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200 text-center">
                                        <div class="text-2xl font-bold text-green-700">{{ $graded }}</div>
                                        <div class="text-xs text-green-600 font-semibold mt-1">Graded</div>
                                    </div>
                                    
                                    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200 text-center">
                                        <div class="text-2xl font-bold text-purple-700">{{ $passed }}</div>
                                        <div class="text-xs text-purple-600 font-semibold mt-1">Passed</div>
                                        @if($graded > 0)
                                            <div class="text-xs text-purple-600 font-bold mt-1">{{ round(($passed / $graded) * 100) }}%</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>