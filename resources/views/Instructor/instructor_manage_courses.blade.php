<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg-primary: #ffffff;
      --bg-secondary: #f8f9fa;
      --bg-tertiary: #f1f3f5;
      --text-primary: #000000;
      --text-secondary: #495057;
      --text-tertiary: #6c757d;
      --border-color: #dee2e6;
      --border-light: #e9ecef;
      --accent: #212529;
      --hover-bg: #f8f9fa;
      --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background-color: var(--bg-secondary);
      color: var(--text-primary);
      line-height: 1.5;
    }

    /* Sidebar */
    .sidebar {
      width: 240px;
      background-color: var(--bg-primary);
      min-height: 100vh;
      border-right: 1px solid var(--border-color);
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar-header {
      padding: 1.5rem 1rem;
      border-bottom: 1px solid var(--border-light);
    }

    .sidebar-header img {
      height: 32px;
    }

    .sidebar-nav {
      padding: 1rem 0;
    }

    .sidebar-nav a {
      display: block;
      padding: 0.625rem 1rem;
      color: var(--text-secondary);
      font-weight: 500;
      font-size: 0.875rem;
      text-decoration: none;
      transition: all 0.15s ease;
      border-left: 3px solid transparent;
    }

    .sidebar-nav a:hover {
      background-color: var(--hover-bg);
      color: var(--text-primary);
    }

    .sidebar-nav a.active {
      background-color: var(--bg-tertiary);
      color: var(--text-primary);
      border-left-color: var(--accent);
    }

    /* Main */
    .main-wrapper {
      margin-left: 240px;
      min-height: 100vh;
    }

    .main-content {
      padding: 1.5rem;
      max-width: 1400px;
    }

    /* Header */
    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border-color);
    }

    .page-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text-primary);
    }

    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-name {
      color: var(--text-secondary);
      font-size: 0.875rem;
      font-weight: 500;
    }

    /* Buttons */
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.375rem 0.875rem;
      border: 1px solid var(--border-color);
      border-radius: 4px;
      font-size: 0.8125rem;
      font-weight: 500;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.15s ease;
      background: var(--bg-primary);
      color: var(--text-primary);
    }

    .btn:hover {
      background-color: var(--hover-bg);
      border-color: var(--accent);
    }

    .btn-primary {
      background-color: var(--accent);
      color: white;
      border-color: var(--accent);
    }

    .btn-primary:hover {
      background-color: #000000;
      border-color: #000000;
    }

    .btn-sm {
      padding: 0.25rem 0.625rem;
      font-size: 0.75rem;
    }

    .btn-danger {
      color: #dc3545;
      border-color: #dc3545;
    }

    .btn-danger:hover {
      background-color: #dc3545;
      color: white;
    }

    /* Section Container */
    .section-container {
      background: var(--bg-primary);
      border: 1px solid var(--border-color);
      border-radius: 6px;
      margin-bottom: 2rem;
      overflow: hidden;
    }

    .section-header {
      background: var(--bg-tertiary);
      color: var(--text-primary);
      padding: 0.875rem 1.25rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid var(--border-color);
    }

    .section-title {
      font-size: 1rem;
      font-weight: 600;
      margin: 0;
    }

    .section-count {
      background: var(--bg-secondary);
      color: var(--text-secondary);
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
      border: 1px solid var(--border-color);
    }

    .section-body {
      padding: 0;
    }

    /* Course Card - Compact */
    .course-card {
      border-bottom: 1px solid var(--border-light);
      transition: background-color 0.15s ease;
    }

    .course-card:last-child {
      border-bottom: none;
    }

    .course-card:hover {
      background-color: var(--bg-secondary);
    }

    .course-main {
      padding: 1rem 1.25rem;
      display: grid;
      grid-template-columns: 100px 1fr auto;
      gap: 1rem;
      align-items: center;
    }

    .course-image {
      width: 100px;
      height: 65px;
      object-fit: cover;
      border-radius: 3px;
      border: 1px solid var(--border-light);
    }

    .course-details {
      min-width: 0;
    }

    .course-title {
      font-size: 1rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 0.375rem;
    }

    .course-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      font-size: 0.75rem;
      color: var(--text-secondary);
    }

    .course-meta-item {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .meta-label {
      color: var(--text-tertiary);
    }

    .meta-value {
      font-weight: 600;
      color: var(--text-primary);
    }

    .course-actions {
      display: flex;
      flex-direction: column;
      gap: 0.375rem;
      align-items: flex-end;
    }

    .status-badge {
      display: inline-block;
      padding: 0.1875rem 0.5rem;
      border-radius: 3px;
      font-size: 0.6875rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.025em;
      margin-left: 0.5rem;
    }

    .status-pending {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    .status-submitted {
      background-color: #d1ecf1;
      color: #0c5460;
      border: 1px solid #bee5eb;
    }

    .empty-state {
      padding: 2rem;
      text-align: center;
      color: var(--text-tertiary);
      font-size: 0.875rem;
    }

    /* Pending Section Styling */
    .section-container.pending .section-header {
      background: var(--bg-tertiary);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .main-wrapper {
        margin-left: 0;
      }

      .main-content {
        padding: 1rem;
      }

      .course-main {
        grid-template-columns: 1fr;
      }

      .course-image {
        width: 100%;
        height: 120px;
      }

      .course-actions {
        align-items: stretch;
      }

      .page-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
      }

      .header-actions {
        justify-content: space-between;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage">
    </div>
    <nav class="sidebar-nav">
      <a href="/instructor_homepage">Dashboard</a>
      <a href="/instructor/manage_courses" class="active">Manage Courses</a>
    </nav>
  </aside>

  <!-- Main -->
  <div class="main-wrapper">
    <main class="main-content">
      <!-- Header -->
      <div class="page-header">
        <h1 class="page-title">Manage Courses</h1>
        @auth
          <div class="header-actions">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST">
              @csrf
              <button class="btn btn-sm">Logout</button>
            </form>
          </div>
        @endauth
      </div>

      @auth
      <!-- Add Course -->
      <div style="margin-bottom: 1.5rem;">
        <form action="/manage_courses/add" method="GET">
          <button type="submit" class="btn btn-primary">Add New Course</button>
        </form>
      </div>

      <!-- Approved Courses Section -->
      <div class="section-container">
        <div class="section-header">
          <h2 class="section-title">Approved Courses</h2>
          @if(isset($courses))
            <span class="section-count">{{ $courses->count() }}</span>
          @endif
        </div>
        <div class="section-body">
          @if(isset($courses) && $courses->isEmpty())
            <div class="empty-state">No approved courses available.</div>
          @else
            @foreach($courses as $course)
              <div class="course-card">
                <div class="course-main">
                  @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                  @endif
                  
                  <div class="course-details">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <div class="course-meta">
                      <div class="course-meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">{{ $course->category }}</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Videos:</span>
                        <span class="meta-value">{{ $course->video_count }}</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Duration:</span>
                        <span class="meta-value">{{ $course->total_duration }} hrs</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Price:</span>
                        <span class="meta-value">৳{{ $course->price }}</span>
                      </div>
                    </div>
                  </div>

                  <div class="course-actions">
                    <a href="{{ url("/admin_panel/manage_resources/{$course->id}/modules") }}" class="btn btn-sm">
                      Manage Modules
                    </a>
                    @php
                      $finalExam = \App\Models\FinalExam::where('course_id', $course->id)->first();
                    @endphp
                    @if($finalExam)
                      <a href="{{ route('instructor.final-exams.show', $finalExam->id) }}" class="btn btn-sm">
                        View Final Exam
                      </a>
                    @else
                      <a href="{{ route('instructor.final-exams.create') }}?course_id={{ $course->id }}" class="btn btn-sm">
                        Create Final Exam
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      <!-- Pending Courses Section -->
      <div class="section-container pending">
        <div class="section-header">
          <h2 class="section-title">Pending Courses (Awaiting Approval)</h2>
          @if(isset($pendingCourses))
            <span class="section-count">{{ $pendingCourses->count() }}</span>
          @endif
        </div>
        <div class="section-body">
          @if(isset($pendingCourses) && $pendingCourses->isEmpty())
            <div class="empty-state">No pending courses.</div>
          @else
            @foreach($pendingCourses as $course)
              <div class="course-card">
                <div class="course-main">
                  @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                  @endif
                  
                  <div class="course-details">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <div class="course-meta">
                      <div class="course-meta-item">
                        <span class="meta-label">Category:</span>
                        <span class="meta-value">{{ $course->category }}</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Videos:</span>
                        <span class="meta-value">{{ $course->video_count }}</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Duration:</span>
                        <span class="meta-value">{{ $course->total_duration }} hrs</span>
                      </div>
                      <div class="course-meta-item">
                        <span class="meta-label">Price:</span>
                        <span class="meta-value">৳{{ $course->price }}</span>
                      </div>
                      <div class="course-meta-item">
                        @if(\App\Models\CourseNotification::where('pending_course_id', $course->id)->exists())
                          <span class="status-badge status-submitted">Submitted</span>
                        @else
                          <span class="status-badge status-pending">Not Submitted</span>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="course-actions">
                    <a href="{{ url("/instructor/manage_resources/{$course->id}/modules") }}" class="btn btn-sm">
                      Manage Modules
                    </a>
                    <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="GET">
                      <button type="submit" class="btn btn-sm">Edit Course</button>
                    </form>
                    <form action="/admin_panel/manage_courses/delete-course/{{ $course->id }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this course?');">
                        Delete
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      @else
      <div class="section-container">
        <div class="empty-state" style="padding: 3rem;">
          <p>You are not logged in. <a href="/" style="color: var(--accent); text-decoration: underline;">Go to Login</a></p>
        </div>
      </div>
      @endauth
    </main>
  </div>
</body>
</html>