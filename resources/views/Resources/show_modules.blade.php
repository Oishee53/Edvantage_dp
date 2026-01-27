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
        .module-item:nth-child(1) { animation-delay: 0.1s; }
        .module-item:nth-child(2) { animation-delay: 0.15s; }
        .module-item:nth-child(3) { animation-delay: 0.2s; }
        .module-item:nth-child(4) { animation-delay: 0.25s; }
        .module-item:nth-child(5) { animation-delay: 0.3s; }
        
        @media (min-width: 1024px) {
            aside {
                display: block !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    @auth
        <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
             @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
             class="flex min-h-screen">
            
            <!-- Sidebar Component -->
            @include('layouts.sidebar')

            <!-- Main Content -->
            <main class="flex-1 transition-all duration-300"
                  :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
                
                <!-- Header -->
                <x-instructor-header :title="$pageTitle ?? 'Course Lectures'" />


                <!-- Page Content -->
                <div class="p-4 lg:p-6 max-w-7xl mx-auto pr-10">
                    <!-- Course Progress Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-book-open text-white text-sm"></i>
                                </div>
                                {{ $course->title }}
                            </h2>
                        </div>
                        
                        <div class="p-6">
                            @php
                                $totalModules = count($modules);

                                if(auth()->user()->role === 3) {
                                    // Students → Only quizzes count
                                    $completed = collect($modules)->where('quiz', true)->count();
                                } else {
                                    // Instructors/Admins → Both quiz + resource must be true
                                    $completed = collect($modules)->filter(fn($m) => $m['quiz'] && $m['resource'])->count();
                                }

                                $progressPercentage = $totalModules > 0 
                                    ? round(($completed / $totalModules) * 100, 1) 
                                    : 0;
                            @endphp

                            <div class="mb-4">
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
                        </div>
                    </div>

                    <!-- Modules List -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-list text-white text-sm"></i>
                                </div>
                                Lecture List
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @if(count($modules) > 0)
                                <div class="space-y-3">
                                    @foreach ($modules as $module)
                                        <div class="module-item group flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:border-gray-900 hover:shadow-md transition-all duration-200 bg-white hover:bg-teal-50 opacity-0 animate-slide-in">
                                            <!-- Module Info -->
                                            <div class="flex items-center gap-4 flex-1">
                                                <!-- Module Number Badge -->
                                                <div class="w-12 h-12 bg-teal-600 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                                    <span class="text-lg font-bold text-white">{{ $module['id'] }}</span>
                                                </div>

                                                <!-- Module Details -->
                                                <div class="flex-1">
                                                    <h4 class="text-base font-bold text-teal-900 mb-2 group-hover:text-teal-700 transition-colors">
                                                        Lecture {{ $module['id'] }}
                                                    </h4>

                                                    <!-- Status Badges -->
                                                    <div class="flex flex-wrap gap-2">
                                                        @if(auth()->user()->role === 3)
                                                            <!-- Student View: Only Quiz Status -->
                                                            @if($module['quiz'])
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-green-50 border border-green-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-check text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-green-700">Quiz Uploaded</span>
                                                                </div>
                                                            @else
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 border border-amber-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-amber-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-exclamation text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-amber-700">Quiz Pending</span>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <!-- Instructor/Admin View: Quiz + Resource Status -->
                                                            @if($module['quiz'])
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-green-50 border border-green-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-green-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-check text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-green-700">Quiz Uploaded</span>
                                                                </div>
                                                            @else
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 border border-amber-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-amber-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-exclamation text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-amber-700">Quiz Pending</span>
                                                                </div>
                                                            @endif

                                                            @if($module['resource'])
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 border border-blue-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-check text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-blue-700">Resource Uploaded</span>
                                                                </div>
                                                            @else
                                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 border border-amber-200 rounded-lg">
                                                                    <div class="w-4 h-4 bg-amber-500 rounded-full flex items-center justify-center">
                                                                        <i class="fas fa-exclamation text-white text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-xs font-semibold text-amber-700">Resource Pending</span>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="flex gap-2 flex-shrink-0">
                                                <!-- View Button -->
                                                <a href="{{ route('inside.module2', ['courseId' => $course->id, 'moduleNumber' => $module['id']]) }}" 
                                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                                                    <i class="fas fa-eye text-xs"></i>
                                                    <span>View</span>
                                                </a>

                                                <!-- Upload/Edit Button -->
                                                @if(auth()->user()->role === 2)
                                                    <a href="{{ route('module.create', ['course' => $course->id, 'module' => $module['id']]) }}" 
                                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all text-sm">
                                                        @if($module['resource'] || $module['quiz'])
                                                            <i class="fas fa-edit text-xs"></i>
                                                            <span>Edit</span>
                                                        @else
                                                            <i class="fas fa-upload text-xs"></i>
                                                            <span>Upload</span>
                                                        @endif
                                                    </a>
                                                @elseif(auth()->user()->role === 3)
                                                    <a href="{{ route('quiz.create', ['course' => $course->id, 'module' => $module['id']]) }}" 
                                                       class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 text-teal-700 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all text-sm">
                                                        @if($module['quiz'])
                                                            <i class="fas fa-edit text-xs"></i>
                                                            <span>Edit Quiz</span>
                                                        @else
                                                            <i class="fas fa-upload text-xs"></i>
                                                            <span>Upload Quiz</span>
                                                        @endif
                                                    </a>
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
        <!-- Not Logged In -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md w-full">
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-3xl text-red-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-teal-900 mb-3">Access Denied</h2>
                    <p class="text-teal-600 mb-6">You need to be logged in to view this page.</p>
                    <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition-all hover:shadow-lg">
                        <i class="fas fa-sign-in-alt"></i>
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    @endauth
</body>
</html>