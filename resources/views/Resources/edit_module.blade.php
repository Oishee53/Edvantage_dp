<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Upload Resources</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Custom CSS Variables */
    :root {
      --primary-color: #0E1B33;
      --primary-light-hover-bg: #2D336B;
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
      width: 16rem;
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
      background-color: #E3E6F3;;
      color: var(--primary-color);
    }

    .sidebar-nav a.active {
      background-color: #E3E6F3;;
      color: var(--primary-color);
    }

    /* Main Content Wrapper */
    .main-wrapper {
      margin-left: 15rem;
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
      color: white;
    }

    .auth-buttons {
      display: flex;
      gap: 0.5rem;
    }

    /* Main Content */
    .main-content {
      padding: 2rem;
    }

    /* Added upload form specific styles */
    .upload-form-container {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
      font-size: 0.875rem;
    }

    .file-input {
      width: 100%;
      padding: 0.75rem;
      border: 2px dashed var(--border-color);
      border-radius: 0.5rem;
      background-color: #f9fafb;
      cursor: pointer;
      transition: border-color 0.2s ease-in-out, background-color 0.2s ease-in-out;
    }

    .file-input:hover {
      border-color: var(--primary-color);
      background-color: #f3f4f6;
    }

    .file-input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(14, 27, 51, 0.2);
    }

    .upload-button {
      background-color: var(--primary-color);
      color: white;
      padding: 0.75rem 2rem;
      border: none;
      border-radius: 0.5rem;
      font-weight: 600;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
      width: 100%;
      margin-top: 1rem;
    }

    .upload-button:hover {
      opacity: 0.9;
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

    .section-header {
      font-size: 1.125rem;
      font-weight: 600;
      color: var(--primary-color);
      margin: 1rem 0 1.5rem 0;
      text-align: center;
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
                    <a href="/admin_panel/manage_courses" class="active">Manage Courses</a>
                    <a href="/admin_panel/manage_user">Manage Users</a>
                     <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
                @elseif(auth()->user()->role === 3)
                    <a href="/instructor_homepage">Dashboard</a>
                    <a href="/instructor/manage_courses" class="active">Manage Courses</a>
                    <a href="/instructor/manage_user">Manage Users</a>
                @endif
    </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Top bar -->
    <header class="top-bar">
      <h1 class="top-bar-title">Upload Resources</h1>
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
        <div class="upload-form-container">
          <h2 class="section-header">Upload Course Resources</h2>
          
          <!-- Replaced basic form with styled upload form -->
          <form method="POST" action="{{ route('upload.resources', [$course->id, $module_id]) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <label class="form-label">Upload Video:</label>
              <input type="file" name="video" accept="video/*" class="file-input">
            </div>

            <div class="form-group">
              <label class="form-label">Upload PDF:</label>
              <input type="file" name="pdf" accept="application/pdf" class="file-input">
            </div>

            <button type="submit" class="upload-button">Upload Resources</button>
          </form>

          <a href="javascript:history.back()" class="back-link">
            Back
          </a>
        </div>
      @else
        <p class="not-logged-in">You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
      @endauth
    </section>
  </div>

</body>
</html>
