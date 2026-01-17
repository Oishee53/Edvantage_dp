<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EDVANTAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        :root {
            /* Added CSS custom properties to replace hardcoded values */
            --primary-color: #0E1B33;
            --secondary-color: #475569;
            --accent-color: #10b981;
            --warning-color: #ffd700;
            --background-color: #f9f9f9;
            --card-background: #ffffff;
            --text-primary: #111827;
            --text-secondary: #374151;
            --text-muted: #6b7280;
            --text-light: #e5e7eb;
            --border-color: #e5e7eb;
            --border-light: #f3f4f6;
            
            /* Spacing system */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 0.75rem;
            --spacing-lg: 1rem;
            --spacing-xl: 1.5rem;
            --spacing-2xl: 2rem;
            --spacing-3xl: 2.5rem;
            --spacing-4xl: 3rem;
            
            /* Typography */
            --font-size-xs: 0.75rem;
            --font-size-sm: 0.875rem;
            --font-size-base: 1rem;
            --font-size-lg: 1.125rem;
            --font-size-xl: 1.25rem;
            --font-size-2xl: 1.5rem;
            --font-size-3xl: 1.875rem;
            --font-size-4xl: 2.25rem;
            
            /* Layout */
            --container-max-width: 1200px;
            --header-height: 70px;
            --border-radius-sm: 6px;
            --border-radius-md: 8px;
            --border-radius-lg: 12px;
            --border-radius-xl: 24px;
            
            /* Shadows */
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --shadow-xl: 0 10px 25px rgba(0,0,0,0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--background-color);
        }

        /* Font Awesome fix */
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }

        /* Improved header with better responsive behavior */
        .header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: var(--spacing-md) 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: var(--container-max-width);
            margin: 0 auto;
            padding: 0 var(--spacing-2xl);
            gap: var(--spacing-lg);
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: var(--spacing-2xl);
            flex: 1;
            min-width: 0;
        }

        .logo img {
            height: 40px;
            vertical-align: middle;
        }

        /* More flexible search form */
        .search-form {
            flex: 1;
            max-width: min(400px, 100%);
        }

        .search-input {
            width: 100%;
            padding: var(--spacing-md) var(--spacing-lg);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-xl);
            font-size: var(--font-size-sm);
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: var(--spacing-2xl);
            margin: 0;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: var(--font-size-sm);
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        .nav-menu a:hover {
            color: var(--primary-color);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
        }

        .auth-buttons {
            display: flex;
            gap: var(--spacing-md);
            align-items: center;
        }

        .btn {
            padding: var(--spacing-sm) var(--spacing-lg);
            border: none;
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            font-weight: 500;
            font-size: var(--font-size-sm);
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
            text-align: center;
        }

        .btn-login {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-login:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-signup {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }

        .btn-signup:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .top-icons {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .icon-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            font-size: var(--font-size-base);
            color: var(--primary-color);
            background: rgba(14, 27, 51, 0.08);
            border: 1px solid rgba(14, 27, 51, 0.2);
            border-radius: var(--border-radius-md);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .icon-button:hover {
            background: rgba(14, 27, 51, 0.15);
            transform: translateY(-1px);
        }

        .user-menu {
            position: relative;
        }

        .user-menu-button {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: var(--border-radius-md);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--font-size-base);
            transition: all 0.3s ease;
        }

        .user-menu-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.3);
        }

        .user-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background: var(--card-background);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border-light);
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
            padding: 12px 16px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
            transition: background-color 0.2s ease;
            border-bottom: 1px solid var(--border-light);
        }

        .user-dropdown a:last-child {
            border-bottom: none;
        }

        .user-dropdown a:hover {
            background: #f8fafc;
            color: var(--primary-color);
        }

        .user-dropdown .icon {
            margin-right: 10px;
            font-size: 0.85rem;
            width: 16px;
            text-align: center;
            color: var(--primary-color);
        }

        .username {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
            margin-left: var(--spacing-sm);
        }

        /* Fixed main content spacing */
        .main-content {
            margin-top: var(--header-height);
        }

        /* Improved hero section with better responsive grid */
        .course-hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: var(--spacing-5xl) 0;
            min-height: 300px; /* ensures section is taller */
            position: relative;
        }

        .course-hero-container {
            max-width: var(--container-max-width);
            margin: 0 auto;
            padding: 0 var(--spacing-2xl);
            /* Changed to single column layout to allow sidebar positioning */
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--spacing-2xl);
            align-items: start;
            position: relative;
        }

        .course-hero-left h1 {
            font-size: clamp(var(--font-size-2xl), 4vw, var(--font-size-4xl));
            font-weight: 700;
            margin-bottom: var(--spacing-md); /* tighter gap */
            line-height: 1.3; /* natural line height */
        }

        .course-hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: var(--spacing-4xl) 0 var(--spacing-4xl) 0; /* increase top/bottom padding */
            position: relative;
        }
        .course-hero-meta {
            display: flex;
            align-items: center;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-xl);
            font-size: var(--font-size-base);
            flex-wrap: wrap;
        }

        .stars {
            color: var(--warning-color);
        }

        .rating-number {
            font-weight: 600;
        }

        .rating-count {
            color: var(--text-light);
        }

        .course-hero-description {
            font-size: var(--font-size-base);
            line-height: 1.6;
            color: var(--text-light);
            margin-bottom: var(--spacing-lg);
        }

        /* Better positioned sidebar card */
        .course-sidebar-card {
            background: var(--card-background);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xl);
            /* Position sidebar absolutely to start from hero and extend below */
            position: absolute;
            top: var(--spacing-xl);
            right: var(--spacing-2xl);
            width: 400px;
            z-index: 10;
        }

        .sidebar-course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .sidebar-content {
            padding: var(--spacing-2xl);
        }

        .price-section {
            text-align: center;
            margin-bottom: var(--spacing-2xl);
        }

        .course-price {
            font-size: clamp(var(--font-size-xl), 3vw, var(--font-size-4xl));
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: var(--spacing-sm);
        }

        .original-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: var(--font-size-lg);
        }

        .course-quick-stats {
            margin-bottom: var(--spacing-2xl);
            padding: var(--spacing-xl);
            background: var(--background-color);
            border-radius: var(--border-radius-md);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
            padding: var(--spacing-sm) 0;
            font-size: var(--font-size-sm);
            color: var(--text-secondary);
        }

        .stat-item:not(:last-child) {
            border-bottom: 1px solid var(--border-color);
        }

        .course-materials {
            margin-bottom: var(--spacing-2xl);
        }

        .course-materials h4 {
            font-size: var(--font-size-lg);
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-lg);
        }

        .materials-list {
            list-style: none;
            padding: 0;
        }

        .materials-list li {
            padding: var(--spacing-sm) 0;
            color: var(--text-muted);
            font-size: var(--font-size-sm);
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .materials-list li:before {
            content: "✓";
            color: var(--accent-color);
            font-weight: bold;
            font-size: var(--font-size-base);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
            padding: var(--spacing-md) var(--spacing-xl);
            font-size: var(--font-size-base);
            font-weight: 600;
            border-radius: var(--border-radius-md);
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-wishlist {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: var(--spacing-md) var(--spacing-xl);
            font-size: var(--font-size-base);
            font-weight: 600;
            border-radius: var(--border-radius-md);
        }

        .btn-wishlist:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Improved content section layout */
        .course-content-section {
            max-width: var(--container-max-width);
            margin: var(--spacing-2xl) auto;
            padding: 0 var(--spacing-2xl);
            /* Adjusted grid to account for sidebar positioning */
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: var(--spacing-2xl);
        }

        /* Added left content container to avoid sidebar overlap */
        .course-content-left {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-2xl);
        }

        /* Better instructor profile layout */
        .instructor-profile {
            display: flex;
            align-items: flex-start;
            gap: var(--spacing-2xl);
        }

        .instructor-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: var(--font-size-xl);
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }

        .instructor-info-details {
            flex: 1;
        }

        .instructor-name-large {
            font-size: var(--font-size-xl);
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--spacing-md);
        }

        .instructor-detail {
            margin-bottom: var(--spacing-md);
            color: var(--text-muted);
            font-size: var(--font-size-sm);
            line-height: 1.5;
        }

        .instructor-detail strong {
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* Improved prerequisites styling */
        .prerequisites-list {
            list-style: none;
            padding: 0;
        }

        .prerequisites-list li {
            display: flex;
            align-items: flex-start;
            gap: var(--spacing-lg);
            padding: var(--spacing-lg) 0;
            color: var(--text-secondary);
            font-size: var(--font-size-base);
            line-height: 1.6;
            border-bottom: 1px solid var(--border-light);
        }

        .prerequisites-list li:last-child {
            border-bottom: none;
        }

        .prereq-icon {
            color: var(--accent-color);
            font-size: var(--font-size-lg);
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        /* Enhanced responsive design with better breakpoints */
        @media (max-width: 1024px) {
            .course-hero-container {
                grid-template-columns: 1fr;
                gap: var(--spacing-2xl);
            }
            
            /* Reset sidebar positioning for mobile */
            .course-sidebar-card {
                position: relative;
                top: auto;
                right: auto;
                width: 100%;
                max-width: 500px;
                margin: var(--spacing-lg) auto 0 auto;
            }

            .course-content-section {
                grid-template-columns: 1fr;
                margin-top: var(--spacing-lg);
            }

            .nav-container {
                padding: 0 var(--spacing-lg);
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .search-form {
                max-width: 250px;
            }

            .course-hero-container {
                padding: 0 var(--spacing-lg);
            }

            .course-content-section {
                padding: 0 var(--spacing-lg);
                grid-template-columns: 1fr;
                margin-top: var(--spacing-lg);
            }

            .content-card {
                padding: var(--spacing-xl);
            }

            .instructor-profile {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }

            .instructor-avatar-large {
                margin-bottom: var(--spacing-lg);
            }

            .top-icons {
                gap: var(--spacing-sm);
            }

            .icon-button, .user-menu-button {
                width: 36px;
                height: 36px;
                font-size: var(--font-size-sm);
            }
        }

        @media (max-width: 480px) {
            .nav-container {
                flex-wrap: wrap;
                gap: var(--spacing-sm);
            }

            .nav-left {
                flex: 1;
                min-width: 0;
            }

            .search-form {
                order: 3;
                flex-basis: 100%;
                margin-top: var(--spacing-sm);
            }


            .sidebar-content {
                padding: var(--spacing-xl);
            }

            .username {
                display: none;
            }
        }

        /* Animation improvements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-card,
        .course-sidebar-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Focus states for accessibility */
        .btn:focus,
        .icon-button:focus,
        .user-menu-button:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="nav-container">
            <div class="nav-left">
                <a href="/" class="logo">
                    <img src="/image/Edvantage.png" alt="EDVANTAGE Logo">
                </a>
                <form class="search-form" action="" method="GET">
                    <input type="text" name="q" placeholder="What do you want to learn?" class="search-input">
                </form>
                <nav>
                    <ul class="nav-menu">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
            
            <div class="nav-right">
                @auth
                <div class="top-icons">
                    <a href="/wishlist" class="icon-button" title="Wishlist">
                        <i class="fa-solid fa-heart"></i>
                    </a>
                    <a href="/cart" class="icon-button" title="Shopping Cart">
                        <i class="fa-solid fa-shopping-bag"></i>
                    </a>
                    <div class="user-menu">
                        <button class="user-menu-button" title="User Menu">
                            <i class="fa-solid fa-user"></i>
                        </button>
                        <div class="user-dropdown">
                            <a href="/profile"><i class="fa-solid fa-user icon"></i> My Profile</a>
                            <a href="{{ route('courses.enrolled') }}"><i class="fa-solid fa-graduation-cap icon"></i> My Courses</a>
                            <a href="{{ route('user.progress') }}"><i class="fa-solid fa-chart-line icon"></i> My Progress</a>
                            <a href="{{ route('courses.all') }}"><i class="fa-solid fa-book-open icon"></i> Course Catalog</a>
                            <a href="/purchase_history"><i class="fa-solid fa-receipt icon"></i> Purchase History</a>
                            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket icon"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                <span class="username">{{ explode(' ', $user->name)[0] }}</span>
                
                <!-- Hidden logout form -->
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                    @csrf
                </form>
                @else
                <div class="auth-buttons">
                    <a href="/login" class="btn btn-login">Login</a>
                    <a href="/register" class="btn btn-signup">Sign Up</a>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="main-content">
        <!-- Hero Section with Course Info and Sidebar -->
        <div class="course-hero-section">
            <div class="course-hero-container">
                <!-- Left: Course Info -->
                <div class="course-hero-left">
                    <h1>{{ $course->title }}</h1>
                    <div class="course-hero-description">
                        {{ $course->description }}
                    </div>
                </div>
               @php
    $ratingCount = $course->ratings->count();
    $avgRating = $ratingCount > 0
        ? round($course->ratings->avg('rating'), 1)
        : 0;
@endphp


@if($ratingCount > 0)
    <div class="course-hero-meta">
        <span class="stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($avgRating))
                    ★
                @else
                    ☆
                @endif
            @endfor
        </span>
        <span class="rating-number">{{ $avgRating }}</span>
        </span>
    </div>
@endif

                
                <!-- Right: Course Card - positioned absolutely -->
                <div class="course-sidebar-card">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="sidebar-course-image">
                    <div class="sidebar-content">
                        <div class="price-section">
                            <div class="course-price">৳{{ number_format($course->price) }}</div>
                            @if(isset($course->original_price) && $course->original_price > $course->price)
                                <div class="original-price">৳{{ number_format($course->original_price) }}</div>
                            @endif
                        </div>
                        
                        <!-- Course Stats -->
                        <div class="course-quick-stats">
                            <div class="stat-item">
                                <span class="stat-icon">📊</span>
                                <span>All Levels</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">👥</span>
                                <span>{{ $course->enrolled_count ?? 0 }} Total Enrolled</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">⏱️</span>
                                <span>{{ $course->total_duration }} Hours Duration</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">🎥</span>
                                <span>{{ $course->approx_video_length }} min Avg Video Length</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-icon">📅</span>
                                <span>{{ $course->updated_at->format('M d, Y') }} Last Updated</span>
                            </div>
                        </div>
                        
                        <!-- Course Materials -->
                        <div class="course-materials">
                            <h4>What's Included</h4>
                            <ul class="materials-list">
                                <li>{{ $course->video_count }} video lectures</li>
                                <li>Downloadable resources</li>
                                <li>Full lifetime access</li>
                                <li>Access on mobile and desktop</li>
                                <li>Certificate of completion</li>
                            </ul>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            @auth
                                @if(auth()->user()->enrolledCourses->contains($course->id))
                                    <a href="{{ route('user.course.modules', $course->id) }}" class="btn btn-primary">
                                        Continue Learning
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('cart.add', $course->id) }}" class="cart-form">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                    <form action="{{ route('wishlist.add', $course->id) }}" method="POST" class="wishlist-form">
                                        @csrf
                                        <button type="submit" class="btn btn-wishlist">
                                            Save to Wishlist
                                        </button>
                                    </form>
                                @endif
                            @else
                                @guest
                                    <form method="POST" action="{{ route('cart.guest.add') }}">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                                    </form>
                                @endguest
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Content Section -->
        <div class="course-content-section">
            <div class="course-content-left">
                <!-- Instructor Details -->
                <div class="content-card">
                    <h3><i class="fa-solid fa-chalkboard-teacher"></i> Meet Your Instructor</h3>
                    <div class="instructor-profile">
                        <div class="instructor-avatar-large">
                            {{ strtoupper(substr($course->instructor->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="instructor-info-details">
                            <div class="instructor-name-large">{{ $course->instructor->name ?? 'Unknown' }}</div>
                            
                            @if(!empty($course->instructor->instructor))
                                @if($course->instructor->instructor->area_of_expertise)
                                    <div class="instructor-detail"><strong>Area of Expertise:</strong> {{ $course->instructor->instructor->area_of_expertise }}</div>
                                @endif
                                @if($course->instructor->instructor->qualification)
                                    <div class="instructor-detail"><strong>Qualification:</strong> {{ $course->instructor->instructor->qualification }}</div>
                                @endif
                                @if($course->instructor->instructor->short_bio)
                                    <div class="instructor-detail">{{ $course->instructor->instructor->short_bio }}</div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Prerequisites -->
                <div class="content-card">
                    <h3><i class="fa-solid fa-list-check"></i> Course Prerequisites</h3>
                    <ul class="prerequisites-list">
                        <li>
                            <i class="fa-solid fa-check prereq-icon"></i>
                            <span>{{ $course->prerequisite }}</span>
                        </li>
                    </ul>
                </div>
                <div class="content-card">
    <h3><i class="fa-solid fa-star"></i> Rating</h3>

    @if($course->ratings->count() > 0)
        <ul style="list-style:none; padding:0;">
            @foreach($course->ratings as $rating)
                <li style="padding:12px 0; border-bottom:1px solid #e5e7eb;">
                    
                    <strong>{{ $rating->user->name }}</strong>

                    <div style="color:#ffd700; margin:4px 0;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating->rating)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>

                    @if($rating->review)
                        <p style="margin:4px 0; color:#374151;">
                            {{ $rating->review }}
                        </p>
                    @endif

                    <small style="color:#9ca3af;">
                        {{ $rating->created_at->format('d M Y') }}
                    </small>
                </li>
            @endforeach
        </ul>
    @else
        <p style="color:#6b7280;">No ratings yet.</p>
    @endif
</div>

            </div>

            <!-- Right sidebar space - reserved for positioned sidebar -->
            <div></div>
        </div>
    </main>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });

        // Button loading states
        document.querySelectorAll('.cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('.btn-primary');
                btn.textContent = 'Adding...';
                btn.disabled = true;
            });
        });

        // Cart success message
        @if(session('cart_added'))
        if (confirm("{{ session('cart_added') }} Go to cart?")) {
            window.location.href = "{{ route('cart.all') }}";
        }
        @endif

        // Smooth animations on load
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.content-card, .course-sidebar-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
        <h3>Student Reviews</h3>

@if($course->ratings->count())
    @foreach($course->ratings as $rating)
        <div style="border-bottom:1px solid #ddd; padding:10px 0;">
            <strong>{{ $rating->user->name }}</strong>
            <span>⭐ {{ $rating->rating }}/5</span>

            @if($rating->review)
                <p>{{ $rating->review }}</p>
            @endif
        </div>
    @endforeach
@else
    <p>No reviews yet.</p>
@endif

    </script>
</body>
</html>
