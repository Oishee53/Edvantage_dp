<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EDVANTAGE - Your Virtual Classroom Redefined</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
       * {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Chatbot Animations */
        @keyframes pulse {
            0%, 100% { box-shadow: 0 6px 24px rgba(13,148,136,0.4); }
            50% { box-shadow: 0 6px 32px rgba(13,148,136,0.6), 0 0 0 8px rgba(13,148,136,0.1); }
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        @keyframes bounce-small {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes bounce-dot {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-6px); }
        }

        /* FIXED: Scrollable Messages Area */
        .chatbot-messages-scroll {
            overflow-y: auto !important;
            overflow-x: hidden;
            max-height: 100%;
            scroll-behavior: smooth;
        }
        
        .chatbot-messages-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .chatbot-messages-scroll::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 10px;
        }
        
        .chatbot-messages-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .chatbot-messages-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mobile Responsive for Chatbot */
        @media (max-width: 640px) {
            .chatbot-head {
                bottom: 16px !important;
                right: 16px !important;
            }
            .chatbot-window {
                width: calc(100vw - 32px) !important;
                right: 16px !important;
                bottom: 90px !important;
                height: 500px !important;
            }
        }
    </style>
</head>
<body>
   <!-- Main Navigation Bar -->
   @include('layouts.header')

   @include('layouts.category-bar')

   @include('layouts.hero')
    

      {{-- ================= RECOMMENDED COURSES ================= --}}
@if(auth()->check() && isset($recommendedCourses) && count($recommendedCourses))
<section id="recommended" class="py-16 bg-gray-50"> 
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="text-center mb-12 pt-5">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Recommended For You</h2>
                <p class="text-xl text-gray-600">Courses based on your searches and learning activity</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 pb-8 px-8">
                @foreach($recommendedCourses as $course)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl border border-gray-200 hover:border-teal-500 transition-all cursor-pointer group transform hover:-translate-y-2 duration-300">
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
                            @if($course->category)
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
                                <div class="flex gap-2">
                                    <!-- Wishlist Button -->
                                    <form method="POST" action="{{ route('wishlist.add', $course->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full px-2 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2"
                                                title="Add to Wishlist">
                                            <svg class="w-4 h-4" fill="white" viewBox="0 0 20 20">
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
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
{{-- ================= END RECOMMENDED COURSES ================= --}}


@include('layouts.featured-course')


