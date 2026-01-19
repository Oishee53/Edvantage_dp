<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Edvantage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="font-['Inter'] antialiased">

@extends('layouts.app')

@if(session('error'))
<div class="fixed top-24 right-6 z-50 max-w-md animate-slide-in" id="errorAlert">
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg p-4 flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
        <div class="flex-1">
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
        <button onclick="document.getElementById('errorAlert').remove()" class="text-red-400 hover:text-red-600 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

@section('content')

<!-- Navigation Header -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-xl border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 py-4">
        @include('layouts.header')
    </div>
</header>

<!-- Main Dashboard -->
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-teal-50/30 pt-24 pb-12">
    
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-6 mb-12">
        <div class="mb-8">
            <p class="text-teal-600 text-sm font-semibold mb-2 tracking-wide uppercase">Dashboard</p>
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-4">
                Welcome back, 
                <span class="bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">
                    {{ explode(' ', auth()->user()->name)[0] }}
                </span>
            </h1>
            <p class="text-gray-600 text-lg">Continue your learning journey</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Enrolled Courses -->
            <div class="group relative bg-white rounded-2xl p-6 border border-gray-200 hover:border-emerald-400 transition-all duration-300 hover:shadow-xl hover:shadow-emerald-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-book-open text-emerald-600 text-xl"></i>
                </div>
                <div class="text-right">
                <div class="text-4xl font-bold text-gray-900">{{ count($courseProgress) }}</div>
                </div>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Enrolled Courses</p>
            <p class="text-gray-500 text-sm">Currently learning</p>
            </div>

            <!-- Completed -->
            <div class="group relative bg-white rounded-2xl p-6 border border-gray-200 hover:border-emerald-400 transition-all duration-300 hover:shadow-xl hover:shadow-emerald-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-trophy text-emerald-600 text-xl"></i>
                </div>
                <div class="text-right">
                <div class="text-4xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->count() }}</div>
                </div>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Completed</p>
            <p class="text-gray-500 text-sm">Successfully finished</p>
            </div>

            <!-- Certificates -->
            <div class="group relative bg-white rounded-2xl p-6 border border-gray-200 hover:border-emerald-400 transition-all duration-300 hover:shadow-xl hover:shadow-emerald-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-certificate text-emerald-600 text-xl"></i>
                </div>
                <div class="text-right">
                <div class="text-4xl font-bold text-gray-900">{{ collect($courseProgress)->where('completion_percentage', 100)->where('average_percentage', '>=', 70)->count() }}</div>
                </div>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Certificates</p>
            <p class="text-gray-500 text-sm">Achievements earned</p>
            </div>

            <!-- Average Progress -->
            <div class="group relative bg-white rounded-2xl p-6 border border-gray-200 hover:border-emerald-400 transition-all duration-300 hover:shadow-xl hover:shadow-emerald-500/10">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                <i class="fas fa-chart-line text-emerald-600 text-xl"></i>
                </div>
                <div class="text-right">
                @php $totalProgress = collect($courseProgress)->avg('completion_percentage'); @endphp
                <div class="text-4xl font-bold text-gray-900">{{ round($totalProgress) }}%</div>
                </div>
            </div>
            <p class="text-gray-900 font-semibold mb-1">Average Progress</p>
            <p class="text-gray-500 text-sm">Overall performance</p>
            </div>
        </div>

        <!-- Courses Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">
                Your Courses
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($courseProgress as $progress)
            @php
                $cardColors = [
                    ['border' => 'border-teal-200', 'text' => 'text-teal-600', 'bg' => 'bg-teal-50', 'progress' => 'bg-teal-500', 'iconBg' => 'bg-teal-100'],
                    ['border' => 'border-blue-200', 'text' => 'text-blue-600', 'bg' => 'bg-blue-50', 'progress' => 'bg-blue-500', 'iconBg' => 'bg-blue-100'],
                    ['border' => 'border-rose-200', 'text' => 'text-rose-600', 'bg' => 'bg-rose-50', 'progress' => 'bg-rose-500', 'iconBg' => 'bg-rose-100'],
                    ['border' => 'border-amber-200', 'text' => 'text-amber-600', 'bg' => 'bg-amber-50', 'progress' => 'bg-amber-500', 'iconBg' => 'bg-amber-100']
                ];
                $colorIndex = $loop->index % 4;
                $colors = $cardColors[$colorIndex];
            @endphp

            <div class="group relative bg-white rounded-3xl border-2 {{ $colors['border'] }} hover:shadow-2xl transition-all duration-500 overflow-hidden">
                
                <div class="relative p-8">
                    <!-- Course Title -->
                    <div class="mb-6">
                        <div class="mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors['bg'] }} {{ $colors['text'] }} border {{ $colors['border'] }}">
                                {{ $progress['category'] ?? 'Course' }}
                            </span>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">{{ $progress['course_name'] }}</h3>
                    </div>

                    <!-- Progress Section -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-gray-700 font-semibold">Progress</span>
                            <span class="text-2xl font-bold {{ $colors['text'] }}">{{ $progress['completion_percentage'] }}%</span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden border {{ $colors['border'] }}">
                            <div class="h-full {{ $colors['progress'] }} rounded-full transition-all duration-1000 ease-out" 
                                 style="width: {{ $progress['completion_percentage'] }}%"></div>
                        </div>
                    </div>

                    <!-- Course Stats -->
                    <div class="flex items-center gap-6 text-sm text-gray-600 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg {{ $colors['iconBg'] }} flex items-center justify-center">
                                <i class="fas fa-play-circle {{ $colors['text'] }} text-sm"></i>
                            </div>
                            <span class="font-medium">{{ $progress['completed_videos'] }}/{{ $progress['total_videos'] }} Videos</span>
                        </div>
                        @if(count($progress['quiz_marks']) > 0)
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg {{ $colors['iconBg'] }} flex items-center justify-center">
                                <i class="fas fa-clipboard-check {{ $colors['text'] }} text-sm"></i>
                            </div>
                            <span class="font-medium">{{ count($progress['quiz_marks']) }} Quizzes</span>
                        </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button onclick="toggleDetails('{{ $progress['course_id'] }}')" 
                                class="flex-1 px-5 py-3 bg-gray-100 hover:bg-gray-200 border border-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-eye"></i>
                            <span>Details</span>
                        </button>

                        @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                        <button onclick="openRatingModal({{ $progress['course_id'] }}, '{{ route('certificate.generate', ['userId' => auth()->id(), 'courseId' => $progress['course_id']]) }}')"
                                class="flex-1 px-5 py-3 {{ $colors['progress'] }} text-white rounded-xl font-semibold transition-all duration-300 flex items-center justify-center gap-2 hover:opacity-90 shadow-lg">
                            <i class="fas fa-certificate"></i>
                            <span>Certificate</span>
                        </button>
                        @endif
                    </div>

                    <!-- Details Section (Hidden by default) -->
                    <div id="details-{{ $progress['course_id'] }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-bar {{ $colors['text'] }}"></i>
                            Quiz Performance
                        </h4>

                        @if(count($progress['quiz_marks']) > 0)
                        <div class="space-y-3">
                            @foreach($progress['quiz_marks'] as $quiz)
                            <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-200">
                                <span class="text-gray-700 font-medium">{{ $quiz['quiz_title'] }}</span>
                                <span class="px-4 py-2 {{ $colors['bg'] }} {{ $colors['text'] }} rounded-lg font-bold text-sm border {{ $colors['border'] }}">
                                    {{ $quiz['score'] }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-info-circle text-4xl mb-3 opacity-50"></i>
                            <p>No quiz results available yet</p>
                        </div>
                        @endif
                    </div>

                    @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                    <div class="absolute top-8 right-8">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center">
                            <i class="fas fa-check text-emerald-600 text-lg"></i>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @empty
            <!-- Empty State -->
            <div class="col-span-2 relative bg-white rounded-3xl border-2 border-gray-200 p-16 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-teal-100 border-2 border-teal-200 flex items-center justify-center">
                        <i class="fas fa-book-open text-5xl text-teal-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Courses Enrolled</h3>
                    <p class="text-gray-600 mb-6">Start your learning journey by enrolling in your first course</p>
                    <a href="/courses" class="inline-flex items-center gap-2 px-8 py-4 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-teal-500/30">
                        <i class="fas fa-search"></i>
                        <span>Browse Courses</span>
                    </a>
                </div>
            </div>
            @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Rating Modal -->
<div id="ratingModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-6">
    <div class="bg-white rounded-3xl border-2 border-gray-200 max-w-md w-full p-8 shadow-2xl transform transition-all">
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
                      class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition-all mb-6 resize-none"
                      rows="4"></textarea>

            <!-- Actions -->
            <div class="flex gap-3">
                <button type="button" onclick="skipRating()" 
                        class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 border-2 border-gray-300 rounded-xl font-semibold transition-all duration-300">
                    Skip
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg shadow-teal-500/30">
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

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #14b8a6;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #0d9488;
}
</style>

@endsection

</body>
</html>