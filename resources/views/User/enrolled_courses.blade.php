<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - EDVANTAGE</title>
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
            background-color: #f9f9f9;
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
      margin: 0 auto;
    }
   
    /* Courses Container - Updated colors */
    .courses-container {
      background: white;
      padding: 2.5rem;
      border-radius: 8px;
      border: 1px solid #dadce0;
    }
    .courses-title {
      font-size: 1.875rem;
      font-weight: 400;
      color: #202124;
      margin-bottom: 2rem;
      text-align: center;
    }
    .course-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 2rem;
      padding: 0;
      list-style-type: none;
    }
    .course-card {
      background: white;
      padding: 0;
      border-radius: 8px;
      border: 1px solid #dadce0;
      transition: all 0.3s ease;
      overflow: hidden;
    }
    .course-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
      border-color: #0E1B33;
    }
    .course-image {
      width: 100%;
      height: 200px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .course-card:hover .course-image {
      transform: scale(1.02);
    }
    .course-content {
      padding: 1.5rem;
    }
    .course-title {
      font-size: 1.25rem;
      font-weight: 500;
      color: #202124;
      text-decoration: none;
      margin-bottom: 0.75rem;
      display: block;
      transition: color 0.3s ease;
      line-height: 1.4;
    }
    .course-title:hover {
      color: #0E1B33;
      text-decoration: none;
    }
    .course-description {
      font-size: 0.9rem;
      color: #5f6368;
      line-height: 1.6;
      margin-bottom: 1.5rem;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    /* Progress Bar - Updated colors */
    .progress-container {
      margin-bottom: 1rem;
    }
    .progress-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 0.5rem;
    }
    .progress-label {
      font-size: 0.8rem;
      color: #5f6368;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .progress-percentage {
      font-size: 0.8rem;
      color: #0E1B33;
      font-weight: 500;
    }
    .progress-bar {
      width: 100%;
      height: 4px;
      background: #f1f3f4;
      border-radius: 2px;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: #0E1B33;
      border-radius: 2px;
      transition: width 0.8s ease;
    }
    /* Course Stats */
    .course-stats {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
      font-size: 0.8rem;
      color: #5f6368;
    }
    .continue-btn {
      width: 100%;
      padding: 0.75rem;
      background: #0E1B33;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: 500;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: block;
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .continue-btn:hover {
      background: #475569;
      box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3);
      text-decoration: none;
      color: white;
    }
    /* Empty State - Updated colors */
    .empty-state {
      grid-column: 1 / -1;
      text-align: center;
      padding: 3rem;
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
    }
    .browse-btn {
      display: inline-block;
      padding: 0.75rem 2rem;
      background: white;
      color: #0E1B33;
      text-decoration: none;
      border: 1px solid #0E1B33;
      border-radius: 4px;
      font-weight: 500;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .browse-btn:hover {
      background: #0E1B33;
      color: white;
      box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3);
    }

.course-instructor {
  font-size: 0.85rem;
  color: #0E1B33;
  font-weight: 500;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.course-instructor i {
  font-size: 0.8rem;
  color: #5f6368;
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
      .courses-container {
        padding: 1.5rem;
      }
      .course-list {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }
    }
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
    .course-card {
      animation: fadeInUp 0.6s ease forwards;
    }
    .course-card:nth-child(1) { animation-delay: 0.1s; }
    .course-card:nth-child(2) { animation-delay: 0.2s; }
    .course-card:nth-child(3) { animation-delay: 0.3s; }
    .course-card:nth-child(4) { animation-delay: 0.4s; }
  </style>
</head>
<body>

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
            <p class="username">{{ explode(' ', $user->name)[0] }}</p>
        </div>
    </header>

  <!-- Main Content -->
  <main class="main-content">
  
    <!-- Courses Container -->
    <div class="courses-container">
      <h2 class="courses-title">My Courses</h2>
      <div class="course-list">
        @forelse ($enrolledCourses as $course)

          @php
            $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
          @endphp
          <div class="course-card">
            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                        
            <div class="course-content">
              <a href="{{ route('user.course.modules', $course->id) }}" class="course-title">
                {{ $course->title }}
              </a>
               
  <div class="course-instructor">
    <span>{{ $course->instructor->name ?? 'Instructor not assigned' }}</span>
  </div>
                            
              <p class="course-description">{{ $course->description }}</p>
                            
            <!-- Progress Bar -->
          <div class="progress-container">
        <div class="progress-header">
        <span class="progress-label">
            Completed {{ $progress['completed_videos'] ?? 0 }} / {{ $progress['total_videos'] ?? 0 }} videos
        </span>
        <span class="progress-percentage">{{ $progress['completion_percentage'] ?? 0 }}%</span>
        </div>
        <div class="progress-bar">
        <div class="progress-fill" style="width: {{ $progress['completion_percentage'] ?? 0 }}%"></div>
        </div>
        </div>

                            
              <!-- Course Stats -->
              <div class="course-stats">
                <span><span class="icon-book"></span> {{ $course->video_count ?? 10 }} lectures</span>
                <span><span class="icon-clock"></span> {{ $course->total_duration ?? '2h' }} h</span>
              </div>
                            
              <a href="{{ route('user.course.modules', $course->id) }}" class="continue-btn">
                Continue Learning
              </a>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <h3>Begin Your Learning Journey</h3>
            <p>Explore our comprehensive course catalog to advance your skills</p>
            <a href="/login" class="browse-btn">Browse Courses</a>
          </div>
        @endforelse
      </div>
    </div>
  </main>

  <script>
    // Smooth progress bar animation
    window.addEventListener('load', function() {
      const progressBars = document.querySelectorAll('.progress-fill');
      progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0%';
        setTimeout(() => {
          bar.style.width = width;
        }, 500);
      });
    });
  </script>
</body>
</html>