{{-- ================= FIXED CHATBOT WIDGET ================= --}}
<div x-data="landingChatbot()" x-init="init()" class="landing-chatbot">
    
    <!-- Chat Head Button -->
    <div @click="toggleChat()" 
         class="chatbot-head"
         :class="{ 'chat-open': isOpen }"
         style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; cursor: pointer;">
        
        <div style="width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); box-shadow: 0 6px 24px rgba(13,148,136,0.4); display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative;"
             :style="isOpen ? 'transform: scale(0.9);' : 'transform: scale(1); animation: pulse 2s infinite;'">
            
            <div style="color: white; font-size: 28px; transition: all 0.3s;" x-show="!isOpen">
                <i class="fas fa-comments"></i>
            </div>
            <div style="color: white; font-size: 24px; transition: all 0.3s;" x-show="isOpen">
                <i class="fas fa-times"></i>
            </div>

            <div x-show="hasUnread && !isOpen" 
                 style="position: absolute; top: 4px; right: 4px; width: 18px; height: 18px; background: #ef4444; border-radius: 50%; border: 3px solid white; animation: bounce-small 1s infinite;"></div>
        </div>

        <div x-show="!isOpen" 
             style="position: absolute; right: 76px; top: 50%; transform: translateY(-50%); background: #1f2937; color: white; padding: 8px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap; box-shadow: 0 4px 12px rgba(0,0,0,0.15); pointer-events: none;"
             x-transition>
            💬 Need help? Chat with us!
        </div>
    </div>

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 transform translate-y-4 scale-95"
         class="chatbot-window"
         style="position: fixed; bottom: 100px; right: 24px; z-index: 9998; width: 380px; height: 550px; background: white; border-radius: 16px; box-shadow: 0 12px 48px rgba(0,0,0,0.2); display: flex; flex-direction: column; overflow: hidden; border: 1px solid #e5e7eb;">

        <!-- Header (Fixed) -->
        <div style="background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); padding: 18px 20px; display: flex; align-items: center; gap: 12px; color: white; flex-shrink: 0;">
            <div style="width: 44px; height: 44px; background: rgba(255,255,255,0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                🤖
            </div>
            <div style="flex: 1;">
                <h3 style="margin: 0; font-size: 17px; font-weight: 700; letter-spacing: -0.02em;">Edvantage Assistant</h3>
                <p style="margin: 0; font-size: 12px; opacity: 0.95;">Here to help you find courses!</p>
            </div>
            <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981; animation: pulse-dot 2s infinite;"></div>
        </div>

        <!-- Messages Area (Scrollable) -->
        <div x-ref="messages" 
             class="chatbot-messages-scroll"
             style="flex: 1; padding: 16px; background: #f9fafb; display: flex; flex-direction: column; gap: 12px;">

            <!-- Welcome Message -->
            <template x-if="messages.length === 0 && !isTyping">
                <div style="text-align: center; padding: 20px 16px;">
                    <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ccfbf1, #99f6e4); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 14px; box-shadow: 0 4px 12px rgba(13,148,136,0.15);">
                        👋
                    </div>
                    <h4 style="margin: 0 0 6px; font-size: 15px; font-weight: 700; color: #1f2937;">Hi there!</h4>
                    <p style="margin: 0 0 16px; font-size: 12px; color: #6b7280; line-height: 1.5;">I can help you find courses, answer questions, and more!</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <button @click="askQuestion('Do you have machine learning courses?')"
                                style="background: white; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; font-size: 12px; color: #374151; cursor: pointer; text-align: left; transition: all 0.2s; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                            <span style="width: 28px; height: 28px; background: #f0fdfa; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">🔍</span>
                            <span>Find ML courses</span>
                        </button>
                        <button @click="askQuestion('Show me popular courses')"
                                style="background: white; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; font-size: 12px; color: #374151; cursor: pointer; text-align: left; transition: all 0.2s; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                            <span style="width: 28px; height: 28px; background: #fef3c7; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">⭐</span>
                            <span>Popular courses</span>
                        </button>
                        <button @click="askQuestion('How does the platform work?')"
                                style="background: white; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 10px 12px; font-size: 12px; color: #374151; cursor: pointer; text-align: left; transition: all 0.2s; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                            <span style="width: 28px; height: 28px; background: #dbeafe; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">ℹ️</span>
                            <span>How it works</span>
                        </button>
                    </div>
                </div>
            </template>

            <!-- Conversation Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div>
                    <!-- User Message -->
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                        <div style="background: #0d9488; color: white; padding: 9px 13px; border-radius: 14px; border-bottom-right-radius: 3px; max-width: 75%; font-size: 13px; line-height: 1.5; word-break: break-word;" x-text="msg.user"></div>
                    </div>

                    <!-- Bot Message -->
                    <div style="display: flex; gap: 8px; align-items: flex-start;">
                        <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #1a1a2e, #2d2d5e); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;">
                            🤖
                        </div>
                        <div style="background: white; padding: 9px 13px; border-radius: 14px; border-bottom-left-radius: 3px; max-width: 75%; border: 1px solid #e5e7eb; font-size: 13px; line-height: 1.6; color: #1f2937; word-break: break-word;" x-html="formatMessage(msg.bot)"></div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <template x-if="isTyping">
                <div style="display: flex; gap: 8px; align-items: flex-start;">
                    <div style="width: 30px; height: 30px; background: linear-gradient(135deg, #1a1a2e, #2d2d5e); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;">
                        🤖
                    </div>
                    <div style="background: white; padding: 11px 14px; border-radius: 14px; border-bottom-left-radius: 3px; border: 1px solid #e5e7eb; display: flex; gap: 3px;">
                        <div style="width: 7px; height: 7px; background: #9ca3af; border-radius: 50%; animation: bounce-dot 1.2s infinite;"></div>
                        <div style="width: 7px; height: 7px; background: #9ca3af; border-radius: 50%; animation: bounce-dot 1.2s infinite 0.2s;"></div>
                        <div style="width: 7px; height: 7px; background: #9ca3af; border-radius: 50%; animation: bounce-dot 1.2s infinite 0.4s;"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Input Area (Fixed at Bottom) -->
        <div style="padding: 12px 14px; border-top: 1px solid #e5e7eb; background: white; flex-shrink: 0;">
            <form @submit.prevent="sendMessage()" style="display: flex; gap: 8px; align-items: flex-end;">
                <textarea x-model="input" 
                          x-ref="inputField"
                          placeholder="Ask me anything..."
                          @keydown.enter.prevent="!$event.shiftKey && sendMessage()"
                          rows="1"
                          style="flex: 1; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 9px 12px; font-size: 13px; outline: none; resize: none; max-height: 80px; font-family: 'Montserrat', sans-serif; transition: border-color 0.2s;"
                          :disabled="isTyping"
                          @focus="$event.target.style.borderColor='#0d9488'"
                          @blur="$event.target.style.borderColor='#e5e7eb'"
                          @input="autoResize($event)"></textarea>
                <button type="submit" 
                        :disabled="!input.trim() || isTyping"
                        style="width: 38px; height: 38px; background: #0d9488; color: white; border: none; border-radius: 9px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 15px; transition: all 0.2s; flex-shrink: 0;"
                        :style="(!input.trim() || isTyping) ? 'background: #cbd5e1; cursor: not-allowed;' : ''"
                        @mouseover="!(!input.trim() || isTyping) && ($event.target.style.background='#0f766e')"
                        @mouseout="!(!input.trim() || isTyping) && ($event.target.style.background='#0d9488')">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <p style="text-align: center; font-size: 10px; color: #9ca3af; margin: 6px 0 0;">Powered by AI</p>
        </div>
    </div>
