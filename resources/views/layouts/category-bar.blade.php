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