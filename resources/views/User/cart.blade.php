<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - EDVANTAGE</title>
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
            padding: 1.5rem 2rem;
            max-width: 1200px;
            margin: 80px auto 0 auto; /* Adjusted top margin for fixed header */
        }
        .page-header {
            text-align: center;
            margin-bottom: 1.5rem;
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
        .auth-buttons {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            gap: 1rem;
            margin-left: 6rem;
            margin-right: -2rem;
            align-items: center;
        }
        .btn-login {
            background: #f9f9f9;
            color: #0E1B33;
            border: 2px solid #0E1B33 !important; /* Added !important */
            padding: 0.4rem 0.75rem !important;
        }
        .btn-login:hover {
            background: #dcdcdd;
            color: #0E1B33;
        } 
        .btn-signup {
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33 !important; /* Added !important */
            padding: 0.4rem 0.75rem !important; 
        }
        .btn-signup:hover {
            background: #475569;
            border: 2px solid #475569 !important;
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
        /* Cart Layout */
        .cart-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            align-items: start;
        }
        .cart-container {
            background: white;
            padding: 2.5rem;
            border-radius: 8px;
            border: 1px solid #dadce0;
        }
        .summary-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #dadce0;
            position: sticky;
            top: 120px;
        }
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e8eaed;
        }
        .cart-title {
            font-size: 1.5rem;
            font-weight: 500;
            color: #202124;
        }
        .cart-count {
            color: #5f6368;
            font-size: 0.9rem;
        }
        /* Cart Items */
        .cart-items {
            list-style: none;
            padding: 0;
        }
        .cart-item {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid #f1f3f4;
            transition: all 0.3s ease;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item:hover {
            background: #f8f9fa;
            margin: 0 -1rem;
            padding-left: 1rem;
            padding-right: 1rem;
            border-radius: 8px;
        }
        .cart-img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
        }
        .cart-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .course-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #202124;
            line-height: 1.4;
        }
        .course-description {
            font-size: 0.9rem;
            color: #5f6368;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .course-price {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0E1B33; /* Updated color */
            margin-top: auto;
        }

        .taka-symbol { /* New style for the Taka symbol */
            font-weight: 700;
            font-size: 1.5em; /* Slightly larger than parent font size */
        }

        .remove-btn {
            background: none;
            border: none;
            color: #ea4335;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0.25rem 0;
            transition: all 0.3s ease;
            align-self: flex-start;
        }
        .remove-btn:hover {
            text-decoration: underline;
            color: #d33b2c;
        }
        /* Summary Section */
        .summary-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: #202124;
            margin-bottom: 1.5rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f4;
        }
        .summary-row:last-of-type {
            border-bottom: 2px solid #e8eaed;
            font-weight: 600;
            font-size: 1.1rem;
            color: #202124;
            margin-bottom: 1.5rem;
        }
        .summary-label {
            color: #5f6368;
        }
        .summary-value {
            color: #202124;
            font-weight: 500;
        }
      .checkout-btn {
  font-size: 17px;
  padding: 10px 27px;
  display: block;
  margin: 20px auto;
  text-align: center;
  background-color: #0E1B33; /* Bootstrap primary color */
  color: white;
  border: none;
  border-radius: 0.375rem; /* same as Bootstrap .btn rounded */
  text-decoration: none;
  cursor: pointer;
}

