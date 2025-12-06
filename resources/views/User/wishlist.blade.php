<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Wishlist - EDVANTAGE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            background: #f8f9fa;
            color: #202124;
            min-height: 100vh;
        }
        /* Header Styles - Updated to match homepage exactly */
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

        /* Main Content */
        .main-content {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 80px auto 0 auto; /* Adjusted top margin for fixed header */
        }
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .page-title {
            font-size: 2.5rem;
            font-weight: 400;
            color: #202124;
            margin-bottom: 1rem;
        }
        .page-subtitle {
            font-size: 1.1rem;
            color: #5f6368;
            margin-bottom: 2rem;
        }
        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #5f6368;
        }
        .breadcrumb a {
            color: #0E1B33; /* Updated color */
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        /* Wishlist Container */
        .wishlist-container {
            background: white;
            padding: 2.5rem;
            border-radius: 8px;
            border: 1px solid #dadce0;
        }
        .wishlist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e8eaed;
        }
        .wishlist-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #202124;
        }
        .wishlist-count {
            color: #5f6368;
            font-size: 0.9rem;
        }
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Adjusted to match homepage card width */
            gap: 2.5rem 0.5rem; /* Adjusted gap to match homepage */
            padding: 0;
            list-style-type: none;
        }
        /* Course Card Styles - Matching Homepage */
        .wishlist-item { /* Renamed from .course-card in homepage for clarity, but applies same styles */
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #c4c6ca;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 340px; /* Fixed height from homepage */
            width: 280px; /* Fixed width from homepage */
            transition: box-shadow 0.2s;
            position: relative;
            margin: 0 auto; /* Center card in grid cell */
            box-sizing: border-box;
            text-align: left;
        }
        .wishlist-item:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.10);
            border: #0E1B33 1.3px solid;
        }
        .course-image {
            width: 100%;
            height: 160px; /* Adjusted height to match homepage */
            object-fit: cover;
            border-bottom: 1px solid #f1f1f1;
            transition: transform 0.3s ease; /* Keep hover effect */
        }
        .wishlist-item:hover .course-image {
            transform: scale(1.02);
        }
        .course-content {
            padding: 10px 12px 8px 12px; /* Adjusted padding to match homepage */
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .course-title {
            font-size: 1.1rem; /* Adjusted font size */
            font-weight: 700; /* Adjusted font weight */
            color: #1a1a1a; /* Adjusted color */
            line-height: 1.3; /* Adjusted line height */
            min-height: 2.4em; /* Ensure consistent height for titles */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap; /* Truncate long titles */
            margin-bottom: 0.75rem; /* Keep some margin */
        }
        .course-category-badge { /* New style from homepage */
            display: inline-block;
            background: #dcdcdd;
            color: #0E1B33;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 16px;
            padding: 3px 14px;
            margin-bottom: 4px; /* Adjusted margin */
            border: none;
            cursor: default;
        }
        .course-rating { /* New style from homepage */
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 2px;
        }
        .stars { /* New style from homepage */
            color: #f59e0b;
            font-size: 1rem;
            letter-spacing: 1px;
        }
        .rating-number { /* New style from homepage */
            font-size: 0.95rem;
            font-weight: 600;
            color: #f59e0b;
        }
        .rating-count { /* New style from homepage */
            font-size: 0.85rem;
            color: #9ca3af;
        }
        .course-price {
            font-family: 'Montserrat', sans-serif; /* Ensure Montserrat */
            font-size: 1.1rem; /* Adjusted font size */
            font-weight: 700; /* Adjusted font weight */
            color: #1a1a1a; /* Adjusted color */
            margin-top: 0; /* Adjusted margin */
            margin-bottom: 2px; /* Adjusted margin */
        }
        .taka-bold { /* New style from homepage, adapted for dollar sign */
            font-weight: 790;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }
        .course-actions {
            display: flex;
            gap: 6px; /* Adjusted gap to match homepage */
            margin-top: auto; /* Push actions to bottom */
        }
        .btn-details { /* New style for 'View Course' button */
            flex: 1;
            background: #f3f4f6;
            color: #374151;
            text-align: center;
            padding: 6px 4px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: #bebfc0 1px solid;
        }
        .btn-details:hover {
            background: #ffffff;
            border: #bebfc0 1px solid;
        }
        /* Existing btn-primary and btn-secondary styles are fine for 'Add to Cart' */
        .btn-primary {
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33; /* Keep existing primary button style */
            padding: 0.2rem 0.75rem; /* Keep existing primary button padding */
            font-weight: 400; /* Keep existing primary button font weight */
        }
        .btn-primary:hover {
            background: #475569;
            border: 2px solid #475569; /* Match hover border */
        }
        .btn-secondary {
            background: white;
            color: #5f6368;
            border: 1px solid #dadce0;
            padding: 0.75rem 1rem; /* Keep existing secondary button padding */
        }
        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #0E1B33;
            color: #0E1B33;
        }

        .remove-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(234, 67, 53, 0.1);
            color: #ea4335;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.3s ease;
            z-index: 10; /* Ensure it's above other content */
        }
        .remove-btn:hover {
            background: #ea4335;
            color: white;
            transform: scale(1.1);
        }
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-icon {
            font-size: 4rem;
            color: #dadce0;
            margin-bottom: 1rem;
        }
        .empty-state h3 {
            color: #202124;
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 1rem;
        }
        .empty-state p {
            color: #5f6368;
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .browse-btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #0E1B33; /* Updated color */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .browse-btn:hover {
            background: #475569; /* Updated hover color */
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3); /* Updated shadow color */
            text-decoration: none;
            color: white;
        }
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .main-content {
                padding: 2rem 1rem;
            }
            .page-title {
                font-size: 2rem;
            }
            .wishlist-container {
                padding: 1.5rem;
            }
            .wishlist-grid {
                grid-template-columns: 1fr; /* Single column on small screens */
                gap: 1.5rem;
            }
            .wishlist-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .course-actions {
                flex-direction: column;
            }
        }
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .wishlist-item {
            animation: fadeInUp 0.6s ease forwards;
        }
        .wishlist-item:nth-child(1) { animation-delay: 0.1s; }
        .wishlist-item:nth-child(2) { animation-delay: 0.2s; }
        .wishlist-item:nth-child(3) { animation-delay: 0.3s; }
        .wishlist-item:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
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
                        <a href="/purchase_history"><i class="fa-solid fa-receipt icon"></i> Purchase History</a>
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
            @auth
            <p class="username">{{ explode(' ', Auth::user()->name)[0] }}</p>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/login">Home</a>
            <span>›</span>
            <span>Wishlist</span>
        </div>
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">My Wishlist</h1>
            <p class="page-subtitle">Save courses for later and never miss out on learning opportunities</p>
        </div>
        <!-- Wishlist Container -->
        <div class="wishlist-container">
            @if($wishlistItems->count())
                <div class="wishlist-header">
                    <h2 class="wishlist-title">Saved Courses</h2>
                    <span class="wishlist-count">{{ $wishlistItems->count() }} {{ Str::plural('course', $wishlistItems->count()) }}</span>
                </div>
                <div class="wishlist-grid">
                    @foreach ($wishlistItems as $item)
                        <div class="wishlist-item">
                            <!-- Remove Button -->
                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn" title="Remove from wishlist">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </form>
                            @if($item->course->image)
                                <img src="{{ asset('storage/' . $item->course->image) }}" alt="{{ $item->course->title }}" class="course-image">
                            @else
                                <img src="/placeholder.svg?height=160&width=280" alt="{{ $item->course->title }}" class="course-image">
                            @endif
                                        
                            <div class="course-content">
                                <h3 class="course-title">{{ $item->course->title }}</h3>
                                @if(isset($item->course->category))
                                    <span class="course-category-badge">{{ $item->course->category }}</span>
                                @else
                                    <span class="course-category-badge">General</span>
                                @endif
                                <div class="course-rating">
                                    <span class="stars">★★★★★</span>
                                    <span class="rating-number">4.8</span>
                                    <span class="rating-count">(120)</span>
                                </div>
                                <div class="course-price">
                                    <span class="taka-bold">$</span> {{ number_format($item->course->price, 0) }}
                                </div>
                                            
                                <div class="course-actions">
                                    <a href="{{ route('courses.details', $item->course->id) }}" class="btn-details">
                                        Details
                                    </a>
                                    <form action="{{ route('cart.add', $item->course->id) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-heart"></i></div>
                    <h3>Your wishlist is empty</h3>
                    <p>Start building your learning journey by adding courses to your wishlist. You can save courses for later and get notified about price changes.</p>
                    <a href="{{ route('login') }}" class="browse-btn">Browse Courses</a>
                </div>
            @endif
        </div>
    </main>
    <script>
        // Smooth animations
        window.addEventListener('load', function() {
            const items = document.querySelectorAll('.wishlist-item');
            items.forEach((item, index) => {
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
        // Confirm removal
        document.querySelectorAll('.remove-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to remove this course from your wishlist?')) {
                    e.preventDefault();
                }
            });
        });
        @if(session('cart_added'))
            if (confirm("{{ session('cart_added') }} Go to cart?")) {
                window.location.href = "{{ route('cart.all') }}";
            }
        @endif
    </script>
</body>
</html>
