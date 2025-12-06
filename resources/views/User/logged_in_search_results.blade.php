<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - EDVANTAGE</title>
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
            background: #f8fafc;
        }
        /* Header Styles */
        .header {
            background: #fff;
            backdrop-filter: blur(10px);
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            color: #8b8b8d;
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
            border: 2px solid #475569;
        }
        .btn.btn-cart {
            background: #0E1B33;
            color: white;
            border: 4px solid #0E1B33; /* Increased border size */
        }
        .btn.btn-cart:hover {
            background: #475569;
            border:4px solid #475569;
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
        .search-form {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            margin-right: 1rem;
            position: relative;
        }
        .search-input {
            width: 400px;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 24px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            outline: none;
            border-color: #0E1B33;
            box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
        }
        .username {
            margin-left: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        
        /* Main Content */
        .main-content {
            margin-top: 120px;
            padding: 2rem 0;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        /* Search Results Header */
        .search-header {
            margin-bottom: 2rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .search-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        .search-subtitle {
            font-size: 1.1rem;
            color: #64748b;
        }
        .search-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
        .results-count {
            font-size: 0.95rem;
            color: #6b7280;
        }
        .filter-section {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        .filter-dropdown {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
        }
        
        /* No Results */
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
        }
        .no-results i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }
        .no-results h3 {
            font-size: 1.5rem;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .no-results p {
            color: #6b7280;
            margin-bottom: 2rem;
        }
        
        /* Course Grid - Matching first blade exactly */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2.5rem 0.5rem;
            margin-top: 2rem;
        }
        .course-card {
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #c4c6ca;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 340px;
            width: 280px;
            transition: box-shadow 0.2s;
            position: relative;
            margin: 0 auto;
            box-sizing: border-box;
            text-align: left;
        }
        .course-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.10);
            border: #0E1B33 1.3px solid;
        }
        .course-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-bottom: 1px solid #f1f1f1;
        }
        .course-content {
            padding: 10px 12px 8px 12px;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .course-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
            min-height: 2.4em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .course-category {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .course-category-badge {
            display: inline-block;
            background: #dcdcdd;
            color: #0E1B33;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 16px;
            padding: 3px 14px;
            margin: 4px -10 6px 0;
            border: none;
            cursor: default;
        }
        .course-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 2px;
        }
        .stars {
            color: #f59e0b;
            font-size: 1rem;
            letter-spacing: 1px;
        }
        .rating-number {
            font-size: 0.95rem;
            font-weight: 600;
            color: #f59e0b;
        }
        .rating-count {
            font-size: 0.85rem;
            color: #9ca3af;
        }
        .course-price {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 0;
            margin-bottom: 2px;
        }
        .course-actions {
            display: flex;
            gap: 6px;
            margin-top: auto;
        }
        .taka-bold {
            font-weight: 790;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }
        .btn-details {
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
        
        /* Search Highlights */
        .highlight {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }
        
        /* Back to Home */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #0E1B33;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 1rem;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #475569;
        }
        
        /* Section Title - Matching first blade */
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-title h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        .section-title p {
            font-size: 1.1rem;
            color: #64748b;
        }
        
        /* Responsive Design - Matching first blade */
        @media (max-width: 1200px) {
            .courses-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .search-input {
                width: 250px;
            }
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .search-stats {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
        @media (max-width: 480px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }
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
                       value="{{ $searchTerm ?? '' }}"
                       autocomplete="off">
            </form>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    @if(auth()->user() && auth()->user()->role == 3)
                        <li><a href="/instructor_homepage">Instructor</a></li>
                    @endif
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
                        @if(auth()->user() && auth()->user()->role!=3)
                        <a href="{{ route('ins.signup') }}">Register as instructor</a>
                        @endif
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
            <p class="username">{{ explode(' ', $user->name)[0] ?? '' }}</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <!-- Back to Home Link -->
            <a href="/" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Home
            </a>
            
            <!-- Search Results Header -->
            <div class="search-header">
                <h1 class="search-title">
                    @if(isset($searchTerm) && $searchTerm)
                        Search Results for "<span class="highlight">{{ $searchTerm }}</span>"
                    @else
                        All Courses
                    @endif
                </h1>
                <p class="search-subtitle">
                    @if(isset($searchTerm) && $searchTerm)
                        Discover courses that match your search criteria
                    @else
                        Browse our complete course catalog
                    @endif
                </p>
                
                <div class="search-stats">
                    <div class="results-count">
                        {{ $courses->total() }} course{{ $courses->total() != 1 ? 's' : '' }} found
                        @if(isset($searchTerm) && $searchTerm)
                            for "{{ $searchTerm }}"
                        @endif
                    </div>
                    <div class="filter-section">
                        <form method="GET" action="{{ route('courses.search') }}">
                            <input type="hidden" name="search" value="{{ $searchTerm ?? '' }}">
                            <select class="filter-dropdown" name="sort" onchange="this.form.submit()">
                                <option value="">Sort By</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            @if($courses->count() > 0)
                <div class="section-title">
                    <h2>
                        @if(isset($searchTerm) && $searchTerm)
                            Search Results
                        @else
                            Featured Courses
                        @endif
                    </h2>
                    <p>
                        @if(isset($searchTerm) && $searchTerm)
                            Courses matching your search criteria
                        @else
                            Discover our most popular courses designed to help you achieve your learning goals
                        @endif
                    </p>
                </div>
                
                <div class="courses-grid">
                    @foreach($courses as $course)
                        @if(!auth()->user()->enrolledCourses->contains($course->id))
                        <div class="course-card">
                            <!-- Course Image -->
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                            @else
                                <img src="https://via.placeholder.com/300x140?text=Course+Image" alt="{{ $course->title }}" class="course-image">
                            @endif
                            
                            <!-- Course Content -->
                            <div class="course-content">
                                <h3 class="course-title">{{ $course->title }}</h3>
                                
                                @if(isset($course->category))
                                    <span class="course-category-badge">{{ $course->category }}</span>
                                @endif
                                
                                
                                
                                <div class="course-price">
                                    <span class="taka-bold">৳</span> {{ number_format($course->price ?? 0, 0) }}
                                </div>
                                
                                <div class="course-actions">
                                    <a href="{{ route('courses.details', $course->id) }}" class="btn-details">
                                        Details
                                    </a>
                                    <form method="POST" action="{{ route('cart.add', $course->id) }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-cart">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($courses->hasPages())
                    <div class="pagination-container">
                        {{ $courses->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- No Results -->
                <div class="no-results">
                    <i class="fa-solid fa-search"></i>
                    <h3>No courses found</h3>
                    <p>
                        @if(isset($searchTerm) && $searchTerm)
                            We couldn't find any courses matching "{{ $searchTerm }}". Try different keywords or browse our categories.
                        @else
                            No courses are currently available.
                        @endif
                    </p>
                    <a href="/" class="btn btn-primary">Browse All Courses</a>
                </div>
            @endif
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const searchForm = document.querySelector('.search-form');
            
            // Submit on Enter key
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (this.value.trim().length > 0) {
                        searchForm.submit();
                    }
                }
            });
            
            // Focus search input if coming from search
            if (searchInput.value) {
                searchInput.focus();
            }
        });

        // Session-based alerts for cart and wishlist
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
    </script>
</body>
</html>