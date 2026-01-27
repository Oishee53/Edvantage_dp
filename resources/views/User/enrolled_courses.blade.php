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
    </style>
</head>
<body class="bg-gray-50 px-20 pt-5">
    @include('layouts.header')

    <main class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Page Header -->
            <div class="mb-12">
                <h1 class="text-4xl md:text-4xl font-bold text-gray-900 mb-3">My Courses</h1>
                <p class="text-lg text-gray-600">Continue your learning journey</p>
            </div>

            <!-- Courses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @forelse ($enrolledCourses as $course)
                    @php
                        $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
                    @endphp

                    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden hover:shadow-lg hover:border-teal-500 transition-all group">
                        <!-- Course Image -->
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ asset('storage/' . $course->image) }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            
                            <!-- Progress Badge -->
                            @if($progress['completion_percentage'] == 100)
                            <div class="absolute top-3 right-3">
                                <div class="w-10 h-10 rounded-full bg-green-500 border-2 border-white flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                            </div>
                            @else
                            <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-3 py-1 rounded-full shadow-md">
                                <span class="text-sm font-bold text-teal-600">{{ $progress['completion_percentage'] }}%</span>
                            </div>
                            @endif
                        </div>

                        <!-- Course Content -->
                        <div class="p-6 space-y-4">
                            <!-- Course Title -->
                            <a href="{{ route('user.course.modules', $course->id) }}" 
                               class="block text-xl font-bold text-gray-900 hover:text-teal-600 transition-colors line-clamp-2 min-h-[2rem]">
                                {{ $course->title }}
                            </a>

                            <!-- Instructor -->
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-chalkboard-teacher text-teal-600"></i>
                                <span class="font-medium">{{ $course->instructor->name ?? 'Instructor' }}</span>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $course->description }}</p>

                            <!-- Progress Bar -->
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 font-medium">
                                        {{ $progress['completed_videos'] ?? 0 }} / {{ $progress['total_videos'] ?? 0 }} videos
                                    </span>
                                    <span class="font-bold text-teal-600">{{ $progress['completion_percentage'] ?? 0 }}%</span>
                                </div>
                                <div class="h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-teal-600 rounded-full transition-all duration-1000" 
                                         style="width: {{ $progress['completion_percentage'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <!-- Course Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-600 pt-2 border-t border-gray-200">
                                <div class="flex items-center gap-1.5">
                                    <i class="fas fa-play-circle text-teal-600"></i>
                                    <span>{{ $course->video_count ?? 0 }} lectures</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i class="fas fa-clock text-teal-600"></i>
                                    <span>{{ $course->total_duration ?? '0' }}h</span>
                                </div>
                            </div>

                            <!-- Continue Button -->
                            <a href="{{ route('user.course.modules', $course->id) }}" 
                               class="block w-full py-3 bg-teal-600 hover:bg-teal-700 text-white text-center font-semibold rounded-lg transition-colors shadow-md mt-4">
                                <i class="fas fa-play mr-2"></i>
                                Continue Learning
                            </a>
                        </div>
                    </div>

                @empty
                    <!-- Empty State -->
                    <div class="col-span-full bg-white rounded-xl shadow-md border border-gray-200 p-12">
                        <div class="text-center max-w-md mx-auto">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-teal-100 flex items-center justify-center">
                                <i class="fas fa-book-open text-5xl text-teal-600"></i>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Begin Your Learning Journey</h3>
                            <p class="text-gray-600 mb-8 leading-relaxed">
                                Explore our comprehensive course catalog to advance your skills
                            </p>
                            
                            <a href="/homepage" 
                               class="inline-block px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-md">
                                Browse Courses
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <script>
        // Smooth progress bar animation on load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.bg-teal-600.rounded-full');
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
