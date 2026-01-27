<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Lecture Resources</title>
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
        .resource-section:nth-child(1) { animation-delay: 0.1s; }
        .resource-section:nth-child(2) { animation-delay: 0.2s; }
        .resource-section:nth-child(3) { animation-delay: 0.3s; }
        .resource-section:nth-child(4) { animation-delay: 0.4s; }

        @media (min-width: 1024px) {
            aside {
                display: block !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    @auth
        <div x-data="{ 
            sidebarOpen: window.innerWidth >= 1024, 
            sidebarCollapsed: false,
            videoOpen: false
        }" 
             @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
             class="flex min-h-screen">
            
            <!-- Sidebar Component -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 transition-all duration-300"
                  :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
                
                <!-- Header -->
                <x-instructor-header :title="$pageTitle ?? 'Lecture Resources'" />

                <!-- Page Content -->
                <div class="p-4 lg:p-6 max-w-5xl mx-auto pr-10">
                    <!-- Alert Message -->
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6 opacity-0 animate-slide-in">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-exclamation-circle text-lg"></i>
                                <p class="font-semibold">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Course Information Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                        <div class="px-6 py-4 bg-gray-100">
                            <h2 class="text-xl font-bold text-white flex items-center gap-3">
                                {{ $course->name }}
                            </h2>
                            <p class="text-gray-500 mt-2 flex items-center gap-2 text-sm">
                                <span>Lecture {{ $moduleNumber }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Video Content Section -->
                    @if($resource->videos)
                        <div class="resource-section bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                    <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-video text-white text-sm"></i>
                                    </div>
                                    Video Content
                                </h3>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-play-circle text-2xl text-teal-700"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-bold text-teal-900 mb-2">Interactive Video Lesson</h4>
                                        <p class="text-sm text-teal-600 mb-4">Watch the complete lecture video with interactive features and progress tracking.</p>
                                        <button @click="videoOpen = !videoOpen" 
                                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                                            <i class="fas" :class="videoOpen ? 'fa-chevron-up' : 'fa-play'"></i>
                                            <span x-text="videoOpen ? 'Hide Video' : 'View Video'"></span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div x-show="videoOpen"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 transform -translate-y-4"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 transform translate-y-0"
                                     x-transition:leave-end="opacity-0 transform -translate-y-4"
                                     class="rounded-xl overflow-hidden shadow-lg mt-4"
                                     style="display: none;">
                                    <mux-player 
                                        id="mux-player"
                                        playback-id="{{ $resource->videos }}"
                                        stream-type="on-demand"
                                        controls
                                        style="width: 100%; aspect-ratio: 16/9;">
                                    </mux-player>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- PDF Content Section -->
                    @if($resource->pdf)
                        <div class="resource-section bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                    <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-white text-sm"></i>
                                    </div>
                                    Course Materials
                                </h3>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-file-alt text-2xl text-teal-700"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-bold text-teal-900 mb-2">PDF Document</h4>
                                        <p class="text-sm text-teal-600 mb-4">Download or view the lecture materials and supplementary resources.</p>
                                        <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
                                           target="_blank"
                                           rel="noopener noreferrer" 
                                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                                            <i class="fas fa-eye"></i>
                                            <span>View PDF</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quiz Section -->
                    <div class="resource-section bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-question-circle text-white text-sm"></i>
                                </div>
                                Lecture Assessment
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @if($quiz)
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0 border border-green-200">
                                        <i class="fas fa-clipboard-check text-2xl text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h4 class="text-base font-bold text-teal-900">Quiz Available</h4>
                                            <span class="px-2.5 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold border border-green-200">
                                                <i class="fas fa-check-circle mr-1"></i>Ready
                                            </span>
                                        </div>
                                        <p class="text-sm text-teal-600 mb-4">Test your understanding of this lecture with an interactive quiz.</p>
                                        <a href="#" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                                            <i class="fas fa-play"></i>
                                            <span>Start Quiz</span>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-info-circle text-2xl text-teal-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-bold text-teal-900 mb-2">No Quiz Available</h4>
                                        <p class="text-sm text-teal-600 italic">The quiz for this lecture has not been created yet. Check back later!</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Discussion Forum Section -->
                    <div class="resource-section bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-comments text-white text-sm"></i>
                                </div>
                                Discussion Forum
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @if($forum)
                                <x-discussion-forum :forum="$forum" :course="$course" />
                            @else
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-comment-slash text-2xl text-teal-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-bold text-teal-900 mb-2">Discussion Forum Not Available</h4>
                                        <p class="text-sm text-teal-600">The discussion forum for this lecture is not yet set up. You can still ask questions directly to your instructor.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="flex justify-start">
                        <a href="javascript:history.back()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-gray-50 hover:border-gray-900 transition-all shadow-sm hover:shadow-md">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span>Back to Lectures</span>
                        </a>
                    </div>
                </div>
            </main>
        </div>
    @else
        <!-- Not Logged In -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md w-full">
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-amber-50 rounded-xl flex items-center justify-center mx-auto mb-6 border border-amber-200">
                        <i class="fas fa-lock text-3xl text-amber-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-teal-900 mb-3">Authentication Required</h2>
                    <p class="text-teal-600 mb-6">Please log in to access course materials and lecture resources.</p>
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition-all hover:shadow-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    @endauth

    <!-- Mux Player Script -->
    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

    <!-- JavaScript -->
    <script>
        // Video Progress Tracking
        document.addEventListener('DOMContentLoaded', function () {
            const player = document.getElementById('mux-player');
            if (!player) return;

            let lastSavedProgress = 0;

            player.addEventListener('timeupdate', async function () {
                const progressPercent = (player.currentTime / player.duration) * 100;

                if (progressPercent - lastSavedProgress >= 10) {
                    lastSavedProgress = progressPercent;

                    await fetch('{{ route("video.progress.save") }}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            course_id: {{ $course->id }},
                            resource_id: {{ $resource->id }},
                            progress_percent: progressPercent
                        })
                    });
                }
            });

            player.addEventListener('ended', async function () {
                await fetch('{{ route("video.progress.save") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        course_id: {{ $course->id }},
                        resource_id: {{ $resource->id }},
                        progress_percent: 100
                    })
                });
            });
        });
    </script>
</body>
</html>