<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Wishlist - EDVANTAGE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <main class="pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm mb-6 text-gray-600">
                <a href="/homepage" class="hover:text-teal-600 transition-colors ml-7">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Wishlist</span>
            </nav>

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">My Wishlist</h1>
                <p class="text-lg text-gray-600">Save courses for later and never miss out on learning opportunities</p>
            </div>

            @if($wishlistItems->count())
                <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900">Saved Courses</h2>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                            {{ $wishlistItems->count() }} {{ Str::plural('course', $wishlistItems->count()) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($wishlistItems as $item)
                            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl border border-gray-200 hover:border-teal-500 transition-all group transform hover:-translate-y-2 duration-300 relative">
                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Remove this course from wishlist?')"
                                            class="w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition-all"
                                            title="Remove from wishlist">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Course Image -->
                                <div class="relative overflow-hidden h-40">
                                    @if($item->course->image)
                                        <img src="{{ asset('storage/' . $item->course->image) }}" 
                                             alt="{{ $item->course->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                </div>

                                <!-- Course Content -->
                                <div class="p-4 space-y-1">
                                    <!-- Category Badge -->
                                    @if(isset($item->course->category))
                                        <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            {{ $item->course->category }}
                                        </span>
                                    @else
                                        <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full">
                                            General
                                        </span>
                                    @endif

                                    <!-- Title -->
                                    <h3 class="font-bold text-lg text-gray-900 line-clamp-2 min-h-[3rem]">
                                        {{ $item->course->title }}
                                    </h3>

                                    <!-- Rating -->
                                    @if($item->course->ratings && $item->course->ratings->count())
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($item->course->ratings->avg('rating')))
                                                        <svg class="w-4 h-4 text-yellow-400 fill-yellow-400" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="font-semibold text-sm text-yellow-600">{{ number_format($item->course->ratings->avg('rating'), 1) }}</span>
                                            <span class="text-xs text-gray-500">({{ $item->course->ratings->count() }})</span>
                                        </div>
                                    @endif

                                    <!-- Price -->
                                    <div class="pt-2">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-2xl font-bold text-gray-900">৳</span>
                                            <span class="text-2xl font-bold text-gray-900">{{ number_format($item->course->price, 0) }}</span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2 pt-2">
                                        <a href="{{ route('courses.details', $item->course->id) }}" 
                                           class="flex-1 px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center text-sm font-semibold rounded-md transition-colors">
                                            Details
                                        </a>
                                        
                                        <form action="{{ route('cart.add', $item->course->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full px-2 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2 shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-12">
                    <div class="text-center max-w-md mx-auto">
                        <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Your wishlist is empty</h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Start building your learning journey by adding courses to your wishlist. You can save courses for later and get notified about price changes.
                        </p>
                        
                        <a href="/homepage" 
                           class="inline-block px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-md">
                            Browse Courses
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Success Modal for Cart Added -->
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
        // Auto close modal after 10 seconds
        @if(session('cart_added'))
        setTimeout(() => {
            const modal = document.getElementById('cartModal');
            if (modal) {
                modal.remove();
            }
        }, 10000);
        @endif
    </script>
</body>
</html>
