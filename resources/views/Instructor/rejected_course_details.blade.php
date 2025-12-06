<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rejected Courses</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #0E1B33;
      --primary-light-hover-bg: #E3E6F3;
      --body-background: #f9fafb;
      --card-background: #ffffff;
      --text-gray-700: #374151;
      --text-gray-500: #6b7280;
      --border-color: #e5e7eb;
      --rejected-color: #DC2626;
      --rejected-bg: #FEF2F2;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--body-background);
      margin: 0;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 17.5rem;
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      position: fixed;
      left: 0;
      top: 0;
    }
    .sidebar-header {
      padding: 1.5rem;
      display: flex;
      align-items: center;
      color: var(--primary-color);
      font-weight: 700;
      font-size: 1.25rem;
    }
    .sidebar-header img { height: 2.5rem; }
    .sidebar-nav { margin-top: 2rem; display: flex; flex-direction: column; }
    .sidebar-nav a {
      padding: 0.75rem 1.5rem;
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out;
    }
    .sidebar-nav a:hover, .sidebar-nav a.active {
      background-color: var(--primary-light-hover-bg);
    }

    /* Main content */
    .main-wrapper {
      margin-left: 17.5rem;
      flex: 1;
      max-width: calc(100vw - 17.5rem);
    }
    .main-content { padding: 2rem; }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
    }
    .top-bar-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary-color);
    }
    .user-info { display: flex; align-items: center; gap: 1rem; }
    .user-info span { font-weight: 500; color: var(--primary-color); }
    .logout-button, .login-button, .signup-button {
      padding: 0.5rem 0.75rem;
      border-radius: 0.25rem;
      border: none;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s;
    }
    .logout-button, .signup-button {
      background-color: var(--primary-color);
      color: white;
    }
    .login-button {
      border: 1px solid var(--primary-color);
      background: transparent;
      color: var(--primary-color);
    }
    .login-button:hover { background: var(--primary-color); color: #fff; }

    /* Table styles */
    .custom-table {
      width: 100%;
      border-collapse: collapse;
      background: var(--card-background);
      border-radius: 0.5rem;
      overflow: hidden;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .custom-table th, .custom-table td {
      padding: 1rem;
      border-bottom: 1px solid var(--border-color);
      text-align: left;
    }
    .custom-table th {
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
      font-weight: 600;
    }
    .custom-table tr:hover td {
      background: #f3f4f6;
    }
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
            font-size: 0.875rem;
    }

      .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
      }


    /* Alerts */
    .alert {
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1rem;
      font-size: 0.95rem;
    }
    .alert-info {
      background: #E0F2FE;
      color: #0369A1;
    }

    @media (max-width: 768px) {
      .sidebar { display: none; }
      .main-wrapper { margin-left: 0; max-width: 100%; }
      .main-content { padding: 1rem; }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage Logo">
    </div>
    <nav class="sidebar-nav">
      <a href="/instructor_homepage">Dashboard</a>
      <a href="/instructor/manage_courses">Manage Courses</a>
      <a href="/instructor/rejected_courses" class="active">Rejected Courses</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <div class="main-wrapper">
    <main class="main-content">
      <div class="top-bar">
        <div class="top-bar-title">Rejected Courses</div>
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
      </div>

      @auth
        @if($rejectedCourses->isEmpty())
          <div class="alert alert-info">No rejected courses found.</div>
        @else
          <table class="custom-table">
            <thead>
              <tr>
                <th>Course Title</th>
                <th>Course Description</th>
                <th>Course Created At</th>
                <th>Rejection Reason</th>
                <th>Rejected On</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rejectedCourses as $course)
                <tr>
                  <td>{{ $course->title }}</td>
                  <td>{{ $course->description ?: 'No description available' }}</td>
                  <td>
                    @if($course->created_at)
                      {{ \Carbon\Carbon::parse($course->created_at)->format('d M Y') }}
                    @else
                      N/A
                    @endif
                  </td>
                  <td>{{ $course->rejection_message }}</td>
                  <td>
                    @if($course->rejected_at)
                      {{ \Carbon\Carbon::parse($course->rejected_at)->format('d M Y') }}
                    @else
                      N/A
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      @endauth
      <a href="javascript:history.back()" class="back-link">
                    Back
      </a>
    </main>
  </div>
</body>
</html>
