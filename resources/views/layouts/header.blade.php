<!-- Navigation Header Component -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            @guest
            <a href="/" class="flex-shrink-0">
            @else
            <a href="/homepage" class="flex-shrink-0">
            @endguest
                <img src="/image/Edvantage.png" alt="EDVANTAGE Logo" class="h-10">
            </a>

            <!-- Search Bar - Desktop -->
            @auth
            <form action="{{ route('courses.search') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="What do you want to learn?" 
                        class="w-full px-4 py-2.5 pl-11 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                        autocomplete="off"
                    />
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
            @else
            <form action="{{ route('guest.courses.search') }}" method="GET" class="hidden md:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="What do you want to learn?" 
                        class="w-full px-4 py-2.5 pl-11 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                        autocomplete="off"
                    />
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
            @endauth

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Navigation Links -->
                @guest
                <a href="#about" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">About Us</a>
                <a href="#contact" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">Contact Us</a>
                @endguest
                
                <!-- Instructor Mode Link -->
                @if(auth()->check() && auth()->user()->role == 3)
                    <a href="/instructor_homepage" class="text-gray-700 hover:text-teal-600 transition-colors font-medium">Instructor</a>
                @endif
                
                @guest
                    <!-- Guest Buttons -->
                    <a href="/login" class="px-4 py-2 border-2 border-teal-600 text-teal-600 rounded-md hover:bg-teal-50 transition-colors font-medium">
                        Login
                    </a>
                    <a href="/register" class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition-colors font-medium shadow-md">
                        Sign Up
                    </a>
                @else
                    <!-- Logged In User Actions -->
                    
                    <a href="/wishlist" class="w-11 h-11 flex items-center justify-center rounded-full border border-gray-300 hover:border-teal-500 hover:bg-teal-50 transition-all" title="Wishlist">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    
                    <a href="/cart" class="w-11 h-11 flex items-center justify-center rounded-full border border-gray-300 hover:border-teal-500 hover:bg-teal-50 transition-all" title="Shopping Cart">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </a>
                    
                    <!-- Notification Button -->
                    <div class="relative" x-data="{ open: false }">
                        <button @mouseenter="open = true" @mouseleave="open = false" class="w-11 h-11 flex items-center justify-center rounded-full border border-gray-300 hover:border-teal-500 hover:bg-teal-50 transition-all relative" title="Notifications">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            
                            @php
                                // Filter notifications to only count question-related ones
                                $relevantNotifications = auth()->user()->unreadNotifications->filter(function ($notification) {
                                    return $notification->type === \App\Notifications\QuestionRejectedNotification::class || 
                                           $notification->type === \App\Notifications\QuestionAnsweredNotification::class;
                                });
                                $relevantCount = $relevantNotifications->count();
                            @endphp
                            
                            @if($relevantCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-white animate-pulse">
                                    {{ $relevantCount }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div x-show="open" 
                             @mouseenter="open = true" 
                             @mouseleave="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
                             style="display: none;">
                            
                            <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                                <h4 class="font-semibold text-gray-900">Notifications</h4>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @if($relevantCount > 0)
                                    @foreach($relevantNotifications as $notification)
                                        @if($notification->type === \App\Notifications\QuestionRejectedNotification::class)
                                            <div class="px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors border-l-4 border-l-red-600">
                                                <div class="font-semibold text-gray-900 text-sm mb-1">Question Rejected</div>
                                                <div class="text-gray-600 text-sm mb-2 leading-relaxed">{{ $notification->data['content'] }}</div>
                                                <div class="text-gray-500 text-xs italic mb-2">Instructor: {{ $notification->data['instructor_name'] }}</div>
                                                <a href="{{ url('/student/questions/' . $notification->data['question_id']) }}" class="inline-block px-3 py-1 bg-teal-600 text-white text-xs font-medium rounded hover:bg-teal-700 transition-colors">
                                                    View Question
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @if($notification->type === \App\Notifications\QuestionAnsweredNotification::class)
                                            <div class="px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition-colors border-l-4 border-l-green-600">
                                                <div class="font-semibold text-gray-900 text-sm mb-1">Question Answered</div>
                                                <div class="text-gray-600 text-sm mb-2 leading-relaxed">{{ $notification->data['content'] }}</div>
                                                <div class="text-gray-500 text-xs italic mb-2">Instructor: {{ $notification->data['instructor_name'] }}</div>
                                                <a href="{{ url('/student/questions/' . $notification->data['question_id']) }}" class="inline-block px-3 py-1 bg-teal-600 text-white text-xs font-medium rounded hover:bg-teal-700 transition-colors">
                                                    View Answer
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="py-10 text-center text-gray-400">
                                        <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13.5v-8A2.5 2.5 0 0017.5 3h-11A2.5 2.5 0 004 5.5v8A2.5 2.5 0 006.5 16h11a2.5 2.5 0 002.5-2.5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l6 5 6-5"></path>
                                        </svg>
                                        <div class="text-sm">No new notifications</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-11 h-11 flex items-center justify-center rounded-full bg-teal-600 text-white hover:bg-teal-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <span class="font-semibold text-gray-900">{{ explode(' ', auth()->user()->name)[0] }}</span>
                            <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-2"
                             style="display: none;">
                            
                            <a href="/profile" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                My Profile
                            </a>
                            
                            <a href="{{ route('courses.enrolled') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                My Courses
                            </a>
                            
                            <a href="{{ route('user.progress') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                My Progress
                            </a>
                            
                            <a href="/homepage" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Course Catalog
                            </a>
                            
                            <a href="{{ route('purchase.history') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Purchase History
                            </a>
                            
                            @if(auth()->user()->role != 3)
                                <a href="{{ route('ins.signup') }}" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-teal-50 hover:text-teal-700 transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Register as Instructor
                                </a>
                            @endif
                            
                            <hr class="my-2 border-gray-200">
                            
                            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="flex items-center px-4 py-2.5 text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </a>
                            
                            <form id="logout-form" action="/logout" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-md hover:bg-gray-100">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Search -->
        <div class="md:hidden pb-3">
            @auth
            <form action="{{ route('courses.search') }}" method="GET">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="What do you want to learn?" 
                        class="w-full px-4 py-2.5 pl-11 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        autocomplete="off"
                    />
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
            @else
            <form action="{{ route('guest.courses.search') }}" method="GET">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="What do you want to learn?" 
                        class="w-full px-4 py-2.5 pl-11 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                        autocomplete="off"
                    />
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
            @endauth
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden border-t border-gray-200 py-4 space-y-3">
            @guest    
            <a href="#about" class="block py-2 text-gray-700 hover:text-teal-600 font-medium">About Us</a>
            <a href="#contact" class="block py-2 text-gray-700 hover:text-teal-600 font-medium">Contact Us</a>
            @endguest
            <!-- Instructor Mode Link - Mobile -->
            @if(auth()->check() && auth()->user()->role == 3)
                <a href="/instructor_homepage" class="block py-2 text-gray-700 hover:text-teal-600 font-medium">Instructor</a>
            @endif
            
            @guest
                <a href="/login" class="block py-2 px-4 border-2 border-teal-600 text-teal-600 rounded-md text-center font-medium">Login</a>
                <a href="/register" class="block py-2 px-4 bg-teal-600 text-white rounded-md text-center font-medium">Sign Up</a>
            @else
                <div class="space-y-2 border-t border-gray-200 pt-3">
                    <div class="flex items-center gap-3 px-2 mb-3">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-teal-600 text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                    </div>
                    
                    <!-- Notifications - Mobile -->
                    <a href="/notifications" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        Notifications
                        @php
                            $relevantNotifications = auth()->user()->unreadNotifications->filter(function ($notification) {
                                return $notification->type === \App\Notifications\QuestionRejectedNotification::class || 
                                       $notification->type === \App\Notifications\QuestionAnsweredNotification::class;
                            });
                            $relevantCount = $relevantNotifications->count();
                        @endphp
                        @if($relevantCount > 0)
                            <span class="ml-auto bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $relevantCount }}
                            </span>
                        @endif
                    </a>
                    
                    <a href="/wishlist" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Wishlist
                    </a>
                    
                    <a href="/cart" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Shopping Cart
                    </a>
                    
                    <a href="/profile" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Profile
                    </a>
                    
                    <a href="{{ route('courses.enrolled') }}" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        My Courses
                    </a>
                    
                    <a href="{{ route('user.progress') }}" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        My Progress
                    </a>
                    
                    <a href="/homepage" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Course Catalog
                    </a>
                    
                    <a href="{{ route('purchase.history') }}" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Purchase History
                    </a>
                    
                    @if(auth()->user()->role != 3)
                        <a href="{{ route('ins.signup') }}" class="flex items-center py-2 px-2 text-gray-700 hover:bg-teal-50 rounded-md">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Register as Instructor
                        </a>
                    @endif
                    
                    <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" 
                       class="flex items-center py-2 px-2 text-red-600 hover:bg-red-50 rounded-md">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </a>
                    
                    <form id="logout-form-mobile" action="/logout" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>
