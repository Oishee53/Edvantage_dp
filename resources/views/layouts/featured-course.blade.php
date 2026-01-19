<!-- Featured Courses Section -->
<section id="courses" class="py-16 bg-gray-50"> 
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="text-center mb-12 pt-5">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured Courses</h2>
                <p class="text-xl text-gray-600">Discover our most popular courses designed to help you achieve your learning goals</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 pb-8 px-8" x-data="{ visibleCourses: 8 }">
                @php $courseIndex = 0; @endphp
                @foreach($courses as $course)
                    @if(!auth()->check() || !auth()->user()->enrolledCourses->contains($course->id))
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl border border-gray-200 hover:border-teal-500 transition-all cursor-pointer group transform hover:-translate-y-2 duration-300"
                         x-show="{{ $courseIndex }} < visibleCourses"
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
                                <!-- Details Button -->
                               <a href="{{ route('courses.details', $course->id) }}" 
                                   class="flex-1 px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center text-sm font-semibold rounded-md transition-colors">
                                    Details
                                </a>
                                
                                <!-- Action Buttons Row -->
                                @auth
                                <div class="flex gap-2">
                                    <!-- Wishlist Button -->
                                    <form method="POST" action="{{ route('wishlist.add', $course->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full px-2 py-2 bg-pink-50 hover:bg-pink-100 text-pink-600 text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2"
                                                title="Add to Wishlist">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <!-- Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $course->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full px-2 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2 shadow-md"
                                                title="Add to Cart">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endauth
                                
                                @guest
                                <form method="POST" action="{{ route('cart.guest.add') }}">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" 
                                            class="w-full px-2 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2 shadow-md">
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
                    @php $courseIndex++; @endphp
                    @endif
                @endforeach

                <!-- Load More Button -->
                @if($courseIndex > 8)
                <div class="col-span-full text-center mt-8">
                    <button @click="visibleCourses += 8" 
                            x-show="visibleCourses < {{ $courseIndex }}"
                            class="px-8 py-3 bg-teal-600 hover:bg-teal-700 text-white rounded-md font-semibold transition-all hover:scale-105 shadow-lg">
                        Load More Courses
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
