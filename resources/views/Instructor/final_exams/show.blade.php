<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - Exam Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <style>
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
        .question-item:nth-child(1) { animation-delay: 0.1s; }
        .question-item:nth-child(2) { animation-delay: 0.15s; }
        .question-item:nth-child(3) { animation-delay: 0.2s; }
        .question-item:nth-child(4) { animation-delay: 0.25s; }
        .question-item:nth-child(5) { animation-delay: 0.3s; }
        
        .notif-dropdown {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .notif-dropdown.show {
            max-height: 400px;
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-blue-50/30 to-indigo-50/20 min-h-screen font-sans antialiased">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 lg:ml-0">
            <!-- Header -->
            <x-instructor-header 
                :title="$exam->title" 
                :subtitle="'Final Exam Details - ' . $exam->course->title"
            />

            <!-- Page Content -->
            <div class="p-6 lg:p-8 max-w-7xl mx-auto">
                <!-- Breadcrumb -->
                <div class="mb-6 opacity-0 animate-slide-in">
                    <nav class="flex items-center gap-2 text-sm text-teal-600">
                        <a href="/instructor/manage_courses" class="hover:text-primary-700 transition-colors">
                            <i class="fas fa-home"></i> Manage Courses
                        </a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <a href="/instructor/manage_courses" class="hover:text-primary-700 transition-colors">
                            {{ $exam->course->title }}
                        </a>
                        <i class="fas fa-chevron-right text-xs"></i>
                        <span class="text-teal-900 font-semibold">Exam Details</span>
                    </nav>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 mb-6 opacity-0 animate-slide-in" style="animation-delay: 0.1s;">
                    @if($totalSubmissions == 0)
                        <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                            <i class="fas fa-edit"></i>
                            <span>Edit Exam</span>
                        </a>
                    @endif
                    <a href="/instructor/manage_courses" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 border-2 border-primary-700 rounded-xl font-semibold hover:bg-primary-700 hover:text-white transition-all">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Courses</span>
                    </a>
                </div>

                <!-- Main Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column: Questions (2/3 width) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Questions Card -->
                        <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.15s;">
                            <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <h2 class="text-2xl font-bold text-teal-900 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-clipboard-question text-white"></i>
                                    </div>
                                    Exam Questions
                                    <span class="ml-auto px-4 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                        {{ $exam->questions()->count() }} Questions
                                    </span>
                                </h2>
                            </div>
                            
                            <div class="p-8">
                                <div class="space-y-4">
                                    @foreach($exam->questions as $question)
                                        <div class="question-item bg-gradient-to-r from-white to-teal-50 border-2 border-teal-200 rounded-2xl p-6 hover:border-purple-300 hover:shadow-lg transition-all duration-200 opacity-0 animate-slide-in">
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                                        <span class="text-white font-bold">{{ $question->question_number }}</span>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-teal-900">Question {{ $question->question_number }}</h3>
                                                </div>
                                                <span class="px-4 py-2 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold border border-amber-200">
                                                    <i class="fas fa-star mr-1"></i>{{ $question->marks }} marks
                                                </span>
                                            </div>
                                            
                                            <div class="mb-4">
                                                <p class="text-teal-700 leading-relaxed">{{ $question->question_text }}</p>
                                            </div>
                                            
                                            @if($question->marking_criteria)
                                                <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <i class="fas fa-list-check text-blue-600"></i>
                                                        <span class="text-xs font-bold text-blue-900 uppercase tracking-wide">Marking Criteria</span>
                                                    </div>
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
                        <!-- Exam Information Card -->
                        <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.2s;">
                            <div class="px-6 py-5 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                                    <i class="fas fa-info-circle text-primary-700"></i>
                                    Exam Information
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between pb-4 border-b border-teal-200">
                                    <span class="text-sm text-teal-600 font-medium">Status</span>
                                    @if($exam->status === 'draft')
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                                            <i class="fas fa-file-alt mr-1"></i>DRAFT
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                            <i class="fas fa-check-circle mr-1"></i>PUBLISHED
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between pb-4 border-b border-teal-200">
                                    <span class="text-sm text-teal-600 font-medium">
                                        <i class="fas fa-star text-amber-500 mr-1"></i>Total Marks
                                    </span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->total_marks }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between pb-4 border-b border-teal-200">
                                    <span class="text-sm text-teal-600 font-medium">
                                        <i class="fas fa-check-double text-green-500 mr-1"></i>Passing Marks
                                    </span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->passing_marks }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between pb-4 border-b border-teal-200">
                                    <span class="text-sm text-teal-600 font-medium">
                                        <i class="fas fa-clock text-blue-500 mr-1"></i>Duration
                                    </span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->duration_minutes }} min</span>
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-teal-600 font-medium">
                                        <i class="fas fa-list-ol text-purple-500 mr-1"></i>Total Questions
                                    </span>
                                    <span class="text-sm font-bold text-teal-900">{{ $exam->questions()->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Description Card -->
                        @if($exam->description)
                            <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.25s;">
                                <div class="px-6 py-5 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                    <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                                        <i class="fas fa-align-left text-primary-700"></i>
                                        Description
                                    </h3>
                                </div>
                                
                                <div class="p-6">
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-primary-700 rounded-lg p-4">
                                        <p class="text-sm text-teal-700 leading-relaxed">{{ $exam->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Submissions Stats Card -->
                        <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.3s;">
                            <div class="px-6 py-5 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                                    <i class="fas fa-chart-bar text-primary-700"></i>
                                    Submissions
                                </h3>
                            </div>
                            
                            <div class="p-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border-2 border-blue-200 text-center">
                                        <div class="text-3xl font-bold text-blue-700">{{ $totalSubmissions }}</div>
                                        <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide mt-1">Total</div>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-4 border-2 border-amber-200 text-center">
                                        <div class="text-3xl font-bold text-amber-700">{{ $pendingGrading }}</div>
                                        <div class="text-xs text-amber-600 font-semibold uppercase tracking-wide mt-1">Pending</div>
                                        @if($pendingGrading > 0)
                                            <div class="text-xs text-red-600 font-bold mt-1">Needs grading</div>
                                        @endif
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border-2 border-green-200 text-center">
                                        <div class="text-3xl font-bold text-green-700">{{ $graded }}</div>
                                        <div class="text-xs text-green-600 font-semibold uppercase tracking-wide mt-1">Graded</div>
                                    </div>
                                    
                                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border-2 border-purple-200 text-center">
                                        <div class="text-3xl font-bold text-purple-700">{{ $passed }}</div>
                                        <div class="text-xs text-purple-600 font-semibold uppercase tracking-wide mt-1">Passed</div>
                                        @if($graded > 0)
                                            <div class="text-xs text-purple-600 font-bold mt-1">{{ round(($passed / $graded) * 100) }}% rate</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.35s;">
                            <div class="px-6 py-5 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <h3 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                                    <i class="fas fa-bolt text-primary-700"></i>
                                    Quick Actions
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-3">
                                <a href="{{ route('instructor.final-exams.submissions', $exam->id) }}" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-primary-700 to-primary-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                                    <i class="fas fa-eye"></i>
                                    <span>View All Submissions</span>
                                    @if($pendingGrading > 0)
                                        <span class="ml-auto px-2 py-1 bg-red-500 text-white rounded-full text-xs font-bold">
                                            {{ $pendingGrading }}
                                        </span>
                                    @endif
                                </a>
                                
                                @if($totalSubmissions == 0)
                                    <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" 
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-primary-700 border-2 border-primary-700 rounded-xl font-semibold hover:bg-primary-700 hover:text-white transition-all">
                                        <i class="fas fa-edit"></i>
                                        <span>Edit Exam</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        function toggleNotifications() {
            document.getElementById('notifDropdown').classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            const notifDropdown = document.getElementById('notifDropdown');
            if (notifDropdown && !event.target.closest('.notifications')) {
                notifDropdown.classList.remove('show');
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const notifDropdown = document.getElementById('notifDropdown');
                if (notifDropdown) notifDropdown.classList.remove('show');
            }
        });

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;
            
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnMenuButton = event.target.closest('button')?.onclick?.toString().includes('toggleSidebar');
            
            if (!isClickInsideSidebar && !isClickOnMenuButton && window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>