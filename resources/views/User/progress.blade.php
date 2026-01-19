<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EDVANTAGE</title>
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
<body class="bg-gray-50 p-10 ">
    @include('layouts.header')

    <!-- Success/Error Messages -->
    @if(session('error'))
    <div class="fixed top-24 right-6 z-50 max-w-md animate-slide-in" id="errorAlert" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
            <div class="flex-1">
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="text-red-400 hover:text-red-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <main class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Hero Section -->
            <div class="mb-12 mx-auto">
                <p class="text-teal-600 text-sm font-semibold mb-2 tracking-wide uppercase">Dashboard</p>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    Welcome back, 
                    <span class="bg-gradient-to-r from-teal-600 to-teal-700 bg-clip-text text-transparent">
                        {{ explode(' ', auth()->user()->name)[0] }}
                    </span>
                </h1>
                <p class="text-lg text-gray-600">Continue your learning journey</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Enrolled Courses -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 hover:shadow-lg hover:border-teal-500 transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg bg-teal-100 flex items-center justify-center">
                            <i class="fas fa-book-open text-teal-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900">{{ count($courseProgress) }}</div>
                        </div>
                    </div>
                    <p class="text-gray-900 font-semibold mb-1">Enrolled Courses</p>
                    <p class="text-gray-500 text-sm">Currently learning</p>
                </div>

                <!-- Completed -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 hover:shadow-lg hover:border-teal-500 transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                            <i class="fas fa-trophy text-green-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->count() }}</div>
                        </div>
                    </div>
                    <p class="text-gray-900 font-semibold mb-1">Completed</p>
                    <p class="text-gray-500 text-sm">Successfully finished</p>
                </div>

                <!-- Certificates -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 hover:shadow-lg hover:border-teal-500 transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg bg-amber-100 flex items-center justify-center">
                            <i class="fas fa-certificate text-amber-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->where('average_percentage', '>=', 70)->count() }}</div>
                        </div>
                    </div>
                    <p class="text-gray-900 font-semibold mb-1">Certificates</p>
                    <p class="text-gray-500 text-sm">Achievements earned</p>
                </div>

                <!-- Average Progress -->
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 hover:shadow-lg hover:border-teal-500 transition-all">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-right">
                            @php $totalProgress = collect($courseProgress)->avg('completion_percentage'); @endphp
                            <div class="text-3xl font-bold text-gray-900">{{ round($totalProgress) }}%</div>
                        </div>
                    </div>
                    <p class="text-gray-900 font-semibold mb-1">Average Progress</p>
                    <p class="text-gray-500 text-sm">Overall performance</p>
                </div>
            </div>

            <!-- Courses Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Your Courses</h2>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @forelse($courseProgress as $progress)
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8 hover:shadow-lg hover:border-teal-500 transition-all relative">
                        
                        <!-- Completion Badge -->
                        @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                        <div class="absolute top-6 right-6">
                            <div class="w-10 h-10 rounded-full bg-green-100 border-2 border-green-500 flex items-center justify-center">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                        </div>
                        @endif

                        <!-- Course Header -->
                        <div class="mb-6">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700 border border-teal-200">
                                {{ $progress['category'] ?? 'Course' }}
                            </span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3 mb-2">{{ $progress['course_name'] }}</h3>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600 font-medium">Progress</span>
                                <span class="text-lg font-bold text-teal-600">{{ $progress['completion_percentage'] }}%</span>
                            </div>
                            <div class="h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-teal-600 rounded-full transition-all duration-1000" 
                                     style="width: {{ $progress['completion_percentage'] }}%"></div>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center gap-6 text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-play-circle text-teal-600"></i>
                                <span class="font-medium">{{ $progress['completed_videos'] }}/{{ $progress['total_videos'] }} Videos</span>
                            </div>
                            @if(count($progress['quiz_marks']) > 0)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clipboard-check text-teal-600"></i>
                                <span class="font-medium">{{ count($progress['quiz_marks']) }} Quizzes</span>
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <button onclick="toggleDetails('{{ $progress['course_id'] }}')" 
                                    class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-eye text-sm"></i>
                                <span>Details</span>
                            </button>

                            @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                            <button onclick="openRatingModal({{ $progress['course_id'] }}, '{{ route('certificate.generate', ['userId' => auth()->id(), 'courseId' => $progress['course_id']]) }}')"
                                    class="flex-1 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition-all flex items-center justify-center gap-2 shadow-md">
                                <i class="fas fa-certificate text-sm"></i>
                                <span>Certificate</span>
                            </button>
                            @endif
                        </div>

                        <!-- Details Section (Hidden by default) -->
                        <div id="details-{{ $progress['course_id'] }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-chart-bar text-teal-600"></i>
                                Quiz Performance
                            </h4>

                            @if(count($progress['quiz_marks']) > 0)
                            <div class="space-y-3">
                                @foreach($progress['quiz_marks'] as $quiz)
                                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between border border-gray-200">
                                    <span class="text-gray-700 font-medium">{{ $quiz['quiz_title'] }}</span>
                                    <span class="px-4 py-2 bg-teal-100 text-teal-700 rounded-lg font-bold text-sm border border-teal-200">
                                        {{ $quiz['score'] }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8 text-gray-400">
                                <i class="fas fa-info-circle text-3xl mb-2"></i>
                                <p class="text-sm">No quiz results available yet</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    @empty
                    <!-- Empty State -->
                    <div class="col-span-2 bg-white rounded-xl shadow-md border border-gray-200 p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-teal-100 flex items-center justify-center">
                                <i class="fas fa-book-open text-4xl text-teal-600"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">No Courses Enrolled</h3>
                            <p class="text-gray-600 mb-6">Start your learning journey by enrolling in your first course</p>
                            <a href="/homepage" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition-all shadow-md">
                                <i class="fas fa-search"></i>
                                <span>Browse Courses</span>
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <!-- Rating Modal -->
    <div id="ratingModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-6">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Rate This Course</h3>

            <form method="POST" action="{{ route('course.rate') }}">
                @csrf
                <input type="hidden" name="course_id" id="rating_course_id">
                <input type="hidden" name="rating" id="rating_value">
                <input type="hidden" name="certificate_url" id="certificate_url">

                <!-- Star Rating -->
                <div id="stars" class="flex justify-center gap-2 mb-6 text-5xl cursor-pointer">
                    @for($i = 1; $i <= 5; $i++)
                    <span data-value="{{ $i }}" class="text-gray-300 hover:text-amber-400 transition-colors duration-200">☆</span>
                    @endfor
                </div>

                <!-- Review Textarea -->
                <textarea name="review" 
                          placeholder="Write a review (optional)" 
                          class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition-all mb-6 resize-none"
                          rows="4"></textarea>

                <!-- Actions -->
                <div class="flex gap-3">
                    <button type="button" onclick="skipRating()" 
                            class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition-all">
                        Skip
                    </button>
                    <button type="submit" 
                            class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-lg font-semibold transition-all shadow-md">
                        Submit & Download
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    let selectedRating = 0;

    function openRatingModal(courseId, certificateUrl) {
        document.getElementById('ratingModal').classList.remove('hidden');
        document.getElementById('rating_course_id').value = courseId;
        document.getElementById('certificate_url').value = certificateUrl;
        selectedRating = 0;
        
        // Reset stars
        document.querySelectorAll('#stars span').forEach(star => {
            star.innerText = '☆';
            star.classList.remove('text-amber-400');
            star.classList.add('text-gray-300');
        });
    }

    function skipRating() {
        const url = document.getElementById('certificate_url').value;
        document.getElementById('ratingModal').classList.add('hidden');
        window.location.href = url;
    }

    function toggleDetails(courseId) {
        const details = document.getElementById('details-' + courseId);
        if (details) {
            details.classList.toggle('hidden');
        }
    }

    // Star rating functionality
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#stars span');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                selectedRating = this.dataset.value;
                document.getElementById('rating_value').value = selectedRating;
                
                stars.forEach(s => {
                    const value = parseInt(s.dataset.value);
                    if (value <= selectedRating) {
                        s.innerText = '★';
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-amber-400');
                    } else {
                        s.innerText = '☆';
                        s.classList.remove('text-amber-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });
            
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                stars.forEach(s => {
                    if (parseInt(s.dataset.value) <= value) {
                        s.innerText = '★';
                        s.classList.add('text-amber-400');
                    } else {
                        s.innerText = '☆';
                        s.classList.remove('text-amber-400');
                    }
                });
            });
        });
        
        document.getElementById('stars').addEventListener('mouseleave', function() {
            stars.forEach(s => {
                const value = parseInt(s.dataset.value);
                if (value <= selectedRating) {
                    s.innerText = '★';
                    s.classList.add('text-amber-400');
                } else {
                    s.innerText = '☆';
                    s.classList.remove('text-amber-400');
                }
            });
        });
    });

    // Close modal on outside click
    document.getElementById('ratingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });
    </script>

    <style>
    @keyframes slide-in {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
    </style>
</body>
</html>
