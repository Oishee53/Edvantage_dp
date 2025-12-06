<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History - Edvantage</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        /* Header Styles - Matching the second blade exactly */
        .header {
            background: #fff;
            backdrop-filter: blur(10px);
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: none;
        }
        .logo {
            margin-left: -2rem;
            margin-right:0.75rem;
        }
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-shrink: 0;
        }
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            margin-left: 1rem;
            margin-right: -1rem;
        }
        .nav-menu a:hover{
            color: #0E1B33;
        }
        .nav-menu a {
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            color: #374151;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            margin-right:1rem;
        }
        .btn {
            padding: 0.2rem 0.75rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-outline {
            background: transparent;
            color: #0E1B33;
            border: 2px solid #0E1B33;
        }
        .btn-outline:hover {
            background: #dcdcdd;
            color: #0E1B33;
        }
        .btn-primary {
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33;
        }
        .btn-primary:hover {
            background: #475569;
        }
        .top-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 2rem;
            margin-right: -2rem;
        }
        .icon-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
            color: #0E1B33;
            background: rgba(14, 27, 51, 0.08);
            border: 1px solid rgba(14, 27, 51, 0.2);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        .icon-button:hover {
            background: rgba(14, 27, 51, 0.15);
            border-color: rgba(14, 27, 51, 0.3);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }
        .icon-button:active {
            transform: translateY(0);
        }
        .user-menu-button {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #0E1B33 0%, #475569 100%);
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3);
        }
        .user-menu-button:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(14, 27, 51, 0.4);
        }
        .user-menu-button:active {
            transform: translateY(0);
        }
        .user-menu-button i {
            font-size: 1rem;
        }
        .user-menu {
            position: relative;
        }
        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }
        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .user-dropdown a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        .user-dropdown a:last-child {
            border-bottom: none;
        }
        .user-dropdown a:hover {
            background: #f8fafc;
            color: #0E1B33;
        }
        .user-dropdown .icon {
            margin-right: 12px;
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
            color: #0E1B33;
        }
        .user-dropdown .separator {
            height: 1px;
            background: #e5e7eb;
            margin: 8px 0;
        }
        .search-form {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        .search-input {
            width: 400px;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 24px;
            font-size: 1rem;
        }
        /* Username styling */
        .username {
            margin-left: 1.5rem;
            font-weight: 500;
            color: #374151;
        }
        
        /* Main content padding to account for fixed header */
        body {
            padding-top: 80px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .search-input {
                width: 300px;
            }
            .username {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Main Navigation Bar -->
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="/image/Edvantage.png" alt="EDVANTAGE Logo" style="height:40px; vertical-align:middle;">
            </a>
           <form class="search-form" action="{{ route('courses.search') }}" method="GET">
    <input type="text" 
           name="search" 
           placeholder="What do you want to learn?" 
           class="search-input"
           value="{{ request('search') }}"
           autocomplete="off">
          </form>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </nav>
            <div class="top-icons">
                <a href="/wishlist" class="icon-button" title="Wishlist">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <a href="/cart" class="icon-button" title="Shopping Cart">
                    <i class="fa-solid fa-shopping-bag"></i>
                </a>
                <div class="user-menu">
                    <button class="user-menu-button" title="User Menu">
                        <i class="fa-solid fa-user-circle"></i>
                    </button>
                    <div class="user-dropdown">
                        <a href="/profile"><i class="fa-solid fa-user icon"></i> My Profile</a>
                        <a href="{{ route('courses.enrolled') }}"><i class="fa-solid fa-graduation-cap icon"></i> My Courses</a>
                        <a href="{{ route('user.progress') }}"><i class="fa-solid fa-chart-line icon"></i> My Progress</a>
                        <a href="{{ route('login') }}"><i class="fa-solid fa-book-open icon"></i> Course Catalog</a>
                        <a href="{{ route('purchase.history') }}"><i class="fa-solid fa-receipt icon"></i> Purchase History</a>
                        <div class="separator"></div>
                        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket icon"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            <!-- Hidden logout form -->
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
            <p class="username">{{ explode(' ', auth()->user()->name)[0] }}</p>
        </div>
    </header>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-receipt text-gray-600 text-lg"></i>
                </div>
                <h1 class="text-2xl font-semibold text-gray-900">Purchase History</h1>
            </div>
            <p class="text-gray-600">View all your course purchases and enrollment details</p>
        </div>

        <!-- Content Section -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            @if($enrollments->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-16 px-6">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No purchases yet</h3>
                    <p class="text-gray-600 mb-6">You haven't purchased any courses yet. Start exploring our course catalog!</p>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 bg-gray-900 text-white px-6 py-3 rounded-xl hover:bg-gray-800 transition-colors">
                        <i class="fas fa-search text-sm"></i>
                        Browse Courses
                    </a>
                </div>
            @else
                <!-- Table Header -->
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <span class="text-sm font-medium text-gray-700">Course Details</span>
                        </div>
                        <div class="text-center">
                            <span class="text-sm font-medium text-gray-700">Price</span>
                        </div>
                        <div class="text-center">
                            <span class="text-sm font-medium text-gray-700">Purchase Date</span>
                        </div>
                    </div>
                </div>

                <!-- Table Body -->
                <div class="divide-y divide-gray-200">
                    @foreach($enrollments as $enrollment)
                        <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                                <!-- Course Details -->
                                <div class="md:col-span-2">
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-play-circle text-gray-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900 mb-1">{{ $enrollment->course->title }}</h3>
                                            <p class="text-sm text-gray-600">
                                                @if($enrollment->course->instructor)
                                                    by {{ $enrollment->course->instructor->name }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price -->
                                <div class="text-center">
                                    <span class="inline-flex items-center bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                        ৳{{ number_format($enrollment->course->price, 2) }}
                                    </span>
                                </div>

                                <!-- Purchase Date -->
                                <div class="text-center">
                                    <div class="text-sm text-gray-900 font-medium">
                                        {{ $enrollment->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $enrollment->created_at->format('g:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Total Purchases: <span class="font-medium text-gray-900">{{ $enrollments->count() }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            Total Spent: <span class="font-medium text-green-600">৳{{ number_format($enrollments->sum(function($enrollment) { return $enrollment->course->price; }), 2) }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>