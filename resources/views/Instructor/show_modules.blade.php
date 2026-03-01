<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Lectures - {{ $course->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.5s ease-out forwards; }
        @media (min-width: 1024px) { aside { display: block !important; } }
    </style>
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

            <x-instructor-header :title="'Course Lectures'" />

            <div class="p-4 lg:p-6 max-w-5xl mx-auto space-y-6">
                @auth

                    {{-- ── Course Info Card ── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 opacity-0 animate-slide-in">

                        {{-- Course type badge --}}
                        <div class="flex items-center gap-3 mb-3">
                            @if($course->course_type === 'live')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                    <i class="fas fa-circle text-red-500 text-[8px]"></i> Live Course
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-700">
                                    <i class="fas fa-video"></i> Recorded Course
                                </span>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-primary-700 mb-4">{{ $course->title }}</h2>

                        {{-- Progress bar --}}
                        @php
                            $uploadedCount = collect($modules)->where('uploaded', true)->count();
                            $totalModules  = count($modules);
                            $progressPct   = $totalModules > 0 ? ($uploadedCount / $totalModules) * 100 : 0;
                        @endphp

                        <div class="mb-1 flex justify-between text-xs font-medium text-gray-500">
                            <span>Upload progress</span>
                            <span>{{ $uploadedCount }} / {{ $totalModules }} lectures</span>
                        </div>
                        <div class="w-full h-2.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500
                                        {{ $course->course_type === 'live' ? 'bg-indigo-500' : 'bg-teal-500' }}"
                                 style="width: {{ $progressPct }}%"></div>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-400">{{ number_format($progressPct, 1) }}% complete</p>
                    </div>

                    {{-- ── Lectures List ── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden opacity-0 animate-slide-in" style="animation-delay:0.1s">

                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="text-sm font-bold text-primary-700 uppercase tracking-wide">Lecture List</h3>
                        </div>

                        <div class="divide-y divide-gray-100">
                            @foreach ($modules as $module)
                                <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">

                                    {{-- Left: number + status --}}
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm
                                                    {{ $module['uploaded']
                                                        ? 'bg-teal-100 text-teal-700'
                                                        : 'bg-gray-100 text-gray-500' }}">
                                            {{ $module['id'] }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800">Lecture {{ $module['id'] }}</p>
                                            @if($module['uploaded'])
                                                <p class="text-xs text-teal-600 font-medium mt-0.5">
                                                    <i class="fas fa-check-circle mr-1"></i>Uploaded
                                                </p>
                                            @else
                                                <p class="text-xs text-amber-500 font-medium mt-0.5">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Right: action buttons --}}
                                    <div class="flex items-center gap-2">

                                        {{-- View button (only if uploaded) --}}
                                        @if($module['uploaded'])
                                            <a href="/view_pending_resources/{{ $course->id }}/{{ $module['id'] }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 transition-all">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        @endif

                                        {{-- Upload / Edit button --}}
                                        @if($course->course_type === 'recorded')
                                            <a href="/instructor/manage_resources/{{ $course->id }}/modules/{{ $module['id'] }}/edit"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-primary-700 text-white hover:bg-primary-800 transition-all">
                                                <i class="fas fa-{{ $module['uploaded'] ? 'pen' : 'upload' }}"></i>
                                                {{ $module['uploaded'] ? 'Edit' : 'Upload' }}
                                            </a>
                                        @else
                                            {{-- Live: redirect to session schedule/pdf page --}}
                                            <a href="{{ route('instructor.live_session.edit', ['course' => $course->id, 'session' => $module['id']]) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition-all">
                                                <i class="fas fa-{{ $module['uploaded'] ? 'pen' : 'calendar-plus' }}"></i>
                                                {{ $module['uploaded'] ? 'Edit Session' : 'Schedule' }}
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Submit / Back ── --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 opacity-0 animate-slide-in" style="animation-delay:0.2s">
                        <div class="flex flex-col sm:flex-row items-center gap-3">

                            @if($allUploaded)
                                <a href="{{ $alreadySubmitted ? '#' : route('instructor.manage_resources', ['course' => $course->id]) }}"
                                   id="submit-review-btn"
                                   class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>{{ $alreadySubmitted ? 'Already Submitted' : 'Submit For Review' }}</span>
                                </a>
                            @else
                                <button disabled
                                        class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-gray-300 text-gray-500 rounded-lg font-medium cursor-not-allowed">
                                    <i class="fas fa-lock"></i>
                                    <span>Upload all lectures first</span>
                                </button>
                            @endif

                            <a href="javascript:history.back()"
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all">
                                <i class="fas fa-arrow-left"></i>
                                <span>Back</span>
                            </a>

                        </div>
                    </div>

                @else
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md mx-auto">
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-6 border border-red-200">
                                <i class="fas fa-lock text-3xl text-red-600"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-teal-900 mb-3">Access Denied</h2>
                            <p class="text-teal-600 mb-6">You need to be logged in to view this page.</p>
                            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition-all hover:shadow-lg">
                                <i class="fas fa-sign-in-alt"></i> Go to Login
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const submitBtn = document.getElementById('submit-review-btn');
            @if($alreadySubmitted ?? false)
                if (submitBtn) {
                    submitBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        alert('This course has already been submitted for review!');
                    });
                }
            @endif
        });
    </script>

</body>
</html>