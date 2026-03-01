<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Session {{ $session->session_number }} - {{ $course->title }}</title>
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
        @media (min-width: 1024px) { aside { display: block !important; } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">

        @include('layouts.sidebar')

        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">

            <x-instructor-header :title="'Review Session ' . $session->session_number" />

            <div class="p-4 lg:p-6 max-w-3xl mx-auto space-y-6">

                {{-- Course + session badge --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 opacity-0 animate-slide-in">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700">
                            <i class="fas fa-circle text-red-500 text-[8px]"></i> Live Course
                        </span>
                        <span class="text-xs text-gray-400 font-medium">Session {{ $session->session_number }}</span>
                    </div>
                    <h2 class="text-lg font-bold text-primary-700">{{ $course->title }}</h2>
                    <p class="text-xs text-gray-400 mt-1">Instructor: {{ $course->instructor->name ?? '—' }}</p>
                </div>

                {{-- Session details --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 opacity-0 animate-slide-in" style="animation-delay:0.1s">
                    <h3 class="text-sm font-bold text-primary-700 uppercase tracking-wide mb-4">Session Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Title --}}
                        <div class="col-span-2">
                            <p class="text-xs text-gray-400 font-medium mb-1">Session Title</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $session->title ?? '—' }}
                            </p>
                        </div>

                        {{-- Date --}}
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Date</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-calendar-alt text-indigo-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                            </p>
                        </div>

                        {{-- Start Time --}}
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Start Time</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-clock text-indigo-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }}
                            </p>
                        </div>

                        {{-- Duration --}}
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Duration</p>
                            <p class="text-sm font-semibold text-gray-800">
                                <i class="fas fa-hourglass-half text-indigo-400 mr-1"></i>
                                {{ $session->duration_minutes }} minutes
                            </p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-1">Status</p>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold
                                {{ $session->status === 'scheduled' ? 'bg-amber-100 text-amber-700' :
                                   ($session->status === 'live'      ? 'bg-red-100 text-red-700' :
                                                                        'bg-teal-100 text-teal-700') }}">
                                {{ ucfirst($session->status) }}
                            </span>
                        </div>

                    </div>
                </div>

                {{-- PDF material --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 opacity-0 animate-slide-in" style="animation-delay:0.2s">
                    <h3 class="text-sm font-bold text-primary-700 uppercase tracking-wide mb-4">Session Material</h3>

                    @if($session->pdf)
                        <div class="flex items-center gap-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-file-pdf text-red-500 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">PDF Uploaded</p>
                                <a href="{{ $session->pdf }}" target="_blank"
                                   class="text-xs text-indigo-600 hover:underline truncate block mt-0.5">
                                    View PDF <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                <i class="fas fa-file-pdf text-gray-400 text-lg"></i>
                            </div>
                            <p class="text-sm text-gray-400 italic">No PDF uploaded for this session.</p>
                        </div>
                    @endif
                </div>

                {{-- Back button --}}
                <div class="opacity-0 animate-slide-in" style="animation-delay:0.3s">
                    <a href="{{ url()->previous() }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Course Review</span>
                    </a>
                </div>

            </div>
        </main>
    </div>

</body>
</html>