</div>
{{-- ================= END CHATBOT WIDGET ================= --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const searchForm = document.querySelector('.search-form');
    
    if (searchInput && searchForm) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim().length > 0) {
                    searchForm.submit();
                }
            }
        });
    }
});

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
          target.scrollIntoView({
            behavior: 'smooth'
          });
      }
    });
  });

  window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (header) {
        if (window.scrollY > 100) {
          header.style.background = 'rgba(255, 255, 255, 0.98)';
        } else {
          header.style.background = 'rgba(255, 255, 255, 0.95)';
        }
    }
  });

  @if(session('cart_added'))
    if (confirm("{{ session('cart_added') }} Go to cart?")) {
      window.location.href = "{{ route('cart.all') }}";
    }
  @endif

  @if(session('wishlist_added'))
    if (confirm("{{ session('wishlist_added') }} Go to wishlist?")) {
      window.location.href = "{{ route('wishlist.all') }}";
    }
  @endif

  // Chatbot Alpine.js Component
  function landingChatbot() {
        return {
            isOpen: false,
            isTyping: false,
            hasUnread: false,
            input: '',
            messages: [],
            conversationHistory: [],
            csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),

            init() {
                setTimeout(() => {
                    if (!this.isOpen && this.messages.length === 0) {
                        this.hasUnread = true;
                    }
                }, 3000);
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                this.hasUnread = false;
                if (this.isOpen) {
                    this.$nextTick(() => {
                        this.scrollToBottom();
                        if (this.$refs.inputField) {
                            this.$refs.inputField.focus();
                        }
                    });
                }
            },

            askQuestion(question) {
                this.input = question;
                this.sendMessage();
            },

            autoResize(event) {
                event.target.style.height = 'auto';
                event.target.style.height = Math.min(event.target.scrollHeight, 80) + 'px';
            },

            async sendMessage() {
                const msg = this.input.trim();
                if (!msg || this.isTyping) return;

                this.input = '';
                if (this.$refs.inputField) {
                    this.$refs.inputField.style.height = 'auto';
                }
                
                this.isTyping = true;

                this.messages.push({
                    user: msg,
                    bot: '',
                });

                this.scrollToBottom();

                try {
                    const res = await fetch('/chatbot/ask', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrf,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            message: msg,
                            history: this.conversationHistory,
                        }),
                    });

                    const data = await res.json();

                    if (data.success) {
                        this.messages[this.messages.length - 1].bot = data.message;

                        this.conversationHistory.push({
                            role: 'user',
                            content: msg,
                        });
                        this.conversationHistory.push({
                            role: 'model',
                            content: data.message,
                        });

                        if (this.conversationHistory.length > 20) {
                            this.conversationHistory = this.conversationHistory.slice(-20);
                        }
                    } else {
                        this.messages[this.messages.length - 1].bot = data.message || 'Sorry, something went wrong.';
                    }

                } catch (error) {
                    console.error('Chatbot error:', error);
                    this.messages[this.messages.length - 1].bot = 'Sorry, I encountered an error. Please try again.';
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();

                    if (!this.isOpen) {
                        this.hasUnread = true;
                    }
                }
            },

            formatMessage(text) {
                if (!text) return '';
                
                text = text.replace(/\[([^\]]+)\]\(([^\)]+)\)/g, '<a href="$2" target="_blank" style="color: #0d9488; font-weight: 600; text-decoration: underline;">$1</a>');
                text = text.replace(/\*\*([^*]+)\*\*/g, '<strong style="color: #0f766e; font-weight: 600;">$1</strong>');
                text = text.replace(/\n/g, '<br>');
                
                return text;
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const el = this.$refs.messages;
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                });
            },
        };
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const cards = document.querySelectorAll('#coursesGrid .course-card');

    if (!loadMoreBtn || cards.length === 0) return;

    let visible = 4;
    const increment = 4;

    loadMoreBtn.addEventListener('click', function () {
        let shown = 0;

        for (let i = visible; i < cards.length && shown < increment; i++) {
            cards[i].style.display = 'flex';
            shown++;
        }

        visible += shown;

        if (visible >= cards.length) {
            loadMoreBtn.style.display = 'none';
        }
    });
});
</script>


</body>
</html>