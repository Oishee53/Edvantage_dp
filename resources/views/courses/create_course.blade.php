<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Course</title>
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
        
        @media (min-width: 1024px) {
            aside {
                display: block !important;
            }
        }
    </style>
</head>
<body class="bg-teal-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            <!-- Header -->
            <header class="bg-white sticky top-0 z-40 border-b border-teal-200 shadow-sm">
                <div class="px-4 lg:px-6 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Mobile Toggle Button -->
                            <button 
                                @click="sidebarOpen = !sidebarOpen" 
                                class="lg:hidden p-2 hover:bg-teal-100 rounded-lg transition-colors">
                                <i class="fas fa-bars text-lg text-teal-700"></i>
                            </button>
                            
                            <div>
                                <h1 class="text-xl lg:text-2xl font-bold text-teal-900">
                                    Add New Course
                                </h1>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ notifOpen: false }">
                                <button @click="notifOpen = !notifOpen" 
                                        class="relative w-10 h-10 flex items-center justify-center hover:bg-teal-100 rounded-lg transition-all duration-200">
                                    <i class="fa fa-bell text-lg text-teal-700"></i>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white text-[10px] px-1">
                                            {{ auth()->user()->unreadNotifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <div x-show="notifOpen" 
                                     @click.away="notifOpen = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 top-full mt-2 w-80 lg:w-96 bg-white rounded-xl shadow-xl border border-teal-200 overflow-hidden"
                                     style="display: none;">
                                    <div class="px-4 py-3 border-b border-teal-200 bg-teal-50">
                                        <h3 class="font-semibold text-teal-900 text-sm">Notifications</h3>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto">
                                        @forelse(auth()->user()->unreadNotifications as $notification)
                                            @php
                                                switch ($notification->type) {
                                                    case 'App\Notifications\approveCourseNotification':
                                                         $route = url("/admin_panel/manage_resources/{$notification->data['course_id']}/modules");
                                                        break;    
                                                    case 'App\Notifications\rejectCourseNotification':
                                                        $route = route('rejected.course.show');
                                                        break;
                                                    case 'App\Notifications\NewQuestionNotification':
                                                        $route = route('instructor.questions.show', $notification->data['question_id']); 
                                                        break;
                                                    case 'App\Notifications\CourseUpdatedNotification':
                                                        $route = route('notifications.read', $notification->id);
                                                        break;
                                                    default:
                                                        $route = route('notifications.read', $notification->id);
                                                }
                                            @endphp

                                            <a href="{{ $route }}" class="block px-4 py-3 hover:bg-teal-50 transition-colors border-b border-teal-100 last:border-b-0">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0
                                                        @if($notification->type === 'App\Notifications\approveCourseNotification') bg-green-100
                                                        @elseif($notification->type === 'App\Notifications\rejectCourseNotification') bg-red-100
                                                        @elseif($notification->type === 'App\Notifications\NewQuestionNotification') bg-blue-100
                                                        @else bg-teal-100
                                                        @endif">
                                                        @if($notification->type === 'App\Notifications\approveCourseNotification')
                                                            <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                                        @elseif($notification->type === 'App\Notifications\rejectCourseNotification')
                                                            <i class="fas fa-times-circle text-red-600 text-sm"></i>
                                                        @elseif($notification->type === 'App\Notifications\NewQuestionNotification')
                                                            <i class="fas fa-question-circle text-blue-600 text-sm"></i>
                                                        @else
                                                            <i class="fas fa-info-circle text-teal-600 text-sm"></i>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold text-teal-900 mb-1 leading-tight">
                                                            @if($notification->type === 'App\Notifications\approveCourseNotification')
                                                                {{ $notification->data['content'] }}
                                                            @elseif($notification->type === 'App\Notifications\rejectCourseNotification')
                                                                Course rejected: {{ $notification->data['course_title'] }}
                                                            @elseif($notification->type === 'App\Notifications\NewQuestionNotification')
                                                                {{ $notification->data['content'] }}
                                                            @elseif($notification->type === 'App\Notifications\CourseUpdatedNotification')
                                                                {{ $notification->data['content'] }}
                                                            @elseif($notification->type === 'App\Notifications\CourseDeleteNotification')
                                                                {{ $notification->data['content'] }}
                                                            @endif
                                                        </p>
                                                        <p class="text-xs text-teal-500">{{ $notification->created_at->diffForHumans() }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="px-4 py-10 text-center">
                                                <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-bell-slash text-2xl text-teal-400"></i>
                                                </div>
                                                <p class="text-sm text-teal-600 font-medium">No new notifications</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <!-- Student View Link -->
                            <a href="/homepage" class="flex items-center gap-2 px-3 lg:px-4 py-2 bg-teal-600 text-white rounded-lg font-medium text-sm hover:bg-teal-800 transition-all duration-200 hover:shadow-md">
                                <i class="fas fa-user-graduate text-xs"></i>
                                <span class="hidden sm:inline">Student View</span>
                            </a>

                            <!-- Logout -->
                            <form action="/logout" method="POST" class="m-0">
                                @csrf
                                <button class="px-3 lg:px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm shadow-sm hover:shadow-md transition-all duration-200">
                                    <i class="fas fa-sign-out-alt text-xs mr-1.5"></i>
                                    <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-6 max-w-7xl mx-auto">
                @auth
                    <!-- Form Card -->
                    <div class="max-w-3xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-sm border border-teal-200 overflow-hidden opacity-0 animate-slide-in">
                            <div class="p-6 lg:p-8">
                                @if(auth()->user()->role === 2)
                                <form action="/admin/manage_courses/create" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @elseif(auth()->user()->role === 3)
                                <form action="/instructor/manage_courses/create" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @endif
                                    @csrf
                                    
                                    <!-- Course Image -->
                                    <div>
                                        <label for="image" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-image text-teal-700 mr-2"></i>Course Image <span class="text-red-600">*</span>
                                        </label>
                                        <input type="file" id="image" name="image" accept="image/*" 
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-600 file:text-white hover:file:bg-teal-800 file:cursor-pointer" 
                                            required>
                                    </div>

                                    <!-- Course Title -->
                                    <div>
                                        <label for="title" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-heading text-teal-700 mr-2"></i>Course Title <span class="text-red-600">*</span>
                                        </label>
                                        <input type="text" id="title" name="title" 
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                            placeholder="Enter course title..."
                                            required>
                                    </div>

                                    <!-- Course Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-align-left text-teal-700 mr-2"></i>Course Description
                                        </label>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium resize-none" 
                                            placeholder="Enter course description..."></textarea>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <label for="category" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-tag text-teal-700 mr-2"></i>Category <span class="text-red-600">*</span>
                                        </label>
                                        <select id="category" name="category" 
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white" 
                                            required>
                                            <option value="">Select Category</option>
                                            <option value="Web Development">Web Development</option>
                                            <option value="Mobile Development">Mobile Development</option>
                                            <option value="Data Science">Data Science</option>
                                            <option value="Machine Learning">Machine Learning</option>
                                            <option value="Design">Design</option>
                                            <option value="Business">Business</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="level" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-layer-group text-teal-700 mr-2"></i>Course Level <span class="text-red-600">*</span>
                                        </label>
                                        <select id="level" name="level"
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white"
                                            required>
                                            <option value="">Select Level</option>
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                        </select>
                                    </div>

                                    <!-- Grid for Number Fields -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Number of Lectures -->
                                        <div>
                                            <label for="video_count" class="block text-sm font-bold text-teal-900 mb-2">
                                                <i class="fas fa-video text-teal-700 mr-2"></i>Number of Lectures <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" id="video_count" name="video_count" min="1"
                                                class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="e.g., 10"
                                                required>
                                        </div>

                                        <!-- Approx Video Length -->
                                        <div>
                                            <label for="approx_video_length" class="block text-sm font-bold text-teal-900 mb-2">
                                                <i class="fas fa-stopwatch text-teal-700 mr-2"></i>Avg. Lecture Length (min) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" id="approx_video_length" name="approx_video_length" min="1"
                                                class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="e.g., 45"
                                                required>
                                        </div>

                                        <!-- Total Duration -->
                                        <div>
                                            <label for="total_duration" class="block text-sm font-bold text-teal-900 mb-2">
                                                <i class="fas fa-clock text-teal-700 mr-2"></i>Total Duration (hours) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" id="total_duration" name="total_duration" step="0.1" min="0.1"
                                                class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="e.g., 8.5"
                                                required>
                                        </div>

                                        <!-- Price -->
                                        <div>
                                            <label for="price" class="block text-sm font-bold text-teal-900 mb-2">
                                                <i class="fas fa-bangladeshi-taka-sign text-teal-700 mr-2"></i>Price (৳) <span class="text-red-600">*</span>
                                            </label>
                                            <input type="number" id="price" name="price" step="0.01" min="0"
                                                class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="e.g., 2500"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Course Prerequisite -->
                                    <div>
                                        <label for="prerequisite" class="block text-sm font-bold text-teal-900 mb-2">
                                            <i class="fas fa-list-check text-teal-700 mr-2"></i>Course Prerequisites (Optional)
                                        </label>
                                        <input type="text" id="prerequisite" name="prerequisite"
                                            class="w-full px-4 py-2.5 border border-teal-300 rounded-lg focus:border-teal-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                            placeholder="e.g., Basic HTML & CSS knowledge">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-teal-200">
                                        <button type="submit" class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md">
                                            <i class="fas fa-save"></i>
                                            <span>Save Course</span>
                                        </button>
                                        
                                        @if(auth()->user()->role === 2)
                                        <a href="/admin_panel/manage_courses" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-teal-300 rounded-lg font-medium hover:bg-teal-50 hover:border-teal-900 transition-all">
                                        @elseif(auth()->user()->role === 3)
                                        <a href="/instructor/manage_courses" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-teal-300 rounded-lg font-medium hover:bg-teal-50 hover:border-teal-900 transition-all">
                                        @endif
                                            <i class="fas fa-arrow-left"></i>
                                            <span>Back</span>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Not Logged In -->
                    <div class="bg-white rounded-2xl shadow-xl border border-teal-200 overflow-hidden max-w-md mx-auto">
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-6 border border-red-200">
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
                @endauth
            </div>
        </main>
    </div>
</body>
</html>