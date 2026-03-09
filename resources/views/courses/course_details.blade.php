<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - EDVANTAGE</title>
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
<body class="bg-gray-50">
    @include('layouts.header')

    <main class="pt-16">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-teal-700 to-teal-600 text-white relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left: Course Info -->
                    <div class="lg:col-span-2">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">{{ $course->title }}</h1>
                        <p class="text-lg md:text-xl text-teal-50 mb-6 leading-relaxed">{{ $course->description }}</p>
                        
                        @php
                            $ratingCount = $course->ratings->count();
                            $avgRating = $ratingCount > 0 ? round($course->ratings->avg('rating'), 1) : 0;
                        @endphp

                        @if($ratingCount > 0)
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <svg class="w-5 h-5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-teal-200" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-lg font-semibold">{{ $avgRating }}</span>
                            <span class="text-teal-100">({{ $ratingCount }} ratings)</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar - Absolutely positioned to overlap -->
            <div class="hidden lg:block absolute top-12 right-0 w-96 mr-4 xl:mr-8 z-10 mt-10">
                <div class="sticky top-24">
                    <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
                        <!-- Course Image -->
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                        
                        <!-- Course Card Content -->
                        <div class="p-6">
                            <!-- Price -->
                            <div class="text-center mb-6 pb-6 border-b border-gray-200">
                                <div class="text-4xl font-bold text-teal-600 mb-2">৳{{ number_format($course->price) }}</div>
                                @if(isset($course->original_price) && $course->original_price > $course->price)
                                    <div class="text-lg text-gray-400 line-through">৳{{ number_format($course->original_price) }}</div>
                                @endif
                            </div>
                            
                            <!-- Course Stats -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-xl">📊</span>
                                    <span class="text-sm">All Levels</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-xl">👥</span>
                                    <span class="text-sm">{{ $course->enrolled_count ?? 0 }} Total Enrolled</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-xl">⏱️</span>
                                    <span class="text-sm">{{ $course->total_duration }} Hours Duration</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="text-xl">🎥</span>
                                    <span class="text-sm">{{ $course->approx_video_length }} min Avg Video Length</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
    <span class="text-xl">📅</span>
    <span class="text-sm">{{ $course->updated_at->format('M d, Y') }} Last Updated</span>
</div>

@if(isset($liveSessions) && $liveSessions->count() > 0)
<div class="flex items-center gap-3 text-gray-700">
    <span class="text-xl">📡</span>
    <span class="text-sm">
        @foreach($liveSessions as $session)
            {{ \Carbon\Carbon::parse($session->date)->format('M d, Y') }} |
            ⏰ {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
             | Live Class
        @endforeach
    </span>
</div>
@endif

         </div>
                            
                            <!-- What's Included -->
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <h4 class="font-bold text-gray-900 mb-4">What's Included</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $course->video_count }} video lectures
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Downloadable resources
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Full lifetime access
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Access on mobile and desktop
                                    </li>
                                    <li class="flex items-center gap-2 text-sm text-gray-700">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Certificate of completion
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="space-y-3">
                                @auth
                                    @if(auth()->user()->enrolledCourses->contains($course->id))
                                        <a href="{{ route('user.course.modules', $course->id) }}" 
                                           class="block w-full py-3 bg-teal-600 hover:bg-teal-700 text-white text-center font-semibold rounded-lg transition-colors shadow-md">
                                            Continue Learning
                                        </a>
                                    @else
                                        <form method="POST" action="{{ route('cart.add', $course->id) }}">
                                            @csrf
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" 
                                                    class="w-full py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md">
                                                Add to Cart
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.add', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full py-3 border-2 border-teal-600 text-teal-600 hover:bg-teal-50 font-semibold rounded-lg transition-colors">
                                                Save to Wishlist
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('cart.guest.add') }}">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md">
                                            Add to Cart
                                        </button>
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Instructor Details -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-chalkboard-teacher text-teal-600"></i>
                            </div>
                            Meet Your Instructor
                        </h3>
                        
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 bg-gradient-to-br from-teal-600 to-teal-700 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg">
                                    {{ strtoupper(substr($course->instructor->name ?? 'U', 0, 1)) }}
                                </div>
                            </div>
                            
                            <div class="flex-1">
                                <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $course->instructor->name ?? 'Unknown' }}</h4>
                                
                                @if(!empty($course->instructor->instructor))
                                    @if($course->instructor->instructor->area_of_expertise)
                                        <div class="mb-2 text-gray-700">
                                            <strong class="text-teal-700">Area of Expertise:</strong> {{ $course->instructor->instructor->area_of_expertise }}
                                        </div>
                                    @endif
                                    @if($course->instructor->instructor->qualification)
                                        <div class="mb-2 text-gray-700">
                                            <strong class="text-teal-700">Qualification:</strong> {{ $course->instructor->instructor->qualification }}
                                        </div>
                                    @endif
                                    @if($course->instructor->instructor->short_bio)
                                        <p class="text-gray-600 leading-relaxed mt-3">{{ $course->instructor->instructor->short_bio }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Prerequisites -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-list-check text-teal-600"></i>
                            </div>
                            Course Prerequisites
                        </h3>
                        
                        <div class="flex items-start gap-4 p-4 bg-teal-50 rounded-lg border-l-4 border-teal-600">
                            <i class="fa-solid fa-check text-teal-600 text-xl mt-1"></i>
                            <p class="text-gray-700 leading-relaxed">{{ $course->prerequisite }}</p>
                        </div>
                    </div>

                    <!-- Ratings & Reviews -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-star text-teal-600"></i>
                            </div>
                            Student Reviews
                        </h3>

                        @if($course->ratings->count() > 0)
                            <div class="space-y-6">
                                @foreach($course->ratings as $rating)
                                    <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($rating->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <h5 class="font-semibold text-gray-900">{{ $rating->user->name }}</h5>
                                                    <p class="text-sm text-gray-500">{{ $rating->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2 mb-3">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $rating->rating)
                                                    <svg class="w-5 h-5 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-300" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>

                                        @if($rating->review)
                                            <p class="text-gray-700 leading-relaxed">{{ $rating->review }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fa-solid fa-star text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No reviews yet. Be the first to review this course!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Empty spacer for desktop to maintain grid -->
                <div class="hidden lg:block lg:col-span-1"></div>
            </div>
        </div>

        
    </main>

    @if(session('cart_added'))
    <div id="cartModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="bg-white rounded-lg shadow-2xl max-w-sm w-full mx-4 p-6 text-center"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="transform scale-95 opacity-0"
             x-transition:enter-end="transform scale-100 opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="transform scale-100 opacity-100"
             x-transition:leave-end="transform scale-95 opacity-0">
            
            <!-- Success Icon -->
            <div class="mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <h3 class="text-lg font-bold text-gray-900 mb-1">Added to Cart!</h3>
            <p class="text-sm text-gray-600 mb-5">
                {{ session('cart_added') }}
            </p>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('cart.all') }}"
                   class="flex-1 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors text-sm font-semibold">
                    Go to Cart
                </a>

                <button @click="show = false; setTimeout(() => document.getElementById('cartModal')?.remove(), 200)"
                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm font-semibold">
                    Continue
                </button>
            </div>
        </div>
    </div>
    @endif


    <script>
function closeCartModal() {
    document.getElementById('cartModal')?.remove();
}
</script>

</body>
</html>