.checkout-btn:hover {
  background-color: #0b5ed7; /* Bootstrap primary hover color */
  color: white;
}

        .checkout-btn:hover {
            background: #475569; /* Updated hover color */
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3); /* Updated shadow color */
        }
        .continue-shopping {
            display: block;
            text-align: center;
            color: #0E1B33; /* Updated color */
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        .continue-shopping:hover {
            text-decoration: underline;
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
            border-radius: 6px;
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
                padding: 1rem 1rem;
            }
            .page-title {
                font-size: 2rem;
            }
            .cart-wrapper {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .cart-container,
            .summary-container {
                padding: 1.5rem;
            }
            .cart-item {
                flex-direction: column;
                gap: 1rem;
            }
            .cart-img {
                width: 100%;
                height: 150px;
            }
            .summary-container {
                position: static;
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
        .cart-item {
            animation: fadeInUp 0.6s ease forwards;
        }
        .cart-item:nth-child(1) { animation-delay: 0.1s; }
        .cart-item:nth-child(2) { animation-delay: 0.2s; }
        .cart-item:nth-child(3) { animation-delay: 0.3s; }
        .cart-item:nth-child(4) { animation-delay: 0.4s; }
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

            @else
            <div class="auth-buttons">
                <a href="/login" class="btn btn-login" >Login</a>
                <a href="/register" class="btn btn-signup">SignUp</a>
            </div>
            @endauth
            @auth
            <!-- Hidden logout form -->
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
            @endauth
        </div>
    </header>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/login">Home</a>
            <span>›</span>
            <span>Shopping Cart</span>
        </div>
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Shopping Cart</h1>
            <p class="page-subtitle">Review your selected courses before checkout</p>
        </div>
        @if($cartItems->count())
            <div class="cart-wrapper">
                <!-- Cart Items -->
                <div class="cart-container">
                    <div class="cart-header">
                        <h2 class="cart-title">Cart Items</h2>
                        <span class="cart-count">{{ $cartItems->count() }} {{ Str::plural('item', $cartItems->count()) }}</span>
                    </div>
                    <ul class="cart-items">
                        @if(isset($isGuest) && $isGuest)
                            @foreach ($cartItems as $course)
                                <li class="cart-item">
                                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="cart-img">
                                    <div class="cart-info">
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <p class="course-description">{{ $course->description }}</p>

                                        <div class="course-price"><span class="taka-symbol">৳</span>{{ number_format($course->price, 2) }}</div>
                                        <!-- Remove button for guest cart (optional, needs extra logic) -->
                    <form action="{{ route('guest.cart.remove') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="remove-btn">Remove</button>
                </form>





                                    </div>
                                </li>
                            @endforeach
                        @else
                            @foreach ($cartItems as $item)
                                <li class="cart-item">
                                    <img src="{{ asset('storage/' . $item->course->image) }}" alt="{{ $item->course->title }}" class="cart-img">
                                    <div class="cart-info">
                                        <h3 class="course-title">{{ $item->course->title }}</h3>
                                        <p class="course-description">{{ $item->course->description }}</p>

                                        <div class="course-price"><span class="taka-symbol">৳</span>{{ number_format($item->course->price, 2) }}</div>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="remove-btn">Remove</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <!-- Order Summary -->
                <div class="summary-container">
                    <h3 class="summary-title">Order Summary</h3>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal ({{ $cartItems->count() }} items)</span>
                        <span class="summary-value">
                            @if(isset($isGuest) && $isGuest)
                                <span class="taka-symbol">৳</span>{{ number_format($cartItems->sum('price'), 2) }}
                            @else
                                <span class="taka-symbol">৳</span>{{ number_format($cartItems->sum(fn($item) => $item->course->price), 2) }}
                            @endif
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Taxes</span>
                        <span class="summary-value"><span class="taka-symbol">৳</span>0.00</span>

                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Total</span>
                        <span class="summary-value">
                            @if(isset($isGuest) && $isGuest)
                                <span class="taka-symbol">৳</span>{{ number_format($cartItems->sum('price'), 2) }}
                            @else
                                <span class="taka-symbol">৳</span>{{ number_format($cartItems->sum(fn($item) => $item->course->price), 2) }}

                            @endif
                        </span>
                    </div>
                    @if(isset($isGuest) && $isGuest)
                        <a href="{{ route('login') }}" class="checkout-btn" >Proceed to Checkout</a>
                        <a href="/" class="continue-shopping">Continue Shopping</a>
                    @else
                        <form method="GET" action="{{ route('checkout') }}">
                            <input type="hidden" name="amount" value="{{ $cartItems->sum(fn($item) => $item->course->price) }}">
                             <button type="submit" class="btn btn-primary" style="font-size: 15px; padding: 12px 30px; display: block; margin: 20px auto;">
  Proceed to Checkout
</button>
                            <a href="/login" class="continue-shopping">Continue Shopping</a>
                        </form>
                    @endif

                </div>
            </div>
        @else
            <div class="cart-container">
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa-solid fa-shopping-bag"></i></div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added any courses to your cart yet. Start exploring our course catalog and add courses you'd like to learn.</p>
                    <a href="{{ route('login') }}" class="browse-btn">Browse Courses</a>
                </div>
            </div>
        @endif
    </main>
    <script>
        // Smooth animations
        window.addEventListener('load', function() {
            const items = document.querySelectorAll('.cart-item');
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
                if (!confirm('Are you sure you want to remove this course from your cart?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

