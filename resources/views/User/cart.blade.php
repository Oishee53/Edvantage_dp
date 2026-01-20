<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - EDVANTAGE</title>
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
            <nav class="flex items-center gap-2 text-sm mb-6 text-gray-600 ml-6 ">
                <a href="{{ auth()->check() ? '/homepage' : '/' }}" class="hover:text-teal-600 transition-colors">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Shopping Cart</span>
            </nav>

            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Shopping Cart</h1>
                <p class="text-lg text-gray-600">Review your selected courses before checkout</p>
            </div>

            @if($cartItems->count())
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-4 ml-6 md:p-8">
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                                <h2 class="text-2xl font-bold text-gray-900">Cart Items</h2>
                                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                    {{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }}
                                </span>
                            </div>

                            <div class="space-y-6">
                                @if(isset($isGuest) && $isGuest)
                                    @foreach ($cartItems as $course)
                                        <div class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition-all border border-transparent hover:border-teal-200">
                                            <img src="{{ asset('storage/' . $course->image) }}" 
                                                 alt="{{ $course->title }}" 
                                                 class="w-32 h-24 object-cover rounded-lg flex-shrink-0">
                                            
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                                    {{ $course->title }}
                                                </h3>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                    {{ $course->description }}
                                                </p>
                                                
                                                <div class="flex items-center justify-between">
                                                    <div class="text-2xl font-bold text-teal-600">
                                                        ৳{{ number_format($course->price, 0) }}
                                                    </div>
                                                    
                                                    <form action="{{ route('guest.cart.remove') }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                        <button type="submit" 
                                                                onclick="return confirm('Remove this course from cart?')"
                                                                class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-2 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($cartItems as $item)
                                        <div class="flex gap-4 p-4 rounded-lg hover:bg-gray-50 transition-all border border-transparent hover:border-teal-200">
                                            <img src="{{ asset('storage/' . $item->course->image) }}" 
                                                 alt="{{ $item->course->title }}" 
                                                 class="w-32 h-24 object-cover rounded-lg flex-shrink-0">
                                            
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                                                    {{ $item->course->title }}
                                                </h3>
                                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                    {{ $item->course->description }}
                                                </p>
                                                
                                                <div class="flex items-center justify-between">
                                                    <div class="text-2xl font-bold text-teal-600">
                                                        ৳{{ number_format($item->course->price, 0) }}
                                                    </div>
                                                    
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                onclick="return confirm('Remove this course from cart?')"
                                                                class="text-red-600 hover:text-red-700 text-sm font-medium flex items-center gap-2 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                            Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sticky top-24 mr-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <span class="text-gray-600">Subtotal ({{ $cartItems->count() }} items)</span>
                                    <span class="font-semibold text-gray-900">
                                        @if(isset($isGuest) && $isGuest)
                                            ৳{{ number_format($cartItems->sum('price'), 0) }}
                                        @else
                                            ৳{{ number_format($cartItems->sum(fn($item) => $item->course->price), 0) }}
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                                    <span class="text-gray-600">Taxes</span>
                                    <span class="font-semibold text-gray-900">৳0</span>
                                </div>
                                
                                <div class="flex justify-between items-center pt-2">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-teal-600">
                                        @if(isset($isGuest) && $isGuest)
                                            ৳{{ number_format($cartItems->sum('price'), 0) }}
                                        @else
                                            ৳{{ number_format($cartItems->sum(fn($item) => $item->course->price), 0) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            @if(isset($isGuest) && $isGuest)
                                <a href="{{ route('login') }}" 
                                   class="block w-full py-3 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition-colors mb-3 shadow-md">
                                    Proceed to Checkout
                                </a>
                                <a href="/" 
                                   class="block text-center text-teal-600 hover:text-teal-700 text-sm font-medium transition-colors">
                                    Continue Shopping
                                </a>
                            @else
                                <form method="GET" action="{{ route('checkout') }}">
                                    <input type="hidden" name="amount" value="{{ $cartItems->sum(fn($item) => $item->course->price) }}">
                                    <button type="submit" 
                                            class="block w-full py-3 bg-teal-600 text-white text-center font-semibold rounded-lg hover:bg-teal-700 transition-colors mb-3 shadow-md">
                                        Proceed to Checkout
                                    </button>
                                </form>
                                <a href="{{ route('courses.enrolled') }}" 
                                   class="block text-center text-teal-600 hover:text-teal-700 text-sm font-medium transition-colors">
                                    Continue Shopping
                                </a>
                            @endif

                            <!-- Security Badge -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span>Secure checkout guaranteed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-12">
                    <div class="text-center max-w-md mx-auto">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Your cart is empty</h3>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            Looks like you haven't added any courses to your cart yet. Start exploring our course catalog and add courses you'd like to learn.
                        </p>
                        
                        <a href="{{ auth()->check() ? '/homepage' : '/' }}" 
                           class="inline-block px-8 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-md">
                            Browse Courses
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Smooth remove confirmation
        document.querySelectorAll('form[action*="remove"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to remove this course from your cart?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
