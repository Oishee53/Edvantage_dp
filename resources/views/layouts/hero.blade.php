<!-- Hero Section with Carousel - Fixed -->
<section class="pt-28 pb-8 bg-gray-50 mt-5" x-data="{
    currentSlide: 0,
    slides: [
        {
            title: 'Jump into learning — for less',
            description: 'New to Edvantage? Explore our courses starting at just ৳999. Get access to expert-led content and lifetime learning.',
            buttonText: 'Sign up now',
            buttonLink: '/register',
            decorativeType: 'circles',
            icons: [
                { 
                    svg: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 
                    color: 'text-teal-600', 
                    bgColor: 'bg-teal-100',
                    position: 'top-8 left-8'
                },
                { 
                    svg: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 
                    color: 'text-cyan-600', 
                    bgColor: 'bg-cyan-100',
                    position: 'top-16 right-12'
                },
                { 
                    svg: 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 
                    color: 'text-teal-500', 
                    bgColor: 'bg-teal-50',
                    position: 'bottom-16 left-16'
                },
                { 
                    svg: 'M13 10V3L4 14h7v7l9-11h-7z', 
                    color: 'text-amber-600', 
                    bgColor: 'bg-amber-100',
                    position: 'bottom-8 right-20'
                }
            ]
        },
        {
            title: 'Learn from industry experts',
            description: 'Master new skills with courses taught by professionals. Get hands-on experience and real-world knowledge.',
            buttonText: 'Browse courses',
            buttonLink: '#courses',
            decorativeType: 'squares',
            icons: [
                { 
                    svg: 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 
                    color: 'text-purple-600', 
                    bgColor: 'bg-purple-100',
                    position: 'top-12 left-12'
                },
                { 
                    svg: 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 
                    color: 'text-yellow-500', 
                    bgColor: 'bg-yellow-100',
                    position: 'top-8 right-16'
                },
                { 
                    svg: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 
                    color: 'text-blue-600', 
                    bgColor: 'bg-blue-100',
                    position: 'bottom-16 left-12'
                },
                { 
                    svg: 'M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z', 
                    color: 'text-green-600', 
                    bgColor: 'bg-green-100',
                    position: 'bottom-12 right-16'
                }
            ]
        },
        {
            title: 'Advance your career',
            description: 'Gain in-demand skills and earn recognized certificates. Join thousands of learners transforming their careers.',
            buttonText: 'Get started',
            buttonLink: '/register',
            decorativeType: 'waves',
            icons: [
                { 
                    svg: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 
                    color: 'text-emerald-600', 
                    bgColor: 'bg-emerald-100',
                    position: 'top-10 left-10'
                },
                { 
                    svg: 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 
                    color: 'text-pink-600', 
                    bgColor: 'bg-pink-100',
                    position: 'top-16 right-14'
                },
                { 
                    svg: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 
                    color: 'text-indigo-600', 
                    bgColor: 'bg-indigo-100',
                    position: 'bottom-14 left-16'
                },
                { 
                    svg: 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 
                    color: 'text-rose-600', 
                    bgColor: 'bg-rose-100',
                    position: 'bottom-10 right-12'
                }
            ]
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
                            <div class="space-y-4 z-10">
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
                                <div class="relative w-full h-72">
                                    <!-- Decorative elements - Different for each slide -->
                                    
                                    <!-- Slide 1: Circles -->
                                    <template x-if="slide.decorativeType === 'circles'">
                                        <div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-teal-100 rounded-full opacity-50"></div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-cyan-100 rounded-full opacity-70"></div>
                                        </div>
                                    </template>
                                    
                                    <!-- Slide 2: Rotating Squares -->
                                    <template x-if="slide.decorativeType === 'squares'">
                                        <div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 bg-purple-100 rotate-12 opacity-50 rounded-2xl"></div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-28 h-28 bg-yellow-100 -rotate-12 opacity-60 rounded-2xl"></div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-52 h-52 bg-blue-50 rotate-45 opacity-30 rounded-3xl"></div>
                                        </div>
                                    </template>
                                    
                                    <!-- Slide 3: Wave Pattern -->
                                    <template x-if="slide.decorativeType === 'waves'">
                                        <div>
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-56 h-56 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full opacity-40"></div>
                                            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-44 h-44 bg-gradient-to-br from-pink-100 to-rose-100 rounded-full opacity-50 "></div>
                                            <div class="absolute bottom-1/3 left-1/2 -translate-x-1/2 w-36 h-36 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full opacity-50"></div>
                                        </div>
                                    </template>
                                    
                                    <!-- Icons - Different for each slide -->
                                    <template x-for="(icon, idx) in slide.icons" :key="idx">
                                        <div 
                                            class="absolute bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 cursor-pointer" 
                                            :class="icon.position"
                                        >
                                            <div class="p-2 rounded-lg" :class="icon.bgColor">
                                                <svg class="w-8 h-8" :class="icon.color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon.svg"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Navigation Arrows -->
            <button @click="prevSlide(); stopAutoplay(); startAutoplay();" 
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 p-2 rounded-full shadow-md transition-all z-10 hover:scale-110">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button @click="nextSlide(); stopAutoplay(); startAutoplay();" 
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white hover:bg-gray-50 text-gray-800 p-2 rounded-full shadow-md transition-all z-10 hover:scale-110">
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
                        class="h-2 rounded-full transition-all duration-300 hover:bg-teal-500"
                    ></button>
                </template>
            </div>
        </div>
    </div>
</section>
