<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Lecture Management</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Custom CSS Variables */
    :root {
      --primary-color: #0E1B33;
      --primary-light-hover-bg: #E3E6F3;
      --body-background: #f9fafb;
      --card-background: #ffffff;
      --text-default: #333;
      --text-gray-600: #4b5563;
      --text-gray-700: #374151;
      --text-gray-500: #6b7280;
      --border-color: #e5e7eb;
      --edit-bg: #EDF2FC;
      --edit-text: #0E1B33;
      --delete-bg: #FEF2F2;
      --delete-icon: #DC2626;
      --green-600: #059669;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--body-background);
      margin: 0;
      display: flex;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 18rem;
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      position: fixed;
      left: 0;
      top: 0;
    }

    .sidebar-header {
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.25rem;
    }

    .sidebar-header img {
      height: 2.5rem;
    }

    .sidebar-nav {
      margin-top: 2.5rem;
      display: flex;
      flex-direction: column;
    }

    .sidebar-nav a {
      display: block;
      padding: 0.75rem 1.5rem;
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .sidebar-nav a:hover {
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
    }

    .sidebar-nav a.active {
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
    }

    /* Main Content Wrapper */
    .main-wrapper {
      margin-left: 17.5rem;
      flex: 1;
    }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .top-bar-title {
      font-size: 1.5rem;
      font-weight: 400;
      color: var(--primary-color);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-info span {
      color: var(--primary-color);
      font-weight: 500;
    }

    .logout-button, .login-button, .signup-button {
      padding: 0.5rem 0.75rem;
      border-radius: 0.25rem;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-weight: 500;
      transition: opacity 0.2s ease-in-out;
    }

    .logout-button, .signup-button {
      background-color: var(--primary-color);
      color: white;
    }

    .logout-button:hover, .signup-button:hover {
      opacity: 0.9;
    }

    .login-button {
      border: 1px solid var(--primary-color);
      color: var(--primary-color);
      background-color: transparent;
    }

    .login-button:hover {
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
    }

    .auth-buttons {
      display: flex;
      gap: 0.5rem;
    }

    /* Main Content */
    .main-content {
      padding: 2rem;
    }

    /* Module Info Card */
    .module-info-card {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .module-info-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .module-info-details {
      color: var(--text-gray-600);
      margin-bottom: 1.5rem;
    }

    .module-info-details p {
      margin: 0.5rem 0;
    }

    /* Action Cards Grid */
    .actions-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .action-card {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      text-align: center;
      transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .action-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .action-card-icon {
      width: 4rem;
      height: 4rem;
      background-color: var(--edit-bg);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      color: var(--primary-color);
      font-size: 1.5rem;
    }

    .action-card-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .action-card-description {
      color: var(--text-gray-600);
      margin-bottom: 1.5rem;
      font-size: 0.875rem;
    }

    .action-button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 0.25rem;
      font-weight: 500;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
      text-decoration: none;
      display: inline-block;
      font-family: 'Montserrat', sans-serif;
    }

    .action-button:hover {
      opacity: 0.9;
    }

    /* Back Navigation */
    .back-navigation {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 1.5rem;
    }

    /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--primary-color);
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
            margin-top: 2rem;
            font-size: 0.875rem;
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }
    .back-arrow {
      font-size: 1.25rem;
    }

    .not-logged-in {
      text-align: center;
      color: var(--text-gray-700);
    }

    .login-link {
      color: var(--primary-color);
      text-decoration: none;
      transition: text-decoration 0.2s ease-in-out;
    }

    .login-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage Logo">
      <span></span>
    </div>
    <nav class="sidebar-nav">
      @if(auth()->user()->role === 2)
        <a href="/admin_panel">Dashboard</a>
        <a href="/admin_panel/manage_courses" class="active">Manage Course</a>
        <a href="/admin_panel/manage_user">Manage User</a>
         <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
      @elseif(auth()->user()->role === 3)
        <a href="/instructor_homepage">Dashboard</a>
        <a href="/instructor/manage_courses" class="active">Manage Course</a>
        <a href="/instructor/manage_user">Manage User</a>
      @endif
    </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Top bar -->
    <header class="top-bar">
      <h1 class="top-bar-title">Lecture Management</h1>
      @auth
        <div class="user-info">
          <span>{{ auth()->user()->name }}</span>
          <form action="/logout" method="POST">
            @csrf
            <button class="logout-button">Logout</button>
          </form>
        </div>
      @else
        <div class="auth-buttons">
          <a href="/login" class="login-button">Login</a>
          <a href="/register" class="signup-button">Sign Up</a>
        </div>
      @endauth
    </header>

    <!-- Main Content -->
    <section class="main-content">
      @auth
        <!-- Module Information Card -->
        <div class="module-info-card">
          <h2 class="module-info-title">Lecture {{ $moduleNumber ?? '1' }} Management</h2>
          <div class="module-info-details">
            <p><strong>Course:</strong> {{ $course->title ?? 'Sample Course Title' }}</p>
            <p><strong>Lecture Number:</strong> {{ $moduleNumber ?? '1' }}</p>
            <p><strong>Description:</strong> Manage videos, PDFs, and quizzes for this lecture</p>
          </div>
        </div>

        <!-- Action Cards -->
        <div class="actions-grid">
          <!-- Add Video and PDF Card -->
          <div class="action-card">
            <div class="action-card-icon">
              📹
            </div>
            <h3 class="action-card-title">Add Video and PDF</h3>
            <p class="action-card-description">
              Upload video content and PDF materials for this lecture to enhance the learning experience.
            </p>
            <a href="/admin_panel/manage_resources/{{ $course->id ?? 1 }}/modules/{{ $moduleNumber ?? 1 }}/edit" class="action-button">
              @if(!$resource)  
              Add Content
              @else
               Edit Content 
              @endif
            </a>
          </div>

          <!-- Add Quiz Card -->
          <div class="action-card">
            <div class="action-card-icon">
              📝
            </div>
            <h3 class="action-card-title">Add Quiz</h3>
            <p class="action-card-description">
              Create interactive quizzes to test student understanding and reinforce learning objectives.
            </p>
            <a href="{{ route('quiz.create', ['course' => $course->id ?? 1, 'module' => $moduleNumber ?? 1]) }}" class="action-button">
              @if($quiz)
              Edit Quiz
              @else
               Create Quiz
              @endif
            </a>
          </div>
        </div>

        <!-- Back Navigation -->
        <a href="javascript:history.back()" class="back-link">
            Back
          </a>

      @else
        <p class="not-logged-in">You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
      @endauth
    </section>
  </div>

</body>
</html>
