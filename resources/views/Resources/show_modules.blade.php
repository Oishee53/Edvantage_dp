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
                            50: '#f0f2f9', 100: '#e3e6f3',
                            600: '#1a2d52', 700: '#0E1B33', 800: '#0a1426',
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
        .module-item:nth-child(1) { animation-delay: 0.05s; }
        .module-item:nth-child(2) { animation-delay: 0.10s; }
        .module-item:nth-child(3) { animation-delay: 0.15s; }
        .module-item:nth-child(4) { animation-delay: 0.20s; }
        .module-item:nth-child(5) { animation-delay: 0.25s; }

        @keyframes pulse-ring {
            0%   { box-shadow: 0 0 0 0 rgba(239,68,68,0.6); }
            100% { box-shadow: 0 0 0 8px rgba(239,68,68,0); }
        }
        .live-pulse { animation: pulse-ring 1.2s ease-out infinite; }

        #schedule-modal {
            display: none;
            position: fixed; inset: 0; z-index: 50;
            background: rgba(0,0,0,0.45); backdrop-filter: blur(2px);
            align-items: center; justify-content: center;
        }
        #schedule-modal.open { display: flex; }
        .modal-input:focus { outline: none; border-color: #0d9488; box-shadow: 0 0 0 3px rgba(13,148,136,0.15); }
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
                                    $totalModules       = count($modules);
                                    $completed          = $isStudent
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

                            {{-- ── Hybrid Live Sessions block (recorded courses, instructor/admin only) ── --}}
                            @if(!$isLiveCourse && ($isInstructor || $isAdmin) && isset($liveSessions))
                                @php
                                    $activeSessions = $liveSessions
                                        ->whereIn('status', ['scheduled', 'live'])
                                        ->sortBy('date')
                                        ->sortBy('start_time')
                                        ->values();
                                @endphp

                                <div class="mb-6 rounded-xl border border-indigo-200 overflow-hidden">
                                    <div class="px-5 py-3 border-b border-indigo-200 bg-indigo-50 flex items-center justify-between">
                                        <h4 class="text-sm font-bold text-indigo-900 flex items-center gap-2">
                                            <i class="fas fa-broadcast-tower text-indigo-500"></i>
                                            Scheduled Live Classes
                                            @if($activeSessions->count() > 0)
                                                <span class="px-2 py-0.5 rounded-full bg-indigo-200 text-indigo-700 text-xs font-bold">
                                                    {{ $activeSessions->count() }}
                                                </span>
                                            @endif
                                        </h4>
                                        <a href="{{ route('live.class.form', ['course_id' => $course->id]) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-all">
                                            <i class="fas fa-plus text-[10px]"></i> Schedule New
                                        </a>
                                    </div>

                                    @if($activeSessions->count() > 0)
                                        <div class="divide-y divide-indigo-100 bg-white">
                                            @foreach($activeSessions as $ls)
                                                @php
                                                    $hlIsLive  = $ls->status === 'live';
                                                    $hlIsToday = $ls->date && \Carbon\Carbon::parse(\Carbon\Carbon::parse($ls->date)->toDateString())->isToday();

                                                    $hlInWindow  = false;
                                                    $hlWindowMsg = '';
                                                    if ($ls->date && $ls->start_time) {
                                                        $hlStart     = \Carbon\Carbon::parse(\Carbon\Carbon::parse($ls->date)->toDateString() . ' ' . $ls->start_time);
                                                        $hlWindowEnd = $hlStart->copy()->addMinutes(30);
                                                        $hlInWindow  = now()->between($hlStart, $hlWindowEnd);
                                                        if (now()->lt($hlStart)) {
                                                            $hlWindowMsg = 'Go live opens at ' . $hlStart->format('h:i A') . ' on ' . $hlStart->format('d M Y');
                                                        } elseif (now()->gt($hlWindowEnd)) {
                                                            $hlWindowMsg = 'Go-live window passed (' . $hlStart->format('h:i A') . ' to ' . $hlWindowEnd->format('h:i A') . ')';
                                                        }
                                                    } else {
                                                        $hlWindowMsg = 'Set a start time to enable Go Live';
                                                    }
                                                @endphp

                                                <div class="px-5 py-4 flex items-center justify-between gap-4 flex-wrap {{ $hlIsLive ? 'bg-red-50' : '' }}">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0
                                                            {{ $hlIsLive ? 'bg-red-500 live-pulse' : 'bg-indigo-100' }}">
                                                            <i class="fas fa-broadcast-tower text-sm {{ $hlIsLive ? 'text-white' : 'text-indigo-500' }}"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-gray-900">
                                                                {{ $ls->title ?? 'Live Session ' . $ls->session_number }}
                                                            </p>
                                                            <p class="text-xs text-gray-500 mt-0.5 flex flex-wrap items-center gap-2">
                                                                @if($ls->date)
                                                                    <span><i class="fas fa-calendar-alt mr-1"></i>{{ \Carbon\Carbon::parse($ls->date)->format('d M Y') }}</span>
                                                                @endif
                                                                @if($ls->start_time)
                                                                    <span><i class="fas fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($ls->start_time)->format('h:i A') }}</span>
                                                                @endif
                                                                @if($ls->duration_minutes)
                                                                    <span><i class="fas fa-hourglass-half mr-1"></i>{{ $ls->duration_minutes }} mins</span>
                                                                @endif
                                                                @if($hlIsToday && !$hlIsLive)
                                                                    <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-700 text-[10px] font-bold">TODAY</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-2 flex-shrink-0">
                                                        @if($hlIsLive)
                                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-100 border border-red-300 rounded-lg text-xs font-bold text-red-700">
                                                                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping inline-block"></span> LIVE NOW
                                                            </span>
                                                            <a href="{{ route('instructor.live_session.go_live', ['course' => $course->id, 'session' => $ls->session_number]) }}"
                                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition-all">
                                                                <i class="fas fa-broadcast-tower text-[10px]"></i> Manage Stream
                                                            </a>
                                                        @elseif($hlInWindow)
                                                            <a href="{{ route('instructor.live_session.go_live', ['course' => $course->id, 'session' => $ls->session_number]) }}"
                                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-all">
                                                                <i class="fas fa-broadcast-tower text-[10px]"></i> Go Live
                                                            </a>
                                                        @else
                                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 text-gray-400 rounded-lg text-xs font-medium cursor-not-allowed"
                                                                  title="{{ $hlWindowMsg }}">
                                                                <i class="fas fa-lock text-[10px]"></i> Go Live
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="px-5 py-6 text-center bg-white">
                                            <p class="text-sm text-gray-400">No live classes scheduled yet.</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- ── Lectures / Sessions list ── --}}
                            @if(count($modules) > 0)
                                <div class="space-y-3">
                                    @foreach ($modules as $module)
                                        @php
                                            $status      = $module['status'] ?? 'scheduled';
                                            $sessionDate = $module['date'] ?? null;
                                            $sessionTime = $module['start_time'] ?? null;
                                            $isToday     = $sessionDate && \Carbon\Carbon::parse(\Carbon\Carbon::parse($sessionDate)->toDateString())->isToday();
                                            $isLiveNow   = $isLiveCourse && $status === 'live';
                                            $isEnded     = $isLiveCourse && $status === 'ended';

                                            $inGoLiveWindow = false;
                                            $goLiveWindowMsg = '';
                                            if ($sessionDate && $sessionTime) {
                                                $scheduledStart  = \Carbon\Carbon::parse(\Carbon\Carbon::parse($sessionDate)->toDateString() . ' ' . $sessionTime);
                                                $goLiveWindowEnd = $scheduledStart->copy()->addMinutes(30);
                                                $inGoLiveWindow  = now()->between($scheduledStart, $goLiveWindowEnd);
                                                if (now()->lt($scheduledStart)) {
                                                    $goLiveWindowMsg = 'Go live opens at ' . $scheduledStart->format('h:i A') . ' on ' . $scheduledStart->format('d M Y');
                                                } elseif (now()->gt($goLiveWindowEnd)) {
                                                    $goLiveWindowMsg = 'Go-live window passed (' . $scheduledStart->format('h:i A') . ' to ' . $goLiveWindowEnd->format('h:i A') . ')';
                                                }
                                            } elseif (!$sessionTime) {
                                                $goLiveWindowMsg = 'Set a start time to enable Go Live';
                                            } else {
                                                $goLiveWindowMsg = 'Schedule this session first';
                                            }
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

                                                    <div class="flex flex-wrap gap-2">
                                                        @if($isLiveCourse)
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
                                                                        @if($module['start_time'] ?? null)
                                                                            · {{ \Carbon\Carbon::parse($module['start_time'])->format('h:i A') }}
                                                                        @endif
                                                                        @if($isToday)
                                                                            <span class="font-bold text-indigo-600">· Today</span>
                                                                        @endif
                                                                    </span>
                                                                    @if($module['duration'] ?? null)
                                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-500">
                                                                            <i class="fas fa-clock"></i> {{ $module['duration'] }} mins
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 border border-amber-200 rounded-lg text-xs font-semibold text-amber-600">
                                                                        <i class="fas fa-calendar-times"></i> Not scheduled yet
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
                                            <div class="flex gap-2 flex-shrink-0 ml-3">

                                                @if($isLiveCourse)
                                                    @if(($isAdmin || $isInstructor) && !$isLiveNow && !$isEnded)
                                                        <button
                                                            onclick="openScheduleModal(
                                                                {{ $module['id'] }},
                                                                '{{ addslashes($module['title'] ?? 'Session ' . $module['id']) }}',
                                                                '{{ $module['date'] ?? '' }}',
                                                                '{{ $module['start_time'] ?? '' }}',
                                                                '{{ $module['duration'] ?? '' }}'
                                                            )"
                                                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg font-medium hover:bg-indigo-50 hover:border-indigo-400 hover:text-indigo-700 transition-all text-sm"
                                                            title="Edit Schedule">
                                                            <i class="fas fa-calendar-edit text-xs"></i>
                                                            <span class="hidden sm:inline">Schedule</span>
                                                        </button>
                                                    @endif

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
                                                        @if($isInstructor || $isAdmin)
                                                            @if($inGoLiveWindow)
                                                                <a href="{{ route('instructor.live_session.go_live', ['course' => $course->id, 'session' => $module['id']]) }}"
                                                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-all text-sm">
                                                                    <i class="fas fa-broadcast-tower text-xs"></i> Go Live
                                                                </a>
                                                            @else
                                                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg font-medium text-sm cursor-not-allowed"
                                                                      title="{{ $goLiveWindowMsg }}">
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
                                                    {{-- Recorded course actions --}}
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
                        <a href="javascript:history.back()"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>
            </main>
        </div>

        <!-- ── Edit Schedule Modal ─────────────────────────────────────────── -->
        <div id="schedule-modal">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-md mx-4 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-edit text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Edit Session Schedule</h3>
                            <p id="modal-session-title" class="text-xs text-gray-500 mt-0.5"></p>
                        </div>
                    </div>
                    <button onclick="closeScheduleModal()"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <form id="schedule-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <i class="fas fa-calendar-alt text-indigo-500 mr-1"></i> Session Date
                            </label>
                            <input type="date" name="date" id="modal-date" required
                                   class="modal-input w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <i class="fas fa-clock text-indigo-500 mr-1"></i> Start Time
                            </label>
                            <input type="time" name="start_time" id="modal-start-time"
                                   class="modal-input w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                <i class="fas fa-hourglass-half text-indigo-500 mr-1"></i> Duration (minutes)
                            </label>
                            <input type="number" name="duration_minutes" id="modal-duration"
                                   min="15" max="480" placeholder="e.g. 60"
                                   class="modal-input w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white transition-all">
                        </div>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3">
                        <button type="button" onclick="closeScheduleModal()"
                                class="px-4 py-2 text-sm font-semibold text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i> Save Schedule
                        </button>
                    </div>
                </form>
            </div>
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

    <script>
        const SCHEDULE_BASE = "{{ url($isAdmin ? 'admin_panel' : 'instructor') }}/manage_resources/{{ $course->id }}/session";

        function openScheduleModal(sessionId, title, date, startTime, duration) {
            document.getElementById('modal-session-title').textContent = title;
            document.getElementById('modal-date').value       = date      || '';
            document.getElementById('modal-start-time').value = startTime ? startTime.substring(0, 5) : '';
            document.getElementById('modal-duration').value   = duration  || '';
            document.getElementById('schedule-form').action   = `${SCHEDULE_BASE}/${sessionId}/schedule`;
            document.getElementById('schedule-modal').classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeScheduleModal() {
            document.getElementById('schedule-modal').classList.remove('open');
            document.body.style.overflow = '';
        }

        document.getElementById('schedule-modal').addEventListener('click', function(e) {
            if (e.target === this) closeScheduleModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeScheduleModal();
        });
    </script>

</body>
</html>