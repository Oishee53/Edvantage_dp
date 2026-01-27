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
            image: '/image/hero3.jpg',
           
        },
        {
            title: 'Learn from industry experts',
            description: 'Master new skills with courses taught by professionals. Get hands-on experience and real-world knowledge.',
            buttonText: 'Browse courses',
            buttonLink: '#courses',
            decorativeType: 'squares',
            image: '/image/learning2.png',
            
        },
        {
            title: 'Advance your career',
            description: 'Gain in-demand skills and earn recognized certificates. Join thousands of learners transforming their careers.',
            buttonText: 'Get started',
            buttonLink: '/register',
            decorativeType: 'waves',
            image: '/image/career.png',
            
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
                                    <template x-for="(slide.image) in slides" :key="index">
                                        <img :src="slide.image" alt="Hero Image" class="w-full h-full object-contain">
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
