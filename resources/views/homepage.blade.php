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

        /* ===== NEW CHATBOT STYLES ===== */

        /* Floating button pulse */
        @keyframes chatPulse {
            0%, 100% { box-shadow: 0 4px 20px rgba(13,148,136,0.45); }
            50% { box-shadow: 0 4px 28px rgba(13,148,136,0.7), 0 0 0 10px rgba(13,148,136,0.08); }
        }

        @keyframes bounceDot {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(12px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes fadeSlideDown {
            from { opacity: 1; transform: translateY(0) scale(1); }
            to   { opacity: 0; transform: translateY(12px) scale(0.97); }
        }

        @keyframes msgIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Floating trigger button */
        .cb-trigger {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #0d9488;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            animation: chatPulse 2.5s ease-in-out infinite;
            transition: transform 0.2s ease, background 0.2s;
        }
        .cb-trigger:hover { transform: scale(1.08); background: #0f766e; }
        .cb-trigger.open { animation: none; background: #1f2937; box-shadow: 0 4px 20px rgba(0,0,0,0.25); }

        /* Unread badge */
        .cb-badge {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 14px;
            height: 14px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Chat window */
        .cb-window {
            position: fixed;
            bottom: 100px;
            right: 28px;
            z-index: 9998;
            width: 340px;
            max-width: calc(100vw - 56px);
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.16), 0 4px 16px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.06);
            animation: fadeSlideUp 0.28s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .cb-window.closing {
            animation: fadeSlideDown 0.2s ease forwards;
        }

        /* Header */
        .cb-header {
            padding: 18px 20px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f3f4f6;
        }
        .cb-header-left {
            display: flex;
            align-items: center;
            gap: 11px;
        }
        .cb-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0d9488, #14b8a6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .cb-header-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.01em;
        }
        .cb-header-sub {
            font-size: 11px;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 1px;
        }
        .cb-online-dot {
            width: 7px;
            height: 7px;
            background: #22c55e;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .cb-header-actions {
            display: flex;
            gap: 6px;
        }
        .cb-header-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: #f9fafb;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 13px;
            transition: background 0.15s, color 0.15s;
        }
        .cb-header-btn:hover { background: #f3f4f6; color: #374151; }

        /* Messages */
        .cb-messages {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 18px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            max-height: 340px;
            min-height: 200px;
            background: #ffffff;
            scroll-behavior: smooth;
        }
        .cb-messages::-webkit-scrollbar { width: 4px; }
        .cb-messages::-webkit-scrollbar-track { background: transparent; }
        .cb-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }

        /* Welcome state */
        .cb-welcome {
            text-align: left;
            padding: 4px 0;
            animation: msgIn 0.3s ease forwards;
        }
        .cb-welcome-text {
            font-size: 14px;
            color: #374151;
            line-height: 1.65;
            margin-bottom: 16px;
        }
        .cb-welcome-text strong { color: #111827; }

        /* Quick reply pills */
        .cb-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .cb-pill {
            border: 1.5px solid #e5e7eb;
            background: white;
            border-radius: 100px;
            padding: 8px 16px;
            font-size: 12.5px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.18s ease;
            white-space: nowrap;
        }
        .cb-pill:hover {
            border-color: #0d9488;
            color: #0d9488;
            background: #f0fdfa;
        }

        /* Message bubbles */
        .cb-msg-pair {
            display: flex;
            flex-direction: column;
            gap: 10px;
            animation: msgIn 0.25s ease forwards;
        }
        .cb-msg-user {
            align-self: flex-end;
            background: #111827;
            color: white;
            padding: 10px 14px;
            border-radius: 16px;
            border-bottom-right-radius: 4px;
            font-size: 13px;
            max-width: 78%;
            line-height: 1.55;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }
        .cb-msg-bot-row {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            width: 100%;
        }
        .cb-msg-bot-avatar {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #f0fdfa, #ccfbf1);
            border: 1.5px solid #99f6e4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .cb-msg-bot-bubble {
            background: #f9fafb;
            border: 1px solid #f3f4f6;
            color: #1f2937;
            padding: 10px 14px;
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            font-size: 13px;
            max-width: calc(100% - 42px);
            line-height: 1.6;
            word-break: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        /* Typing indicator */
        .cb-typing {
            display: flex;
            gap: 9px;
            align-items: flex-start;
            animation: msgIn 0.2s ease forwards;
        }
        .cb-typing-dots {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .cb-dot {
            width: 6px;
            height: 6px;
            background: #9ca3af;
            border-radius: 50%;
            animation: bounceDot 1.3s ease-in-out infinite;
        }
        .cb-dot:nth-child(2) { animation-delay: 0.18s; }
        .cb-dot:nth-child(3) { animation-delay: 0.36s; }

        /* Input area */
        .cb-input-area {
            padding: 14px 16px 16px;
            border-top: 1px solid #f3f4f6;
            background: white;
        }
        .cb-input-row {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 100px;
            padding: 8px 8px 8px 16px;
            transition: border-color 0.2s;
        }
        .cb-input-row:focus-within {
            border-color: #0d9488;
            background: white;
        }
        .cb-input-row textarea {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 13px;
            font-family: 'Montserrat', sans-serif;
            color: #1f2937;
            outline: none;
            resize: none;
            max-height: 72px;
            line-height: 1.5;
        }
        .cb-input-row textarea::placeholder { color: #9ca3af; }
        .cb-send-btn {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #0d9488;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 13px;
            flex-shrink: 0;
            transition: background 0.18s, transform 0.15s;
        }
        .cb-send-btn:hover:not(:disabled) { background: #0f766e; transform: scale(1.05); }
        .cb-send-btn:disabled { background: #d1d5db; cursor: not-allowed; }
        .cb-input-hint {
            text-align: center;
            font-size: 10px;
            color: #d1d5db;
            margin-top: 8px;
            letter-spacing: 0.02em;
        }

        /* Emoji + attach icons */
        .cb-input-extras {
            display: flex;
            gap: 6px;
            align-items: center;
            margin-right: 4px;
        }
        .cb-input-icon {
            width: 26px;
            height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            cursor: pointer;
            font-size: 15px;
            border-radius: 6px;
            transition: color 0.15s;
        }
        .cb-input-icon:hover { color: #374151; }

        /* Tooltip bubble */
        .cb-tooltip {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: #1f2937;
            color: white;
            font-size: 12px;
            font-weight: 500;
            padding: 7px 12px;
            border-radius: 10px;
            white-space: nowrap;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            pointer-events: none;
        }
        .cb-tooltip::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right: none;
            border-left-color: #1f2937;
        }

        /* Mobile */
        @media (max-width: 480px) {
            .cb-trigger { bottom: 18px; right: 18px; }
            .cb-window { width: calc(100vw - 28px); right: 14px; bottom: 90px; max-width: calc(100vw - 28px); }
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
                            @if($course->category)
                                <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $course->category }}
                                </span>
                            @endif

                            <h3 class="font-bold text-lg text-gray-900 line-clamp-2 min-h-[3.5rem]">
                                {{ $course->title }}
                            </h3>

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

                            <div class="pt-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-gray-900">৳</span>
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($course->price ?? 0, 0) }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2 pt-2">
                                <a href="{{ route('courses.details', $course->id) }}" 
                                   class="flex-1 px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center text-sm font-semibold rounded-md transition-colors">
                                    Details
                                </a>
                                
                                <div class="flex gap-2">
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


{{-- ================= REDESIGNED CHATBOT WIDGET ================= --}}

<style>
@keyframes cbBounce {
    0%,60%,100%{transform:translateY(0)}
    30%{transform:translateY(-5px)}
}
@keyframes cbPulse {
    0%,100%{box-shadow:0 4px 20px rgba(13,148,136,0.45)}
    50%{box-shadow:0 4px 28px rgba(13,148,136,0.7),0 0 0 10px rgba(13,148,136,0.08)}
}
#cb-window {
    position: fixed !important;
    bottom: 100px !important;
    right: 24px !important;
    width: 330px !important;
    height: 500px !important;
    z-index: 99999 !important;
    background: #fff !important;
    border-radius: 20px !important;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 20px rgba(0,0,0,0.1) !important;
    border: 1px solid rgba(0,0,0,0.08) !important;
    display: none !important;
    flex-direction: column !important;
    overflow: hidden !important;
}
#cb-window.cb-open {
    display: flex !important;
}
#cb-trigger {
    position: fixed !important;
    bottom: 28px !important;
    right: 28px !important;
    z-index: 99999 !important;
    width: 56px !important;
    height: 56px !important;
    border-radius: 50% !important;
    background: #0d9488 !important;
    border: none !important;
    cursor: pointer !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: white !important;
    font-size: 22px !important;
    animation: cbPulse 2.5s ease-in-out infinite !important;
    transition: background 0.2s !important;
}
#cb-trigger:hover { background: #0f766e !important; }
#cb-messages {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    background: #fff;
    scroll-behavior: smooth;
}
#cb-messages::-webkit-scrollbar { width: 4px; }
#cb-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
.cb-user-bubble {
    align-self: flex-end;
    background: #111827;
    color: white;
    padding: 9px 13px;
    border-radius: 16px;
    border-bottom-right-radius: 4px;
    font-size: 13px;
    max-width: 78%;
    line-height: 1.55;
    word-break: break-word;
    font-family: 'Montserrat', sans-serif;
}
.cb-bot-row {
    display: flex;
    gap: 8px;
    align-items: flex-start;
}
.cb-bot-avatar {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg,#f0fdfa,#ccfbf1);
    border: 1.5px solid #99f6e4;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 2px;
}
.cb-bot-bubble {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    color: #1f2937;
    padding: 9px 13px;
    border-radius: 16px;
    border-bottom-left-radius: 4px;
    font-size: 13px;
    line-height: 1.6;
    word-break: break-word;
    overflow-wrap: break-word;
    flex: 1;
    min-width: 0;
    font-family: 'Montserrat', sans-serif;
}
.cb-pill-btn {
    border: 1.5px solid #e5e7eb;
    background: white;
    border-radius: 100px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
    transition: all 0.18s;
}
.cb-pill-btn:hover {
    border-color: #0d9488;
    color: #0d9488;
    background: #f0fdfa;
}
</style>

<!-- Floating Trigger -->
<button id="cb-trigger" onclick="cbToggle()">
    <span id="cb-icon-open"><i class="fas fa-comments"></i></span>
    <span id="cb-icon-close" style="display:none;"><i class="fas fa-chevron-down"></i></span>
    <span id="cb-badge" style="display:none;position:absolute;top:3px;right:3px;width:14px;height:14px;background:#ef4444;border-radius:50%;border:2px solid white;"></span>
</button>

<!-- Chat Window -->
<div id="cb-window">

    <!-- Header -->
    <div style="padding:15px 18px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #f3f4f6;flex-shrink:0;">
        <div style="display:flex;align-items:center;gap:10px;">

            <div>
                <div style="font-size:14px;font-weight:700;color:#111827;">Edvantage Assistant</div>
                <div style="font-size:11px;color:#6b7280;display:flex;align-items:center;gap:4px;margin-top:1px;">
                    <span style="width:6px;height:6px;background:#22c55e;border-radius:50%;display:inline-block;flex-shrink:0;"></span>
                    Online 
                </div>
            </div>
        </div>
        <div style="display:flex;gap:6px;">
            <button style="width:28px;height:28px;border:none;background:#f9fafb;border-radius:8px;cursor:pointer;color:#9ca3af;font-size:12px;" title="Options"><i class="fas fa-ellipsis-h"></i></button>
            <button onclick="cbToggle()" style="width:28px;height:28px;border:none;background:#f9fafb;border-radius:8px;cursor:pointer;color:#9ca3af;font-size:12px;" title="Minimize"><i class="fas fa-chevron-down"></i></button>
        </div>
    </div>

    <!-- Messages -->
    <div id="cb-messages">
        <!-- Welcome shown by JS -->
    </div>

    <!-- Input -->
    <div style="padding:12px 14px 14px;border-top:1px solid #f3f4f6;background:white;flex-shrink:0;">
        <div id="cb-input-wrap" style="display:flex;align-items:center;gap:8px;background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:100px;padding:7px 7px 7px 14px;transition:border-color 0.2s;">
            <textarea id="cb-input"
                      placeholder="Write a message..."
                      rows="1"
                      style="flex:1;border:none;background:transparent;font-size:13px;font-family:'Montserrat',sans-serif;color:#1f2937;outline:none;resize:none;max-height:72px;line-height:1.5;"
                      onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();cbSend();}"
                      oninput="cbAutoResize(this)"
                      onfocus="document.getElementById('cb-input-wrap').style.borderColor='#0d9488';document.getElementById('cb-input-wrap').style.background='white';"
                      onblur="document.getElementById('cb-input-wrap').style.borderColor='#e5e7eb';document.getElementById('cb-input-wrap').style.background='#f9fafb';"></textarea>
            <div style="display:flex;gap:4px;align-items:center;flex-shrink:0;">
                <span style="color:#9ca3af;font-size:15px;cursor:pointer;">☺</span>
                <span style="color:#9ca3af;font-size:13px;cursor:pointer;">📎</span>
            </div>
            <button id="cb-send-btn" onclick="cbSend()" style="width:32px;height:32px;border-radius:50%;background:#0d9488;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;flex-shrink:0;transition:background 0.18s;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
        <p style="text-align:center;font-size:10px;color:#d1d5db;margin-top:7px;letter-spacing:0.02em;">Powered by Edvantage AI ✦</p>
    </div>
</div>

<script>
(function() {
    var isOpen = false;
    var isTyping = false;
    var messages = [];
    var conversationHistory = [];
    var hasShownWelcome = false;
    var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Show unread badge after 3s
    setTimeout(function() {
        if (!isOpen) {
            document.getElementById('cb-badge').style.display = 'block';
        }
    }, 3000);

    window.cbToggle = function() {
        isOpen = !isOpen;
        var win = document.getElementById('cb-window');
        var iconOpen = document.getElementById('cb-icon-open');
        var iconClose = document.getElementById('cb-icon-close');
        var badge = document.getElementById('cb-badge');

        if (isOpen) {
            win.classList.add('cb-open');
            iconOpen.style.display = 'none';
            iconClose.style.display = 'block';
            badge.style.display = 'none';
            if (!hasShownWelcome) {
                cbShowWelcome();
                hasShownWelcome = true;
            }
            setTimeout(function() {
                document.getElementById('cb-input').focus();
                cbScrollToBottom();
            }, 50);
        } else {
            win.classList.remove('cb-open');
            iconOpen.style.display = 'block';
            iconClose.style.display = 'none';
        }
    };

    function cbShowWelcome() {
        var el = document.getElementById('cb-messages');
        el.innerHTML = '<div style="padding:4px 0;">' +
            '<p style="font-size:13.5px;color:#374151;line-height:1.65;margin-bottom:14px;"> <strong style="color:#111827;">I\'m an AI chatbot</strong> here to help you find your way.</p>' +
            '<div style="display:flex;flex-wrap:wrap;gap:8px;">' +
            '<button class="cb-pill-btn" onclick="cbAsk(\'I need support\')">I need Support</button>' +
            '<button class="cb-pill-btn" onclick="cbAsk(\'Show me all courses you have\')">Show me all courses you have</button>' +
            '<button class="cb-pill-btn" onclick="cbAsk(\'Show me popular courses\')">Popular Courses</button>' +
            '<button class="cb-pill-btn" onclick="cbAsk(\'How does the platform work?\')">How it works</button>' +
            '</div></div>';
    }

    window.cbAsk = function(question) {
        document.getElementById('cb-input').value = question;
        cbSend();
    };

    window.cbSend = function() {
        var input = document.getElementById('cb-input');
        var msg = input.value.trim();
        if (!msg || isTyping) return;

        input.value = '';
        input.style.height = 'auto';
        isTyping = true;

        // Clear welcome if first message
        var el = document.getElementById('cb-messages');
        if (messages.length === 0) el.innerHTML = '';

        // Add user bubble
        var pair = document.createElement('div');
        pair.style.cssText = 'display:flex;flex-direction:column;gap:10px;';
        pair.innerHTML =
            '<div style="display:flex;justify-content:flex-end;"><div class="cb-user-bubble">' + cbEscape(msg) + '</div></div>' +
            '<div class="cb-bot-row"><div class="cb-bot-avatar">🤖</div><div class="cb-bot-bubble" id="cb-bot-' + messages.length + '">...</div></div>';
        el.appendChild(pair);
        messages.push({ user: msg, bot: '', el: pair });
        cbScrollToBottom();

        // Add typing dots
        var typingEl = document.createElement('div');
        typingEl.id = 'cb-typing';
        typingEl.className = 'cb-bot-row';
        typingEl.innerHTML = '<div class="cb-bot-avatar">🤖</div>' +
            '<div style="background:#f3f4f6;border:1px solid #e5e7eb;padding:11px 14px;border-radius:16px;border-bottom-left-radius:4px;display:flex;gap:4px;align-items:center;">' +
            '<div style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:cbBounce 1.3s infinite;"></div>' +
            '<div style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:cbBounce 1.3s 0.18s infinite;"></div>' +
            '<div style="width:6px;height:6px;background:#9ca3af;border-radius:50%;animation:cbBounce 1.3s 0.36s infinite;"></div>' +
            '</div>';
        el.appendChild(typingEl);
        cbScrollToBottom();

        fetch('/chatbot/ask', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: msg, history: conversationHistory }),
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var idx = messages.length - 1;
            var botBubble = document.getElementById('cb-bot-' + idx);
            var reply = (data.success ? data.message : (data.message || 'Sorry, something went wrong.'));
            if (botBubble) botBubble.innerHTML = cbFormat(reply);
            messages[idx].bot = reply;
            conversationHistory.push({ role: 'user', content: msg });
            conversationHistory.push({ role: 'model', content: reply });
            if (conversationHistory.length > 20) conversationHistory = conversationHistory.slice(-20);
        })
        .catch(function() {
            var idx = messages.length - 1;
            var botBubble = document.getElementById('cb-bot-' + idx);
            if (botBubble) botBubble.innerHTML = 'Sorry, I encountered an error. Please try again.';
        })
        .finally(function() {
            isTyping = false;
            var t = document.getElementById('cb-typing');
            if (t) t.remove();
            cbScrollToBottom();
        });
    };

    window.cbAutoResize = function(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 72) + 'px';
    };

    function cbScrollToBottom() {
        setTimeout(function() {
            var el = document.getElementById('cb-messages');
            if (el) el.scrollTop = el.scrollHeight;
        }, 30);
    }

    function cbEscape(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function cbFormat(text) {
        if (!text) return '';
        text = text.replace(/\[([^\]]+)\]\(([^\)]+)\)/g, '<a href="$2" target="_blank" style="color:#0d9488;font-weight:600;text-decoration:underline;">$1</a>');
        text = text.replace(/\*\*([^*]+)\*\*/g, '<strong style="color:#111827;font-weight:600;">$1</strong>');
        text = text.replace(/\n/g, '<br>');
        return text;
    }
})();
</script>

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
          target.scrollIntoView({ behavior: 'smooth' });
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

  // Chatbot is now handled by vanilla JS above

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