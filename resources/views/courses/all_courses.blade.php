<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Courses - EDVANTAGE</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --cream: #FFF2E0;
      --light-purple: #CCD3F3;
      --mid-purple: #B1B9E8;
      --deep-purple: #949CDC;
      --action-purple: #6A5ACD;
      --action-purple-hover: #5849b4;
      --text-dark: #2F2F2F;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: white;
      color: var(--text-dark);
      min-height: 100vh;
    }

    /* Header */
    .header {
      background:#f8f9ff;
      color: white;
      padding: 15px 0;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .header-content {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #667eea;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header-search {
      flex: 1;
      max-width: 500px;
      margin: 0 40px;
      position: relative;
    }

    .header-search input {
      width: 100%;
      padding: 12px 50px 12px 20px;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      outline: none;
    }

    .header-search button {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #666;
      cursor: pointer;
      font-size: 18px;
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .cart-wishlist {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .header-btn {
      position: relative;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.3);
      color: 
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .header-btn:hover {
      background: rgba(255,255,255,0.2);
      color: #6366f1;;
    }

    .badge {
      position: absolute;
      top: -8px;
      right: -8px;
      background: #e74c3c;
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      font-size: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      transform: translate(30%, -30%);
    }

    .user-profile {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--action-purple);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
    }

    /* Hero Banner */
    .hero-banner {
      height: 300px;
      background: url('https://www.topuniversities.com/sites/default/files/styles/articles_inline/public/articles/lead-images/pexels-yankrukov-8199555.jpg.webp');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero-content {
      z-index: 2;
      max-width: 800px;
      padding: 40px 20px;
      position: relative;
    }

    .hero-title {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 15px;
      text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
    }

    .hero-subtitle {
      font-size: 1.5rem;
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
    }

    .hero-stats {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ffd700;
      text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
    }

    /* Main Container */
    .main-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 30px 20px;
      display: grid;
      grid-template-columns: 280px 1fr;
      gap: 30px;
    }

    /* Sidebar - Categories */
    .sidebar {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      height: fit-content;
      position: sticky;
      top: 30px;
      border: 1px solid #f0f0f0;
    }

    .sidebar h3 {
      font-size: 18px;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 2px solid #f0f0f0;
    }

    .category-list {
      list-style: none;
    }

    .category-item {
      margin-bottom: 8px;
    }

    .category-link {
      display: block;
      padding: 12px 15px;
      color: var(--text-dark);
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.3s ease;
      font-weight: 500;
      font-size: 14px;
    }

    .category-link:hover,
    .category-link.active {
      background: var(--action-purple);
      color: white;
      transform: translateX(5px);
    }

    /* Main Content */
    .main-content {
      background: white;
    }

    .content-header {
      margin-bottom: 30px;
    }

    .search-section {
      background: linear-gradient(#667eea);
      border-radius: 15px;
      padding: 30px;
      text-align: left;
      margin-bottom: 30px;
    }

    .main-search {
      position: relative;
      max-width: 600px;
      margin: 0 auto;
    }

    .main-search input {
      width: 100%;
      padding: 15px 60px 15px 25px;
      border: none;
      border-radius: 50px;
      font-size: 16px;
      outline: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .main-search button {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: #3498db;
      border: none;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 16px;
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

    .filter-dropdown {
      padding: 10px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      background: white;
    }

    .alert {
      background-color: #d4edda;
      color: #155724;
      padding: 15px;
      border: 1px solid #c3e6cb;
      border-radius: 12px;
      text-align: center;
      margin-bottom: 30px;
    }

    /* Course Grid */
    .courses-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
    }

    .course-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      border: 1px solid #f0f0f0;
    }

    .course-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .course-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .course-content {
      padding: 20px;
    }

    .course-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--text-dark);
      margin-bottom: 10px;
      line-height: 1.4;
    }

    .course-description {
      color: #666;
      font-size: 14px;
      line-height: 1.5;
      margin-bottom: 15px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .course-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      margin-top: 10px;
    }

    .view-details-btn {
      padding: 8px 12px;
      font-size: 13px;
      font-weight: 600;
      color: white;
      background: var(--action-purple);
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
      white-space: nowrap;
      transition: all 0.3s ease;
    }

    .view-details-btn:hover {
      background: var(--action-purple-hover);
      transform: translateY(-1px);
    }

    .icon-btn-group {
      display: flex;
      gap: 10px;
    }

    .icon-btn-form {
      margin: 0;
    }

    .icon-btn {
      background-color: var(--action-purple);
      border: none;
      color: white;
      padding: 10px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
      cursor: pointer;
      font-size: 16px;
    }

    .icon-btn:hover {
      background-color: var(--action-purple-hover);
      transform: translateY(-1px);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      color: #666;
      grid-column: 1 / -1;
    }

    .empty-state i {
      font-size: 64px;
      color: #ddd;
      margin-bottom: 20px;
    }

    .empty-state h3 {
      font-size: 24px;
      margin-bottom: 10px;
      color: var(--text-dark);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
      .courses-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 1024px) {
      .main-container {
        grid-template-columns: 250px 1fr;
        gap: 20px;
      }

      .header-search {
        max-width: 400px;
        margin: 0 20px;
      }
    }

    @media (max-width: 768px) {
      .main-container {
        grid-template-columns: 1fr;
        gap: 20px;
        padding: 20px 15px;
      }

      .sidebar {
        position: static;
        order: 2;
      }

      .main-content {
        order: 1;
      }

      .courses-grid {
        grid-template-columns: 1fr;
      }

      .header-content {
        flex-direction: column;
        gap: 15px;
      }

      .header-search {
        margin: 0;
        max-width: 100%;
      }

      .hero-title {
        font-size: 2rem;
      }

      .hero-subtitle {
        font-size: 1.2rem;
      }

      .hero-stats {
        font-size: 2rem;
      }
    }

    @media (max-width: 480px) {
      .cart-wishlist {
        flex-direction: column;
        gap: 10px;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <div class="header-content">
      <a href="/" class="logo">
        EDVANTAGE
      </a>
      <div class="header-actions">
        <div class="cart-wishlist">
          <a href="{{ route('wishlist.all') }}" class="header-btn">
            <i class="fas fa-heart"></i>
            <span class="badge">0</span>
          </a>
          <a href="{{ route('cart.all') }}" class="header-btn">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge">0</span>
          </a>
        </div>
        <div class="user-profile">
          <i class="fas fa-user"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Banner -->
  <div class="hero-banner">
    <div class="hero-content">
      <h1 class="hero-title">Transform Your Future</h1>
      <p class="hero-subtitle">Learn from Industry Experts</p>
      <div class="hero-stats">{{ $courses->count() }}+ Courses Available</div>
    </div>
  </div>

  <!-- Main Container -->
  <div class="main-container">
    <!-- Sidebar - Categories -->
    <div class="sidebar">
      <h3>Course Categories</h3>
       @if($courses->isEmpty())
          <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <h3>No courses available</h3>
            <p>Check back later for new courses!</p>
          </div>
        @else
          @foreach($uniqueCategories as $course)
          
           <ul class="category-list">
           <li class="category-item">
              <a href="#" class="category-link">{{$course}}</a>
            </li>
          @endforeach
        @endif
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      @if(session('success'))
        <div class="alert">
          {{ session('success') }}
        </div>
      @endif

      <!-- Search Section -->
      <div class="search-section">
        <div class="main-search">
          <input type="text" placeholder="Search the course or skills you want to learn">
          <button type="button">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      <!-- Section Header -->
      <div class="section-header">
        <h2 class="section-title">Popular Courses</h2>
        <select class="filter-dropdown">
          <option>Filter Courses</option>
          <option>Newest First</option>
          <option>Price: Low to High</option>
          <option>Price: High to Low</option>
          <option>Most Popular</option>
        </select>
      </div>

      <!-- Courses Grid -->
      <div class="courses-grid">
        @if($courses->isEmpty())
          <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <h3>No courses available</h3>
            <p>Check back later for new courses!</p>
          </div>
        @else
          @foreach($courses as $course)
            <div class="course-card">
              <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
              <div class="course-content">
                <h3 class="course-title">{{ $course->title }}</h3>
                <p class="course-description">{{ $course->description }}</p>
                <div class="course-actions">
                  <a href="{{ route('courses.details', $course->id) }}" class="view-details-btn">
                    <i class="fas fa-info-circle"></i>
                    View
                  </a>

                  <div class="icon-btn-group">
                    <form action="{{ route('wishlist.add', $course->id) }}" method="POST" class="icon-btn-form">
                      @csrf
                      <button type="submit" class="icon-btn" title="Add to Wishlist">
                        <i class="fas fa-heart"></i>
                      </button>
                    </form>

                    <form action="{{ route('cart.add', $course->id) }}" method="POST" class="icon-btn-form">
                      @csrf
                      <button type="submit" class="icon-btn" title="Add to Cart">
                        <i class="fas fa-shopping-cart"></i>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>

  @if(session('cart_added'))
    <script>
      if (confirm("{{ session('cart_added') }} Go to cart?")) {
        window.location.href = "{{ route('cart.all') }}";
      }
    </script>
  @endif

  <script>
    // Category filtering
    document.querySelectorAll('.category-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remove active class from all links
        document.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
        
        // Add active class to clicked link
        this.classList.add('active');
        
        // Here you can add filtering logic
        console.log('Category selected:', this.textContent);
      });
    });

    // Search functionality (visual feedback)
    document.querySelectorAll('input[type="text"]').forEach(input => {
      input.addEventListener('focus', function() {
        this.style.transform = 'scale(1.02)';
        this.style.boxShadow = '0 4px 15px rgba(106, 90, 205, 0.2)';
      });
      
      input.addEventListener('blur', function() {
        this.style.transform = 'scale(1)';
        this.style.boxShadow = 'none';
      });
    });

    // Filter dropdown
    document.querySelector('.filter-dropdown').addEventListener('change', function() {
      console.log('Filter selected:', this.value);
      // Add filtering logic here
    });
  </script>

</body>
</html>
</merged_code>