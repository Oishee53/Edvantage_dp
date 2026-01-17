<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDVANTAGE - Your Virtual Classroom Redefined</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
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
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            margin-right: 0.25rem;
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
        .auth-buttons {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            gap: 1rem;
            margin-left: 6rem;
            margin-right: -2rem;
            align-items: center;
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
            border:2px solid #475569;
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
        .category-bar {
            background: #0E1B33;
            backdrop-filter: blur(10px);
            padding: 0.25rem 0 0.25rem 0;
            position: fixed;
            width: 100%;
            top: 56px;
            z-index: 999;
            border: none;
            box-shadow: 0 12px 32px 0 rgba(0,0,0,0.22), 0 2px 8px 0 rgba(0,0,0,0.12);
        }
        .category-link {
            font-family: 'Montserrat', sans-serif;
            color: white ;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.3s ease;
            white-space: nowrap;
            padding: 0.25rem 0;
            padding-left: 1.5rem;
            margin-right: 1rem;
            margin-left: 1rem;
        }
        .category-link:hover {
            color: #8b8b8d;
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
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-top: 88px; /* Updated to match homepage */
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                linear-gradient(135deg, rgba(32,42,68,0.75) 0%, rgba(102,126,234,0.5) 100%),
                url('/image/hero.png') center center/cover no-repeat;
            opacity: 1;
            z-index: 1;
        }
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .hero h1 {
            font-family:'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .section-title {
      font-size: 28px;
      font-weight: 600;
      color: var(--text-dark);
    }

    
        /* Courses Section */
        .courses-section {
            padding: 5rem 0;
            background: #f8fafc;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
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
        #loadMoreBtn {
            padding: 0.5rem 1rem;
            font-size: 1.2rem;
            border-radius: 5px;
            font-weight: 500;
        }
        /* Responsive Design */
        @media (max-width: 1200px) {
            .courses-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
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
    <!-- Place the category bar immediately after the header -->
    <div class="category-bar" style="top:56px; font-weight: 50;">
       @foreach($uniqueCategories as $category)
    <a href="{{ route('guest.courses.search', ['search' => $category]) }}"
   class="category-link">
    {{ $category }}
</a>

@endforeach

    </div>
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="/image/Edvantage.png" alt="EDVANTAGE Logo" style="height:40px; vertical-align:middle;">
            </a>
            <form class="search-form" action="{{ route('guest.courses.search') }}" method="GET">
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
            <div class="auth-buttons">
                <a href="/login" class="btn btn-outline">Login</a>
                <a href="/register" class="btn btn-primary">SignUp</a>
            </div>
        </div>
    </header>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to Edvantage</h1>
            <p>Your virtual classroom redefined. Learn from the best instructors, explore trending courses, and unlock your potential.</p>
            <div class="hero-buttons">
                <a href="/register" class="btn btn-primary btn-hero">Get Started for FREE</a>
                <a href="#courses" class="btn btn-secondary btn-hero">Learn More</a>
            </div>
        </div>
    </section>
    <!-- Section Header -->
      <div class="section-header">
        <h2 class="section-title"></h2>
        
      </div>
    <!-- Courses Section -->
    <section class="courses-section" id="courses">
        <div class="container">
            <div class="section-title">
                <h2>Featured Courses</h2>
                <p>Discover our most popular courses designed to help you achieve your learning goals</p>
            </div>
            <div class="courses-grid" id="coursesGrid">
                @foreach($courses as $index => $course)
                <div class="course-card" style="{{ $index >= 4 ? 'display:none;' : '' }}">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                    @else
                        <img src="https://via.placeholder.com/300x140?text=Course+Image" alt="{{ $course->title }}" class="course-image">
                    @endif
                   <div class="course-content">
    <h3 class="course-title">{{ $course->title }}</h3>

    @if(isset($course->category))
        <span class="course-category-badge">{{ $course->category }}</span>
    @endif

    {{-- ⭐ STEP 9: Average Rating --}}
    @if($course->ratings->count())
        <div class="course-rating">
            <span class="stars">
                @for($i = 1; $i <= floor($course->averageRating()); $i++)
                    ★
                @endfor
            </span>
            <span class="rating-number">
                {{ $course->averageRating() }}
            </span>
            <span class="rating-count">
                ({{ $course->ratings->count() }})
            </span>
        </div>
    @endif

    <div class="course-price">
        <span class="taka-bold">৳</span> {{ number_format($course->price ?? 0, 0) }}
    </div>

                        <div class="course-actions">
                            <a href="{{ route('courses.details', $course->id) }}" class="btn-details">
                                Details
                            </a>
                            @guest
                            <form method="POST" action="{{ route('cart.guest.add') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-cart">Add to Cart</button>
                            </form>
                            @endguest
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($courses->count() > 4)
                <div style="text-align:center; margin-top:2rem;">
                    <button id="loadMoreBtn" class="btn btn-primary">Load More</button>
                </div>
            @endif
        </div>
    </section>
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
});

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        // Header background on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
        // Load More functionality
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const cards = document.querySelectorAll('#coursesGrid .course-card');
        let visible = 4;
        const increment = 4;
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                let shown = 0;
                for (let i = visible; i < cards.length && shown < increment; i++, shown++) {
                    cards[i].style.display = '';
                }
                visible += increment;
                if (visible >= cards.length) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>