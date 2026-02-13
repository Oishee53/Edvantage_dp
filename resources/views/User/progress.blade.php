<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Learning Dashboard - EDVANTAGE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * { font-family: 'Montserrat', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        [x-cloak] { display: none !important; }
        
        .progress-gradient {
            background: linear-gradient(90deg, #0d9488 0%, #14b8a6 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layouts.header')

    <!-- Success/Error Messages -->
    @if(session('error'))
    <div class="fixed top-24 right-6 z-50 max-w-md animate-slide-in" id="errorAlert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-white border-l-4 border-red-500 rounded-lg shadow-xl p-4 flex items-start gap-4">
            <div class="bg-red-50 p-2 rounded-full">
                <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
            </div>
            <div class="flex-1 pt-0.5">
                <h4 class="text-gray-900 font-semibold text-sm">Error</h4>
                <p class="text-gray-600 text-sm mt-1">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-10 p-6 sm:p-10 rounded-3xl bg-gradient-to-r from-teal-900 via-teal-800 to-teal-900 text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-teal-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-16 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-16 -mb-10"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-start md:items-end justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-800/50 border border-teal-700/50 backdrop-blur-sm text-xs font-medium text-teal-200 mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span>
                            Student Dashboard
                        </div>
                        <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-2">
                            Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
                        </h1>
                        <p class="text-teal-100 text-lg max-w-xl">
                            Track your progress, view your achievements, and continue your learning journey.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                <!-- Enrolled -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Enrolled Courses</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ count($courseProgress) }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Completed</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->count() }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <!-- Certificates -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Certificates</p>
                            <h3 class="text-3xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->where('average_percentage', '>=', 70)->count() }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                </div>

                <!-- Avg Quality -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Avg. Progress</p>
                            @php $totalProgress = collect($courseProgress)->avg('completion_percentage'); @endphp
                            <h3 class="text-3xl font-bold text-gray-900">{{ round($totalProgress) }}%</h3>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses List -->
            <div class="space-y-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Your Courses</h2>
                    <div class="text-sm text-gray-500">
                        Top priority for today
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($courseProgress as $progress)
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:border-teal-200 transition-all duration-300" x-data="{ expanded: false }">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-50 text-teal-700 mb-3">
                                        {{ $progress['category'] ?? 'Course' }}
                                    </span>
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight group-hover:text-teal-700 transition-colors">
                                        {{ $progress['course_name'] }}
                                    </h3>
                                </div>
                                @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                                <div class="flex-shrink-0 ml-4" title="Certificate Available">
                                    <div class="w-10 h-10 rounded-full bg-yellow-50 border border-yellow-100 flex items-center justify-center">
                                        <i class="fas fa-certificate text-yellow-500"></i>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Progress -->
                            <div class="mb-6">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-sm font-medium text-gray-600">Course Progress</span>
                                    <span class="text-lg font-bold text-teal-700">{{ $progress['completion_percentage'] }}%</span>
                                </div>
                                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full progress-gradient rounded-full transition-all duration-1000 ease-out" style="width: {{ $progress['completion_percentage'] }}%"></div>
                                </div>
                            </div>

                            <!-- Meta Stats -->
                            <div class="grid grid-cols-2 gap-4 py-4 border-t border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-play text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Videos</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $progress['completed_videos'] }}/{{ $progress['total_videos'] }}</p>
                                    </div>
                                </div>
                                @if(count($progress['quiz_marks']) > 0)
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fas fa-pen-nib text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Quizzes</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ count($progress['quiz_marks']) }} Taken</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-3 mt-4">
                                <button @click="expanded = !expanded" 
                                        class="flex-1 px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 rounded-lg font-medium text-sm transition-colors flex items-center justify-center gap-2">
                                    <span x-text="expanded ? 'Hide Details' : 'View Details'"></span>
                                    <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': expanded}"></i>
                                </button>

                                @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                                <button onclick="openRatingModal({{ $progress['course_id'] }}, '{{ route('certificate.generate', ['userId' => auth()->id(), 'courseId' => $progress['course_id']]) }}')"
                                        class="flex-1 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-medium text-sm transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <i class="fas fa-download text-xs"></i>
                                    <span>Certificate</span>
                                </button>
                                @endif
                            </div>
                        </div>

                        <!-- Expandable Details -->
                        <div x-show="expanded" x-collapse x-cloak class="bg-gray-50 border-t border-gray-100 p-6">
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Quiz Performance</h4>
                            
                            @if(count($progress['quiz_marks']) > 0)
                                <div class="space-y-3">
                                    @foreach($progress['quiz_marks'] as $quiz)
                                    <div class="bg-white rounded-lg p-3 border border-gray-200 flex justify-between items-center shadow-sm">
                                        <span class="text-sm text-gray-700 font-medium">{{ $quiz['quiz_title'] }}</span>
                                        <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-md border border-teal-100">
                                            {{ $quiz['score'] }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-sm text-gray-400 italic">No quizzes completed yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 lg:col-span-2 py-20 bg-white rounded-3xl border border-dashed border-gray-300 text-center">
                        <div class="w-24 h-24 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-graduation-cap text-4xl text-teal-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Ready to start?</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-8">You haven't enrolled in any courses yet. Browse our catalog and start your journey today.</p>
                        <a href="/homepage" class="inline-flex items-center gap-2 px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                            Browse Courses
                            <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Rating Modal -->
    <div id="ratingModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 transform scale-100 transition-transform duration-300">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-2xl text-yellow-500"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Rate this Course</h3>
                <p class="text-gray-500 text-sm mt-1">Share your experience to help others</p>
            </div>

            <form method="POST" action="{{ route('course.rate') }}">
                @csrf
                <input type="hidden" name="course_id" id="rating_course_id">
                <input type="hidden" name="rating" id="rating_value">
                <input type="hidden" name="certificate_url" id="certificate_url">

                <!-- Star Rating -->
                <div id="stars" class="flex justify-center gap-3 mb-8">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" data-value="{{ $i }}" class="text-4xl text-gray-200 hover:scale-110 transition-all duration-200 focus:outline-none">★</button>
                    @endfor
                </div>

                <!-- Review Textarea -->
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-2">Review (Optional)</label>
                    <textarea name="review" 
                              placeholder="What did you like about this course?" 
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-teal-500/10 transition-all resize-none"
                              rows="3"></textarea>
                </div>

                <!-- Actions -->
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="skipRating()" 
                            class="px-4 py-3 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-semibold transition-all">
                        Skip
                    </button>
                    <button type="submit" 
                            class="px-4 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-all shadow-md hover:shadow-lg">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let selectedRating = 0;

    function openRatingModal(courseId, certificateUrl) {
        const modal = document.getElementById('ratingModal');
        modal.classList.remove('hidden');
        // Simple animation entrance
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        }, 10);

        document.getElementById('rating_course_id').value = courseId;
        document.getElementById('certificate_url').value = certificateUrl;
        selectedRating = 0;
        
        // Reset stars
        updateStars(0);
    }

    function skipRating() {
        const url = document.getElementById('certificate_url').value;
        const modal = document.getElementById('ratingModal');
        modal.classList.add('hidden');
        window.location.href = url;
    }

    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#stars button');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.dataset.value);
                document.getElementById('rating_value').value = selectedRating;
                updateStars(selectedRating);
            });
            
            star.addEventListener('mouseenter', function() {
                updateStars(parseInt(this.dataset.value));
            });
        });
        
        document.getElementById('stars').addEventListener('mouseleave', function() {
            updateStars(selectedRating);
        });
    });

    function updateStars(value) {
        const stars = document.querySelectorAll('#stars button');
        stars.forEach(s => {
            const starValue = parseInt(s.dataset.value);
            if (starValue <= value) {
                s.classList.add('text-yellow-400');
                s.classList.remove('text-gray-200');
            } else {
                s.classList.add('text-gray-200');
                s.classList.remove('text-yellow-400');
            }
        });
    }

    // Close modal on outside click
    document.getElementById('ratingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
    </script>
</body>
</html>