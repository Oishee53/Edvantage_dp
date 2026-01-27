<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Submissions - {{ $exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <style>
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slide-in { animation: slideIn 0.5s ease-out forwards; }
        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.15s; }
        .stat-card:nth-child(3) { animation-delay: 0.2s; }
        .stat-card:nth-child(4) { animation-delay: 0.25s; }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-blue-50/30 to-indigo-50/20 min-h-screen font-sans antialiased">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 lg:ml-0">
            <x-instructor-header 
                :title="'Exam Submissions'" 
                :subtitle="$exam->title . ' - ' . $exam->course->title"
            />

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
                        <span class="text-teal-900 font-semibold">{{ $exam->title }}</span>
                    </nav>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stat-card bg-white rounded-3xl shadow-xl border border-teal-100 p-6 opacity-0 animate-slide-in">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-teal-900">{{ $submissions->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">Total Submissions</p>
                    </div>

                    <div class="stat-card bg-white rounded-3xl shadow-xl border border-teal-100 p-6 opacity-0 animate-slide-in">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-teal-900">{{ $submissions->where('status', 'submitted')->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">Pending Grading</p>
                    </div>

                    <div class="stat-card bg-white rounded-3xl shadow-xl border border-teal-100 p-6 opacity-0 animate-slide-in">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <span class="text-3xl font-bold text-teal-900">{{ $submissions->where('status', 'graded')->count() }}</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">Graded</p>
                    </div>

                    <div class="stat-card bg-white rounded-3xl shadow-xl border border-teal-100 p-6 opacity-0 animate-slide-in">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-trophy text-white text-xl"></i>
                            </div>
                            @php
                                $graded = $submissions->where('status', 'graded')->count();
                                $passed = $submissions->where('status', 'graded')->where('percentage', '>=', 70)->count();
                                $passRate = $graded > 0 ? round(($passed / $graded) * 100) : 0;
                            @endphp
                            <span class="text-3xl font-bold text-teal-900">{{ $passRate }}%</span>
                        </div>
                        <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide">Pass Rate</p>
                    </div>
                </div>

                <!-- Submissions Table -->
                <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.3s;">
                    <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-teal-900 flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                            All Submissions
                            <span class="ml-2 px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-bold">
                                {{ $submissions->count() }}
                            </span>
                        </h2>
                        <a href="/instructor/manage_courses" 
                           class="inline-flex items-center gap-2 px-6 py-2 bg-white text-primary-700 border-2 border-primary-700 rounded-xl font-semibold hover:bg-primary-700 hover:text-white transition-all">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-teal-50 border-b-2 border-teal-200">
                                <tr>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-teal-600 uppercase tracking-wider">Student</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-teal-600 uppercase tracking-wider">Submitted At</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-teal-600 uppercase tracking-wider">Status</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-teal-600 uppercase tracking-wider">Score</th>
                                    <th class="px-8 py-4 text-right text-xs font-bold text-teal-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-teal-200">
                                @forelse($submissions as $submission)
                                    <tr class="hover:bg-teal-50 transition-colors">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold text-sm">{{ substr($submission->user->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-teal-900">{{ $submission->user->name }}</div>
                                                    <div class="text-sm text-teal-600">{{ $submission->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="text-teal-700 font-medium">
                                                {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y') : 'Not submitted' }}
                                            </div>
                                            @if($submission->submitted_at)
                                                <div class="text-sm text-teal-600">{{ $submission->submitted_at->format('g:i A') }}</div>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5">
                                            @if($submission->status === 'submitted')
                                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold border border-amber-200">
                                                    <i class="fas fa-clock mr-1"></i>PENDING
                                                </span>
                                            @elseif($submission->status === 'graded')
                                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                                    <i class="fas fa-check-circle mr-1"></i>GRADED
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs font-bold border border-teal-200">
                                                    {{ strtoupper($submission->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5">
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
                                                <span class="text-teal-500 text-sm font-medium">Not graded</span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            @if($submission->status === 'submitted')
                                                <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-primary-700 to-primary-600 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 text-sm">
                                                    <i class="fas fa-pen"></i>
                                                    Grade Now
                                                </a>
                                            @elseif($submission->status === 'graded')
                                                <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" 
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-white text-primary-700 border-2 border-primary-700 rounded-lg font-semibold hover:bg-primary-700 hover:text-white transition-all text-sm">
                                                    <i class="fas fa-eye"></i>
                                                    View Grading
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-16">
                                            <div class="text-center">
                                                <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                                    <i class="fas fa-inbox text-4xl text-teal-400"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-teal-900 mb-2">No Submissions Yet</h3>
                                                <p class="text-teal-600">Student submissions will appear here once they submit the exam.</p>
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