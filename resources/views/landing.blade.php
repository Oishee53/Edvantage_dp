<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDVANTAGE - Your Virtual Classroom Redefined</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .hero-slide {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Include Header Component -->
    @include('layouts.header')

    <!-- Category Bar -->
    <div class="fixed top-16 left-0 right-0 z-40 bg-teal-700 shadow-lg" x-data="{ 
        scrollContainer: null,
        showLeft: false,
        showRight: true,
        init() {
            this.$nextTick(() => {
                this.scrollContainer = this.$refs.categories;
                this.checkScroll();
            });
        },
        checkScroll() {
            if (this.scrollContainer) {
                this.showLeft = this.scrollContainer.scrollLeft > 0;
                this.showRight = this.scrollContainer.scrollLeft < this.scrollContainer.scrollWidth - this.scrollContainer.clientWidth - 10;
            }
        },
        scroll(direction) {
            const amount = direction === 'left' ? -300 : 300;
            this.scrollContainer.scrollBy({ left: amount, behavior: 'smooth' });
        }
    }">
        <div class="max-w-6xl mx-auto relative">
            <!-- Left Arrow -->
            <button x-show="showLeft" @click="scroll('left')" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-teal-800 hover:bg-teal-900 text-white p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <!-- Categories -->
            <div x-ref="categories" @scroll="checkScroll" class="flex items-center gap-6 px-12 py-3 overflow-x-auto scrollbar-hide">
                @foreach($uniqueCategories as $category)
                    <a href="{{ route('guest.courses.search', ['search' => $category]) }}" 
                       class="text-white hover:text-yellow-300 whitespace-nowrap transition-colors text-sm font-medium">
                        {{ $category }}
                    </a>
                @endforeach
            </div>

            <!-- Right Arrow -->
            <button x-show="showRight" @click="scroll('right')" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-teal-800 hover:bg-teal-900 text-white p-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Hero Section with Carousel - Reduced Height -->
    <section class="pt-28 pb-8 bg-gray-50 mt-5" x-data="{
        currentSlide: 0,
        slides: [
            {
                title: 'Jump into learning — for less',
                description: 'New to Edvantage? Explore our courses starting at just ৳999. Get access to expert-led content and lifetime learning.',
                buttonText: 'Sign up now',
                buttonLink: '/register'
            },
            {
                title: 'Learn from industry experts',
                description: 'Master new skills with courses taught by professionals. Get hands-on experience and real-world knowledge.',
                buttonText: 'Browse courses',
                buttonLink: '#courses'
            },
            {
                title: 'Advance your career',
                description: 'Gain in-demand skills and earn recognized certificates. Join thousands of learners transforming their careers.',
                buttonText: 'Get started',
                buttonLink: '/register'
            }
        ],
        autoplay: null,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplay = setInterval(() => {
                this.nextSlide();
            }, 6000);
        },
        stopAutoplay() {
            clearInterval(this.autoplay);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goToSlide(index) {
            this.currentSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-white rounded-lg shadow-sm border border-gray-200">
                <!-- Slides Container -->
                <div class="relative h-[400px] md:h-[350px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div 
                            x-show="currentSlide === index"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="absolute inset-0 hero-slide"
                        >
                            <div class="grid md:grid-cols-2 gap-8 items-center h-full p-8 md:p-12">
                                <!-- Left: Text Content -->
                                <div class="space-y-4">
                                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight" x-text="slide.title"></h1>
                                    
                                    <p class="text-base md:text-lg text-gray-600 leading-relaxed" x-text="slide.description"></p>
                                    
                                    <div class="pt-2">
                                        <a :href="slide.buttonLink" class="inline-block px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-md transition-colors shadow-sm">
                                            <span x-text="slide.buttonText"></span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Right: Illustration/Image Area -->
                                <div class="hidden md:flex items-center justify-center">
                                    <div class="relative w-full h-64">
                                        <!-- Decorative elements -->
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-teal-100 rounded-full opacity-50"></div>
                                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-cyan-100 rounded-full opacity-70"></div>
                                        
                                        <!-- Icons -->
                                        <div class="absolute top-12 left-12 bg-white p-3 rounded-lg shadow-md">
                                            <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        
                                        <div class="absolute top-8 right-16 bg-white p-3 rounded-lg shadow-md">
                                            <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                        </div>
                                        
                                        <div class="absolute bottom-12 left-20 bg-white p-3 rounded-lg shadow-md">
                                            <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                        </div>
                                        
                                        <div class="absolute bottom-16 right-12 bg-white p-3 rounded-lg shadow-md">
                                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Navigation Arrows -->
                <button @click="prevSlide(); stopAutoplay(); startAutoplay();" 
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 p-2 rounded-full shadow-md transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button @click="nextSlide(); stopAutoplay(); startAutoplay();" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 p-2 rounded-full shadow-md transition-all z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button 
                            @click="goToSlide(index)"
                            :class="currentSlide === index ? 'bg-teal-600 w-8' : 'bg-gray-300 w-2'"
                            class="h-2 rounded-full transition-all duration-300"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section id="courses" class="py-16 bg-gray-50"> 
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="text-center mb-12 pt-5">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Courses</h2>
                    <p class="text-xl text-gray-600">Discover our most popular courses designed to help you achieve your learning goals</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-8 px-8" x-data="{ visibleCourses: 8 }">
                    @foreach($courses as $index => $course)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl border border-gray-200 hover:border-teal-500 transition-all cursor-pointer group transform hover:-translate-y-2 duration-300"
                         x-show="{{ $index }} < visibleCourses"
                         x-transition>
                        <!-- Image -->
                        <div class="relative overflow-hidden h-48">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://via.placeholder.com/300x140?text=Course+Image" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-3">
                            <!-- Category Badge -->
                            @if(isset($course->category))
                                <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $course->category }}
                                </span>
                            @endif

                            <!-- Title -->
                            <h3 class="font-bold text-lg text-gray-900 line-clamp-2 min-h-[3.5rem]">
                                {{ $course->title }}
                            </h3>

                            <!-- Rating -->
                            @if($course->ratings->count())
                            <div class="flex items-center gap-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($course->averageRating()))
                                            <svg class="w-4 h-4 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="font-semibold text-sm text-yellow-600">{{ $course->averageRating() }}</span>
                                <span class="text-xs text-gray-500">({{ $course->ratings->count() }})</span>
                            </div>
                            @endif

                            <!-- Price -->
                            <div class="pt-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-gray-900">৳</span>
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($course->price ?? 0, 0) }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-2">
                                <a href="{{ route('courses.details', $course->id) }}" 
                                   class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center text-sm font-semibold rounded-md transition-colors">
                                    Details
                                </a>
                                @guest
                                <form method="POST" action="{{ route('cart.guest.add') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" 
                                            class="w-full px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2 shadow-md">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Load More Button -->
                    @if($courses->count() > 8)
                    <div class="col-span-full text-center mt-8">
                        <button @click="visibleCourses += 8" 
                                x-show="visibleCourses < {{ $courses->count() }}"
                                class="px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-md font-semibold transition-all hover:scale-105 shadow-lg">
                            Load More Courses
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="about" class="py-16 bg-teal-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Why Choose <span class="text-teal-600">Edvantage?</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Join thousands of learners who have transformed their careers with our comprehensive courses and expert guidance
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Industry-Recognized Certificates</h3>
                    <p class="text-gray-600 leading-relaxed">Earn certificates that are valued by top companies worldwide</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Instructors</h3>
                    <p class="text-gray-600 leading-relaxed">Learn from professionals with years of industry experience</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Lifetime Access</h3>
                    <p class="text-gray-600 leading-relaxed">Access your courses anytime, anywhere, forever</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Career Advancement</h3>
                    <p class="text-gray-600 leading-relaxed">Gain skills that help you grow in your career</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Quality Content</h3>
                    <p class="text-gray-600 leading-relaxed">High-quality video lectures and hands-on projects</p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all border border-gray-100 transform hover:-translate-y-4 duration-300">
                    <div class="bg-teal-600 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Global Community</h3>
                    <p class="text-gray-600 leading-relaxed">Connect with learners from around the world</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- About -->
                <div>
                    <h3 class="text-2xl font-bold mb-4">EDVANTAGE</h3>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Your virtual classroom redefined. Empowering learners worldwide with quality education and expert instruction.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                        <a href="#" class="bg-white/10 hover:bg-white/20 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-3 text-gray-300">
                        <li><a href="#about" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#courses" class="hover:text-white transition-colors">Courses</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Become an Instructor</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Popular Categories</h4>
                    <ul class="space-y-3 text-gray-300">
                        <li><a href="#" class="hover:text-white transition-colors">Web Development</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Data Science</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Business</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Design</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Marketing</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                    <ul class="space-y-4 text-gray-300">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>support@edvantage.com</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span>+880 1234-567890</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Dhaka, Bangladesh</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-white/10 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-gray-400 text-sm">
                    <p>&copy; 2026 Edvantage. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-white transition-colors">Terms of Service</a>
                        <a href="#" class="hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>