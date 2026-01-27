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
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            <x-instructor-header :title="$pageTitle ?? 'Add New Course'" />

            <!-- Page Content -->
            <div class="p-4 lg:p-6 max-w-7xl mx-auto">
                @auth
                    <!-- Form Card -->
                    <div class="max-w-xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden opacity-0 animate-slide-in">
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
                                            </i>Course Image <span class="text-gray-900">*</span>
                                        </label>
                                        <input type="file" id="image" name="image" accept="image/*" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-teal-600 file:text-white hover:file:bg-teal-800 file:cursor-pointer" 
                                            required>
                                    </div>

                                    <!-- Course Title -->
                                    <div>
                                        <label for="title" class="block text-sm font-bold text-teal-900 mb-2">
                                            </i>Course Title <span class="text-gray-900">*</span>
                                        </label>
                                        <input type="text" id="title" name="title" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                            placeholder="Enter course title..."
                                            required>
                                    </div>

                                    <!-- Course Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-bold text-teal-900 mb-2">
                                            Course Description
                                        </label>
                                        <textarea id="description" name="description" rows="4"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium resize-none" 
                                            placeholder="Enter course description..."></textarea>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <label for="category" class="block text-sm font-bold text-teal-900 mb-2">
                                            Category <span class="text-gray-900">*</span>
                                        </label>
                                        <select id="category" name="category" 
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white" 
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
                                            Course Level <span class="text-gray-900">*</span>
                                        </label>
                                        <select id="level" name="level"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium bg-white"
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
                                                Number of Lectures <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="number" id="video_count" name="video_count" min="1"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="10"
                                                required>
                                        </div>

                                        <!-- Approx Video Length -->
                                        <div>
                                            <label for="approx_video_length" class="block text-sm font-bold text-teal-900 mb-2">
                                                Avg. Lecture Length (min) <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="number" id="approx_video_length" name="approx_video_length" min="1"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="45"
                                                required>
                                        </div>

                                        <!-- Total Duration -->
                                        <div>
                                            <label for="total_duration" class="block text-sm font-bold text-teal-900 mb-2">
                                                Total Duration (hours) <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="number" id="total_duration" name="total_duration" step="0.1" min="0.1"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="8.5"
                                                required>
                                        </div>

                                        <!-- Price -->
                                        <div>
                                            <label for="price" class="block text-sm font-bold text-teal-900 mb-2">
                                                Price (৳) <span class="text-gray-900">*</span>
                                            </label>
                                            <input type="number" id="price" name="price" step="0.01" min="0"
                                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                                placeholder="2500"
                                                required>
                                        </div>
                                    </div>

                                    <!-- Course Prerequisite -->
                                    <div>
                                        <label for="prerequisite" class="block text-sm font-bold text-teal-900 mb-2">
                                            Course Prerequisites (Optional)
                                        </label>
                                        <input type="text" id="prerequisite" name="prerequisite"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                                            placeholder="Basic HTML & CSS knowledge">
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex flex-col sm:flex-row items-center gap-3 pt-6 border-t border-gray-200">
                                        <button type="submit" class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md">
                                            <i class="fas fa-save"></i>
                                            <span>Save Course</span>
                                        </button>
                                        
                                        @if(auth()->user()->role === 2)
                                        <a href="/admin_panel/manage_courses" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all">
                                        @elseif(auth()->user()->role === 3)
                                        <a href="/instructor/manage_courses" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-teal-50 hover:border-gray-900 transition-all">
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
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md mx-auto">
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