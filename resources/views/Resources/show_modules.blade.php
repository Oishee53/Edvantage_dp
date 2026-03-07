<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Lectures - {{ $course->title }}</title>
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
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.5s ease-out forwards; }
        .module-item:nth-child(1) { animation-delay: 0.1s; }
        .module-item:nth-child(2) { animation-delay: 0.15s; }
        .module-item:nth-child(3) { animation-delay: 0.2s; }
        .module-item:nth-child(4) { animation-delay: 0.25s; }
        .module-item:nth-child(5) { animation-delay: 0.3s; }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(239,68,68,0.6); }
            100% { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
        }
        .live-pulse { animation: pulse-ring 1.2s ease-out infinite; }

        @media (min-width: 1024px) { aside { display: block !important; } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    @auth
        @php
            $userRole     = auth()->user()->role;
            $isAdmin      = $userRole === 2;
            $isInstructor = $userRole === 3;
            $isStudent    = !$isAdmin && !$isInstructor;
            $isLiveCourse = $course->course_type === 'live';
        @endphp

        <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
             @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
             class="flex min-h-screen">

            @include('layouts.sidebar')

            <main class="flex-1 transition-all duration-300"
                  :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">

                <x-instructor-header :title="$pageTitle ?? 'Course Lectures'" />

                <div class="p-4 lg:p-6 max-w-7xl mx-auto pr-10">

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-teal-50 border border-teal-200 rounded-xl text-teal-700 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-medium">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Course Header Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-sm"></i>
                                </div>
                                {{ $course->title }}
                                @if($isLiveCourse)
                                    <span class="ml-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                        <i class="fas fa-circle text-red-500 text-[8px]"></i> Live Course
                                    </span>
                                @endif
                            </h2>
                        </div>

                        {{-- Progress bar only for recorded courses --}}
                        @if(!$isLiveCourse)
                            <div class="p-6">
                                @php
                                    $totalModules = count($modules);
                                    $completed = $isStudent
                                        ? collect($modules)->where('quiz', true)->count()
                                        : collect($modules)->filter(fn($m) => $m['quiz'] && $m['resource'])->count();
                                    $progressPercentage = $totalModules > 0 ? round(($completed / $totalModules) * 100, 1) : 0;
                                @endphp
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-semibold text-teal-700">Course Progress</span>
                                    <span class="text-sm font-bold text-teal-900">{{ $progressPercentage }}%</span>
                                </div>
                                <div class="w-full h-2.5 bg-teal-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-600 rounded-full transition-all duration-500 ease-out"
                                         style="width: {{ $progressPercentage }}%"></div>
                                </div>
                                <p class="text-sm text-teal-600 mt-2">
                                    <span class="font-semibold text-teal-900">{{ $completed }}</span> of
                                    <span class="font-semibold text-teal-900">{{ $totalModules }}</span> lectures completed
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Modules / Sessions List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-list text-white text-sm"></i>
                                </div>
                                {{ $isLiveCourse ? 'Session List' : 'Lecture List' }}
                            </h3>
                        </div>

                        <div class="p-6">
                            @if(count($modules) > 0)
                                <div class="space-y-3">
                                    @foreach ($modules as $module)
                                        @php
                                            $status      = $module['status'] ?? 'scheduled';
                                            $sessionDate = $module['date'] ?? null;
                                            $isToday     = $sessionDate && \Carbon\Carbon::parse($sessionDate)->isToday();
                                            $isLiveNow   = $isLiveCourse && $status === 'live';
                                            $isEnded     = $isLiveCourse && $status === 'ended';
                                        @endphp

                                        <div class="module-item group flex items-center justify-between p-4 border rounded-xl transition-all duration-200 bg-white opacity-0 animate-slide-in
                                            {{ $isLiveNow ? 'border-red-300 bg-red-50' : 'border-gray-200 hover:border-gray-900 hover:shadow-md hover:bg-teal-50' }}">

                                            <!-- Left: icon + info -->
                                            <div class="flex items-center gap-4 flex-1">
                                                <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-105
                                                    {{ $isLiveNow ? 'bg-red-500 live-pulse' : 'bg-teal-600' }}">
                                                    @if($isLiveNow)
                                                        <i class="fas fa-broadcast-tower text-white text-sm"></i>
                                                    @else
                                                        <span class="text-lg font-bold text-white">{{ $module['id'] }}</span>
                                                    @endif
                                                </div>

                                                <div class="flex-1">
                                                    <h4 class="text-base font-bold text-teal-900 mb-1.5 group-hover:text-teal-700 transition-colors">
                                                        {{ $isLiveCourse
                                                            ? ($module['title'] ?? 'Session ' . $module['id'])
                                                            : 'Lecture ' . $module['id'] }}
                                                    </h4>

                                                    <!-- Status badges -->
                                                    <div class="flex flex-wrap gap-2">

                                                        @if($isLiveCourse)
                                                            {{-- Live course: session status badge only, no quiz/resource badges --}}
                                                            @if($isLiveNow)
                                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 border border-red-300 rounded-lg text-xs font-bold text-red-700">
                                                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-ping inline-block"></span>
                                                                    LIVE NOW
                                                                </span>
                                                            @elseif($isEnded)
                                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-teal-50 border border-teal-200 rounded-lg text-xs font-semibold text-teal-700">
                                                                    <i class="fas fa-video"></i> Recording Available
                                                                </span>
                                                            @else
                                                                @if($sessionDate)
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-indigo-50 border border-indigo-200 rounded-lg text-xs font-semibold text-indigo-700">
                                                                        <i class="fas fa-calendar-alt"></i>
                                                                        {{ \Carbon\Carbon::parse($sessionDate)->format('d M Y') }}
                                                                        @if($isToday)
                                                                            <span class="font-bold text-indigo-600">· Today</span>
                                                                        @endif
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-400">
                                                                        <i class="fas fa-calendar-alt"></i> Not scheduled
                                                                    </span>
                                                                @endif
                                                            @endif

                                                        @else
                                                            {{-- Recorded course badges --}}
                                                            @if($isStudent)
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 {{ $module['quiz'] ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }} border rounded-lg">
                                                                    <div class="w-4 h-4 {{ $module['quiz'] ? 'bg-green-500' : 'bg-amber-500' }} rounded-full flex items-center justify-center">
                                                                        <i class="fas {{ $module['quiz'] ? 'fa-check' : 'fa-exclamation' }} text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold {{ $module['quiz'] ? 'text-green-700' : 'text-amber-700' }}">
                                                                        {{ $module['quiz'] ? 'Quiz Available' : 'Quiz Pending' }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 {{ $module['quiz'] ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }} border rounded-lg">
                                                                    <div class="w-4 h-4 {{ $module['quiz'] ? 'bg-green-500' : 'bg-amber-500' }} rounded-full flex items-center justify-center">
                                                                        <i class="fas {{ $module['quiz'] ? 'fa-check' : 'fa-exclamation' }} text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold {{ $module['quiz'] ? 'text-green-700' : 'text-amber-700' }}">
                                                                        {{ $module['quiz'] ? 'Quiz Uploaded' : 'Quiz Pending' }}
                                                                    </span>
                                                                </div>
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 {{ $module['resource'] ? 'bg-blue-50 border-blue-200' : 'bg-amber-50 border-amber-200' }} border rounded-lg">
                                                                    <div class="w-4 h-4 {{ $module['resource'] ? 'bg-blue-500' : 'bg-amber-500' }} rounded-full flex items-center justify-center">
                                                                        <i class="fas {{ $module['resource'] ? 'fa-check' : 'fa-exclamation' }} text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold {{ $module['resource'] ? 'text-blue-700' : 'text-amber-700' }}">
                                                                        {{ $module['resource'] ? 'Resource Uploaded' : 'Resource Pending' }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right: Action Buttons -->
                                            <div class="flex gap-2 flex-shrink-0">

                                                @if($isLiveCourse)
                                                    {{-- ── LIVE COURSE: status-driven buttons only, no quiz/resource upload ── --}}

                                                    @if($isLiveNow)
                                                        @if($isInstructor || $isAdmin)
                                                            <a href="{{ route('instructor.live_session.go_live', ['course' => $course->id, 'session' => $module['id']]) }}"
                                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-all text-sm">
                                                                <i class="fas fa-broadcast-tower text-xs"></i> Manage Stream
                                                            </a>
                                                        @else
                                                            <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $module['id']]) }}"
                                                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition-all text-sm live-pulse">
                                                                <i class="fas fa-circle text-xs animate-ping"></i> Join Live
                                                            </a>
                                                        @endif

                                                    @elseif($isEnded)
                                                        <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $module['id']]) }}"
                                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all text-sm">
                                                            <i class="fas fa-play text-xs"></i> Watch Recording
                                                        </a>

                                                    @else
                                                        {{-- Scheduled but not yet started --}}
                                                        @if($isInstructor || $isAdmin)
                                                            @if($isToday)
                                                                <a href="{{ route('instructor.live_session.go_live', ['course' => $course->id, 'session' => $module['id']]) }}"
                                                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all text-sm">
                                                                    <i class="fas fa-broadcast-tower text-xs"></i> Go Live
                                                                </a>
                                                            @else
                                                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg font-medium text-sm cursor-not-allowed"
                                                                      title="Available on {{ $sessionDate ? \Carbon\Carbon::parse($sessionDate)->format('d M Y') : 'TBD' }}">
                                                                    <i class="fas fa-lock text-xs"></i> Go Live
                                                                </span>
                                                            @endif
                                                        @else
                                                            <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg font-medium text-sm">
                                                                <i class="fas fa-clock text-xs"></i> Upcoming
                                                            </span>
                                                        @endif
                                                    @endif

                                                @else
                                                    {{-- ── RECORDED COURSE ACTIONS ── --}}
                                                    <a href="{{ route('inside.module2', ['courseId' => $course->id, 'moduleNumber' => $module['id']]) }}"
                                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                                                        <i class="fas fa-eye text-xs"></i> View
                                                    </a>

                                                    @if($isAdmin)
                                                        <a href="{{ route('module.create', ['course' => $course->id, 'module' => $module['id']]) }}"
                                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all text-sm">
                                                            <i class="fas {{ $module['resource'] || $module['quiz'] ? 'fa-edit' : 'fa-upload' }} text-xs"></i>
                                                            {{ $module['resource'] || $module['quiz'] ? 'Edit' : 'Upload' }}
                                                        </a>
                                                    @elseif($isInstructor)
                                                        <a href="{{ route('quiz.create', ['course' => $course->id, 'module' => $module['id']]) }}"
                                                           class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all text-sm">
                                                            <i class="fas {{ $module['quiz'] ? 'fa-edit' : 'fa-upload' }} text-xs"></i>
                                                            {{ $module['quiz'] ? 'Edit Quiz' : 'Upload Quiz' }}
                                                        </a>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-folder-open text-2xl text-teal-400"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-teal-900 mb-2">No Lectures Yet</h3>
                                    <p class="text-sm text-teal-600">Start by adding lectures to this course.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="flex justify-start">
                        <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    @else
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md w-full">
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-3xl text-red-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-teal-900 mb-3">Access Denied</h2>
                    <p class="text-teal-600 mb-6">You need to be logged in to view this page.</p>
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition-all hover:shadow-lg">
                        <i class="fas fa-sign-in-alt"></i> Go to Login
                    </a>
                </div>
            </div>
        </div>
    @endauth
</body>
</html>