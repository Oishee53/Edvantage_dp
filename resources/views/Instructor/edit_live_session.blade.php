<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Session {{ $session_number }} - {{ $course->title }}</title>
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

            <x-instructor-header :title="'Schedule Session ' . $session_number" />

            <div class="p-4 lg:p-6 max-w-7xl mx-auto">
                @auth
                    <div class="max-w-xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden opacity-0 animate-slide-in">
                            <div class="p-6 lg:p-8">

                                {{-- Header info --}}
                                <div class="mb-6 pb-6 border-b border-gray-100">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                                            <i class="fas fa-circle text-red-500 text-[8px]"></i> Live Course
                                        </span>
                                        <span class="text-xs text-gray-400 font-medium">Session {{ $session_number }}</span>
                                    </div>
                                    <h2 class="text-base font-bold text-primary-700 mt-1">{{ $course->title }}</h2>
                                </div>

                                {{-- Success / Error messages --}}
                                @if(session('success'))
                                    <div class="mb-4 px-4 py-3 bg-teal-50 border border-teal-200 rounded-lg text-teal-700 text-sm font-medium">
                                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Form --}}
                                <form action="{{ route('instructor.live_session.update', ['course' => $course->id, 'session' => $session_number]) }}"
                                      method="POST"
                                      enctype="multipart/form-data"
                                      class="space-y-5">
                                    @csrf
                                    @method('PUT')

                                    <!-- Session Title -->
                                    <div>
                                        <label for="title" class="block text-sm font-bold text-teal-900 mb-2">
                                            Session Title <span class="text-gray-400 font-normal">(Optional)</span>
                                        </label>
                                        <input type="text" id="title" name="title"
                                               value="{{ old('title', $session?->title) }}"
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                                               placeholder="e.g. Introduction to the topic">
                                    </div>

                                    <!-- Date -->
                                    <div>
                                        <label for="date" class="block text-sm font-bold text-teal-900 mb-2">
                                            Session Date <span class="text-gray-900">*</span>
                                        </label>
                                        <input type="date" id="date" name="date"
                                               value="{{ old('date', $session?->date?->format('Y-m-d')) }}"
                                               min="{{ now()->format('Y-m-d') }}"
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                                               required>
                                    </div>

                                    <!-- Start Time + Duration side by side -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label for="start_time" class="block text-sm font-bold text-teal-900 mb-2">
                                                Start Time <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="time" id="start_time" name="start_time"
                                                   value="{{ old('start_time', $session?->start_time) }}"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                                                   required>
                                        </div>
                                        <div>
                                            <label for="duration_minutes" class="block text-sm font-bold text-teal-900 mb-2">
                                                Duration (min) <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="number" id="duration_minutes" name="duration_minutes"
                                                   value="{{ old('duration_minutes', $session?->duration_minutes) }}"
                                                   min="15" placeholder="90"
                                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none font-medium"
                                                   required>
                                        </div>
                                    </div>

                                    <!-- PDF Upload -->
                                    <div>
                                        <label for="pdf" class="block text-sm font-bold text-teal-900 mb-2">
                                            Session Material (PDF)
                                            <span class="text-gray-400 font-normal">(Optional)</span>
                                        </label>

                                        {{-- Show existing PDF if already uploaded --}}
                                        @if($session?->pdf)
                                            <div class="mb-3 flex items-center gap-3 px-4 py-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                                                <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-gray-700">Current PDF</p>
                                                    <a href="{{ $session->pdf }}" target="_blank"
                                                       class="text-xs text-indigo-600 hover:underline truncate block">
                                                        View uploaded PDF
                                                    </a>
                                                </div>
                                                <span class="text-xs text-gray-400">Upload a new file to replace</span>
                                            </div>
                                        @endif

                                        <input type="file" id="pdf" name="pdf" accept="application/pdf"
                                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none font-medium bg-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:cursor-pointer">
                                        <p class="mt-1.5 text-xs text-gray-400">Max file size: 10MB</p>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-5 border-t border-gray-100">
                                        <button type="submit"
                                                class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-800 transition-all hover:shadow-md">
                                            <i class="fas fa-save"></i>
                                            <span>Save Session</span>
                                        </button>

                                        <a href="/instructor/manage_resources/{{ $course->id }}/modules"
                                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all">
                                            <i class="fas fa-arrow-left"></i>
                                            <span>Back</span>
                                        </a>
                                    </div>

                                </form>
                            </div>
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

</body>
</html>