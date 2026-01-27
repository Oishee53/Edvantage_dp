<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - EDVANTAGE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }
        
        .course-card {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .course-card:hover {
            transform: translateY(-2px);
        }
        
        .course-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
        }
        
        .progress-ring {
            transition: stroke-dashoffset 0.5s ease;
        }
    </style>
</head>
<body class="bg-gray-50 px-20 pt-5">
    @include('layouts.header')

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Recent Activity Section (Only courses with progress > 0) -->
            @php
                $recentCourses = collect($enrolledCourses)->filter(function($course) use ($courseProgress) {
                    $progress = $courseProgress[$course->id] ?? ['completion_percentage' => 0];
                    return $progress['completion_percentage'] > 0;
                });
            @endphp

            @if($recentCourses->count() > 0)
            <div class="mb-16">
                <h2 class="text-2xl font-semibold text-gray-900 mb-8">Recent activity</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recentCourses as $course)
                        @php
                            $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
                        @endphp

                        <a href="{{ route('user.course.modules', $course->id) }}" class="course-card block rounded-2xl overflow-hidden shadow-md hover:shadow-xl group">
                            <!-- Course Image with Overlay -->
                            <div class="relative h-72">
                                <img src="{{ asset('storage/' . $course->image) }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-full h-full object-cover">
                                
                                <!-- Gradient Overlay -->
                                <div class="course-overlay absolute inset-0"></div>
                                
                                <!-- Content Overlay -->
                                <div class="absolute inset-0 p-6 flex flex-col justify-between">
                                    <!-- Top Section -->
                                    <div class="flex items-start justify-between">
                                        <!-- Progress Badge -->
                                        @if($progress['completion_percentage'] == 100)
                                        <div class="flex items-center gap-2 bg-green-500/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                            <i class="fas fa-check text-white text-xs"></i>
                                            
                                        </div>
                                        @else
                                        <div class="flex items-center gap-2 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                            <span class="text-xs font-semibold text-gray-700">Continue Course</span>
                                        </div>
                                        @endif
                                        
                                        <!-- Play Button -->
                                        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                            <i class="fas fa-play text-white text-sm ml-0.5"></i>
                                        </div>
                                    </div>

                                    <!-- Bottom Section -->
                                    <div>
                                        <h3 class="text-white font-semibold text-lg mb-2 line-clamp-2 leading-snug">
                                            {{ $course->title }}
                                        </h3>
                                        
                                        <!-- Progress Info -->
                                        <div class="flex items-center justify-between text-white/90 text-xs mb-2">
                                            <span>Completed {{ $progress['completed_videos'] ?? 0 }}/{{ $progress['total_videos'] ?? 0 }}</span>
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="h-1 bg-white/20 rounded-full overflow-hidden">
                                            <div class="h-full bg-white rounded-full transition-all duration-1000" 
                                                 style="width: {{ $progress['completion_percentage'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- All Courses Section -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-8">All</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($enrolledCourses as $course)
                        @php
                            $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
                        @endphp
                        
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <a href="{{ route('user.course.modules', $course->id) }}" class="block">
                                <!-- Course Thumbnail -->
                                <div class="relative h-40">
                                    <img src="{{ asset('storage/' . $course->image) }}" 
                                         alt="{{ $course->title }}" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    
                                    <!-- Play Button -->
                                    <div class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center">
                                        <i class="fas fa-play text-gray-700 text-xs ml-0.5"></i>
                                    </div>
                                    
                                    <!-- Step Info -->
                                    <div class="absolute bottom-2 left-2 text-white text-xs font-medium">
                                        Step {{ $progress['completed_videos'] ?? 0 }}/{{ $progress['total_videos'] ?? 0 }}
                                    </div>
                                </div>
                                
                                <!-- Course Info -->
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2 leading-tight">
                                        {{ $course->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        Course, {{ $course->total_duration ?? '0' }} hours
                                    </p>
                                </div>
                            </a>
                        </div>

                    @empty
                        <!-- Empty State -->
                        <div class="col-span-full bg-white rounded-2xl shadow-md p-16">
                            <div class="text-center max-w-md mx-auto">
                                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-book-open text-4xl text-gray-300"></i>
                                </div>
                                
                                <h3 class="text-2xl font-semibold text-gray-900 mb-3">No courses yet</h3>
                                <p class="text-gray-500 mb-8 text-sm">
                                    Start your learning journey by enrolling in a course
                                </p>
                                
                                <a href="/homepage" 
                                   class="inline-block px-8 py-3 bg-teal-600 text-white text-sm font-medium rounded-xl hover:bg-teal-700 transition-colors">
                                    Browse Courses
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <script>
        // Smooth progress bar animation on load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.bg-white.rounded-full');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
</body>
</html>