@extends('layouts.app')

@if(session('error'))
    <div class="alert alert-danger clean-alert">
        <i class="fas fa-exclamation-triangle"></i>
        <span>{{ session('error') }}</span>
        <button class="alert-close">&times;</button>
    </div>
@endif

@section('content')

<!-- Main Navigation Header -->
<header class="main-header">
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

<div class="clean-dashboard">
    {{-- Welcome Header Section --}}
    <header class="clean-header">
        <div class="header-container">
            <div class="header-content">
                <div class="greeting-section">
                    <h1 class="main-title">
                        <span class="welcome-text">Welcome back,</span>
                        <span class="user-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </h1>
                    <p class="subtitle">Track your learning journey</p>
                </div>
            </div>
        </div>
    </header>

    <div class="main-content">
        {{-- Stats Overview --}}
        <section class="stats-section">
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ count($courseProgress) }}</div>
                        <div class="stat-label">Enrolled Courses</div>
                        <div class="stat-description">Currently learning</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ collect($courseProgress)->where('completion_percentage', 100)->count() }}</div>
                        <div class="stat-label">Completed</div>
                        <div class="stat-description">Successfully finished</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ collect($courseProgress)->where('completion_percentage', 100)->where('average_percentage', '>=', 70)->count() }}</div>
                        <div class="stat-label">Certificates</div>
                        <div class="stat-description">Achievements earned</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-content">
                        @php
                            $totalProgress = collect($courseProgress)->avg('completion_percentage');
                        @endphp
                        <div class="stat-number">{{ round($totalProgress) }}%</div>
                        <div class="stat-label">Average Progress</div>
                        <div class="stat-description">Overall performance</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Courses Section --}}
        <section class="courses-section">
            <div class="section-header">
                <h2 class="section-title">
                    Your Courses
                </h2>
            </div>

            <div class="courses-grid">
                @forelse($courseProgress as $progress)
                    <div class="course-card">
                        <div class="course-header">
                            <div class="course-progress">
                                <div class="progress-circle">
                                    <svg width="60" height="60" class="progress-ring">
                                        <circle cx="30" cy="30" r="26" 
                                                fill="none" 
                                                stroke="#f1f5f9" 
                                                stroke-width="4"/>
                                        <circle cx="30" cy="30" r="26"
                                                fill="none"
                                                stroke="#0E1B33"
                                                stroke-width="4"
                                                stroke-linecap="round"
                                                stroke-dasharray="163"
                                                stroke-dashoffset="calc(163 - (163 * {{ $progress['completion_percentage'] }}) / 100)"
                                                transform="rotate(-90 30 30)"/>
                                    </svg>
                                    <div class="progress-text">{{ $progress['completion_percentage'] }}%</div>
                                </div>
                            </div>

                            @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                                <div class="completion-badge">
                                    <i class="fas fa-check-circle"></i>
                                    Completed
                                </div>
                            @endif
                        </div>

                        <div class="course-body">
                            <h3 class="course-title">{{ $progress['course_name'] }}</h3>
                            
                            <div class="course-stats">
                                <div class="stat">
                                    <i class="fas fa-play-circle"></i>
                                    <span>{{ $progress['completed_videos'] }}/{{ $progress['total_videos'] }} Videos</span>
                                </div>
                                @if(count($progress['quiz_marks']) > 0)
                                    <div class="stat">
                                        <i class="fas fa-clipboard-check"></i>
                                        <span>{{ count($progress['quiz_marks']) }} Quizzes</span>
                                    </div>
                                @endif
                            </div>

                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $progress['completion_percentage'] }}%"></div>
                            </div>

                            <div class="course-actions">
                                <button class="btn-primary" onclick="toggleDetails('{{ $progress['course_id'] }}')">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </button>
                                
                                @if($progress['completion_percentage'] == 100 && $progress['average_percentage'] >= 70)
                                    <a href="{{ route('certificate.generate', [
                                        'userId' => auth()->id(),
                                        'courseId' => $progress['course_id'],
                                    ]) }}" 
                                    class="btn-secondary" target="_blank">
                                        <i class="fas fa-download"></i>
                                        Certificate
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="course-details" id="details-{{ $progress['course_id'] }}" style="display: none;">
                            <div class="details-header">
                                <h4><i class="fas fa-chart-bar"></i> Quiz Performance</h4>
                            </div>
                            @if(count($progress['quiz_marks']) > 0)
                                <div class="quiz-list">
                                    @foreach($progress['quiz_marks'] as $quiz)
                                        <div class="quiz-item">
                                            <div class="quiz-info">
                                                <span class="quiz-name">{{ $quiz['quiz_title'] }}</span>
                                            </div>
                                            <div class="quiz-score">{{ $quiz['score'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-quizzes">
                                    <i class="fas fa-info-circle"></i>
                                    <p>No quiz results available yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>No Courses Enrolled</h3>
                        <p>Start your learning journey by enrolling in your first course</p>
                        <a href="/courses" class="btn-primary">
                            <i class="fas fa-search"></i>
                            Browse Courses
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</div>

<script>
function toggleDetails(courseId) {
    const details = document.getElementById(`details-${courseId}`);
    const isVisible = details.style.display !== 'none';
    
    if (isVisible) {
        details.style.display = 'none';
    } else {
        details.style.display = 'block';
    }
}

// Close alert functionality
document.addEventListener('DOMContentLoaded', function() {
    const alertClose = document.querySelector('.alert-close');
    if (alertClose) {
        alertClose.addEventListener('click', function() {
            this.parentElement.style.display = 'none';
        });
    }
});
</script>

<style>
/* Import Font Awesome and Montserrat */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

/* Font overrides */
* {
    font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
i[class^="fa-"], i[class*=" fa-"] {
    font-family: "Font Awesome 6 Free" !important;
    font-style: normal;
    font-weight: 900 !important;
}

/* Main Navigation Header Styles */
.main-header {
    background: #fff;
    backdrop-filter: blur(10px);
    padding: 0.5rem 0;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.logo {
    margin-left: -2rem;
    margin-right: 0.75rem;
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
    margin-left: 1rem;
    margin-right: -1rem;
}

.nav-menu a {
    font-family: 'Montserrat', sans-serif;
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.3s ease;
    margin-right: 1rem;
}

.nav-menu a:hover {
    color: #0E1B33;
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

.user-dropdown .separator {
    height: 1px;
    background: #e5e7eb;
    margin: 8px 0;
}

.username {
    margin-left: 1.5rem;
    font-weight: 500;
    color: #374151;
}

/* Clean Dashboard Styles */
.clean-dashboard {
    min-height: 100vh;
    background-color: #f8fafc;
    margin-top: 80px; /* Add margin for fixed header */
}

/* Header Styles */
.clean-header {
    background: white;
    border-bottom: 1px solid #e2e8f0;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.header-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.main-title {
    margin: 0;
    font-size: 2.5rem;
    font-weight: 300;
    color: #1e293b;
}

.welcome-text {
    display: block;
    font-size: 1.1rem;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.user-name {
    color: #0E1B33;
    font-weight: 600;
    font-size:2rem;
}

.subtitle {
    margin: 0.5rem 0 0 0;
    color: #64748b;
    font-size: 1rem;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Stats Section */
.stats-section {
    margin-bottom: 3rem;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.2s ease;
}

.stat-card:hover {
    border-color: #0E1B33;
    box-shadow: 0 4px 12px rgba(14, 27, 51, 0.1);
}

.stat-icon {
    width: 56px;
    height: 56px;
    background: #f1f5f9;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0E1B33;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 2.2rem;
    font-weight: 700;
    color: #0E1B33;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.stat-description {
    font-size: 0.875rem;
    color: #64748b;
}

/* Courses Section */
.courses-section {
    margin-bottom: 3rem;
}

.section-header {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.section-title i {
    color: #0E1B33;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 2rem;
}

.course-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.2s ease;
}

.course-card:hover {
    border-color: #0E1B33;
    box-shadow: 0 8px 25px rgba(14, 27, 51, 0.1);
    transform: translateY(-2px);
}

.course-header {
    padding: 2rem 2rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.progress-circle {
    position: relative;
    width: 60px;
    height: 60px;
}

.progress-ring {
    transform: rotate(-90deg);
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.875rem;
    font-weight: 600;
    color: #0E1B33;
}

.completion-badge {
    background: #f0fdf4;
    color: #16a34a;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid #bbf7d0;
}

.course-body {
    padding: 0 2rem 2rem;
}

.course-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.course-stats {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748b;
    font-size: 0.9rem;
}

.stat i {
    color: #0E1B33;
    width: 16px;
}

.progress-bar {
    height: 6px;
    background: #f1f5f9;
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.progress-fill {
    height: 100%;
    background: #0E1B33;
    border-radius: 3px;
    transition: width 0.8s ease;
}

.course-actions {
    display: flex;
    gap: 1rem;
}

.btn-primary,
.btn-secondary {
    padding: 0.75rem 1.25rem;
    border-radius: 8px;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-primary {
    background: #0E1B33;
    color: white;
    flex: 1;
}

.btn-primary:hover {
    background: #1e293b;
    transform: translateY(-1px);
}

.btn-secondary {
    background: white;
    color: #0E1B33;
    border: 1px solid #0E1B33;
}

.btn-secondary:hover {
    background: #0E1B33;
    color: white;
    transform: translateY(-1px);
}

/* Course Details */
.course-details {
    border-top: 1px solid #e2e8f0;
    padding: 1.5rem 2rem;
    background: #f8fafc;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.details-header h4 {
    color: #1e293b;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
}

.quiz-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quiz-item {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e2e8f0;
}

.quiz-name {
    font-weight: 500;
    color: #374151;
}

.quiz-score {
    background: #0E1B33;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 16px;
    font-size: 0.875rem;
    font-weight: 600;
}

.no-quizzes {
    text-align: center;
    padding: 2rem;
    color: #64748b;
}

.no-quizzes i {
    font-size: 2rem;
    margin-bottom: 1rem;
    display: block;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 4rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 2rem;
}

.empty-state h3 {
    color: #374151;
    margin-bottom: 1rem;
    font-size: 1.5rem;
    font-weight: 600;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 2rem;
}

/* Alert Styles */
.clean-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 1rem;
    border-radius: 8px;
    margin: 1rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 100px; /* Account for fixed header */
}

.alert-close {
    background: none;
    border: none;
    color: #dc2626;
    font-size: 1.25rem;
    cursor: pointer;
    padding: 0;
    margin-left: 1rem;
}

.alert-close:hover {
    opacity: 0.7;
}

/* Responsive Design */
@media (max-width: 768px) {
    .nav-menu {
        display: none;
    }
    
    .search-input {
        width: 250px;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .main-content {
        padding: 0 1rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .courses-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .course-actions {
        flex-direction: column;
    }
    
    .main-title {
        font-size: 2rem;
    }
    
    .top-icons {
        gap: 0.5rem;
        margin: 0;
    }
}

@media (max-width: 480px) {
    .clean-header {
        padding: 1rem 0;
    }
    
    .header-container {
        padding: 0 1rem;
    }
    
    .stat-card {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .course-header {
        flex-direction: column;
        gap: 1rem;
        align-items: center;
        text-align: center;
    }
    
    .search-input {
        width: 200px;
    }
}
</style>
@endsection