<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses</title>
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
      overflow-x: hidden;
    }

    /* Sidebar - Matching Dashboard Style */
    .sidebar {
      width: 17.5rem;
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

    /* Main Content Wrapper - Matching Dashboard Style */
    .main-wrapper {
      margin-left: 17.5rem;
      flex: 1;
      max-width: calc(100vw - 17.5rem);
      overflow-x: hidden;
    }

    .main-content {
      flex: 1;
      padding: 2rem;
      max-width: 100%;
      box-sizing: border-box;
    }

    /* Top bar - Matching Dashboard Style */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 1rem;
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
      background-color: var(--primary-color);
      color: white;
    }

    .auth-buttons {
      display: flex;
      gap: 0.5rem;
    }
    .add-course-button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background-color: var(--primary-color);
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 0.375rem;
      text-decoration: none;
      font-weight: 500;
      border: none;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
      font-size: 0.875rem;
      white-space: nowrap;
      margin-left: auto;
      margin-bottom: 1rem;
    }

    .add-course-button:hover {
      opacity: 0.9;
    }

    /* Table Container - Enhanced Card Style */
    .table-container {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      margin-bottom: 2rem;
      max-width: 100%;
    }

    .table-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--border-color);
      background-color: var(--edit-bg);
    }

    .table-title {
      font-size: 1.125rem;
      font-weight: 600;
      color: var(--primary-color);
      margin: 0;
    }

    .table-wrapper {
      overflow-x: auto;
      max-width: 100%;
    }

    .courses-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.8rem;
      min-width: 800px;
    }

    .courses-table th {
      background-color: var(--body-background);
      color: var(--text-gray-500);
      font-weight: 500;
      padding: 0.5rem 0.75rem;
      text-align: left;
      border-bottom: 1px solid var(--border-color);
      font-size: 0.8rem;
      white-space: nowrap;
    }

    .courses-table td {
      padding: 0.5rem 0.75rem;
      border-bottom: 1px solid var(--border-color);
      color: var(--text-gray-700);
      vertical-align: middle;
      font-size: 0.8rem;
    }

    .courses-table tbody tr:hover {
      background-color: var(--body-background);
    }

    .courses-table tbody tr:last-child td {
      border-bottom: none;
    }

    .course-image {
      width: 3rem;
      height: 2.25rem;
      object-fit: cover;
      border-radius: 0.375rem;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }

    .course-title-link {
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: text-decoration 0.2s ease-in-out;
      display: block;
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .course-title-link:hover {
      text-decoration: underline;
    }

    .course-description {
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .course-price {
      color: var(--green-600);
      font-weight: 600;
    }

    .no-image-text {
      color: var(--text-gray-500);
      font-style: italic;
      font-size: 0.7rem;
    }

    /* Compact table columns */
    .courses-table th:nth-child(1), .courses-table td:nth-child(1) { width: 60px; } /* Image */
    .courses-table th:nth-child(2), .courses-table td:nth-child(2) { width: 130px; } /* Title */
    .courses-table th:nth-child(3), .courses-table td:nth-child(3) { width: 130px; } /* Description */
    .courses-table th:nth-child(4), .courses-table td:nth-child(4) { width: 80px; } /* Category */
    .courses-table th:nth-child(5), .courses-table td:nth-child(5) { width: 60px; } /* Videos */
    .courses-table th:nth-child(6), .courses-table td:nth-child(6) { width: 80px; } /* Video Length */
    .courses-table th:nth-child(7), .courses-table td:nth-child(7) { width: 80px; } /* Total Duration */
    .courses-table th:nth-child(8), .courses-table td:nth-child(8) { width: 70px; } /* Price */
    .courses-table th:nth-child(9), .courses-table td:nth-child(9) { width: 90px; } /* Added */
    .courses-table th:nth-child(10), .courses-table td:nth-child(10) { width: 110px; } /* Actions */

    /* Action Buttons */
    .actions-container {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      justify-content: flex-start;
    }

    .edit-button {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      background-color: var(--edit-bg);
      color: var(--edit-text);
      padding: 0.25rem 0.5rem;
      border-radius: 0.25rem;
      font-weight: 500;
      font-size: 0.7rem;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out;
    }

    .edit-button:hover {
      background-color: #dbeafe;
    }

    .delete-button {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--delete-bg);
      color: var(--delete-icon);
      width: 1.75rem;
      height: 1.75rem;
      border-radius: 0.25rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.2s ease-in-out;
    }

    .delete-button:hover {
      background-color: #fee2e2;
    }

    .edit-icon, .delete-icon {
      width: 0.75rem;
      height: 0.75rem;
    }

    .delete-icon {
      width: 0.875rem;
      height: 0.875rem;
    }

    /* Empty state */
    .empty-state {
      padding: 3rem;
      text-align: center;
      color: var(--text-gray-500);
      font-size: 0.875rem;
    }

    .not-logged-in {
      text-align: center;
      color: var(--text-gray-700);
      padding: 2rem;
    }

    .login-link {
      color: var(--primary-color);
      text-decoration: none;
      transition: text-decoration 0.2s ease-in-out;
    }

    .login-link:hover {
      text-decoration: underline;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .sidebar {
        width: 16rem;
      }
      
      .main-wrapper {
        margin-left: 16rem;
        max-width: calc(100vw - 16rem);
      }

      .courses-table {
        font-size: 0.75rem;
        min-width: 700px;
      }

      .courses-table th, .courses-table td {
        padding: 0.375rem 0.5rem;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
      
      .main-wrapper {
        margin-left: 0;
        max-width: 100vw;
      }
      
      .main-content {
        padding: 1rem;
      }
      
      .search-add-section {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
      }

      .search-input {
        min-width: auto;
      }
      
      .courses-table {
        font-size: 0.7rem;
        min-width: 600px;
      }
      
      .courses-table th,
      .courses-table td {
        padding: 0.25rem 0.375rem;
      }
      
      .course-description, .course-title-link {
        max-width: 80px;
      }

      .course-image {
        width: 2.5rem;
        height: 1.875rem;
      }

      .edit-button {
        font-size: 0.65rem;
        padding: 0.125rem 0.375rem;
      }

      .delete-button {
        width: 1.5rem;
        height: 1.5rem;
      }

      .edit-icon, .delete-icon {
        width: 0.625rem;
        height: 0.625rem;
      }

      .top-bar {
        flex-direction: column;
        align-items: stretch;
      }

      .user-info {
        justify-content: space-between;
      }
    }

    @media (max-width: 480px) {
      .courses-table {
        min-width: 500px;
      }

      .course-description, .course-title-link {
        max-width: 60px;
      }

      .courses-table th:nth-child(2), .courses-table td:nth-child(2) { width: 80px; }
      .courses-table th:nth-child(3), .courses-table td:nth-child(3) { width: 80px; }
      .courses-table th:nth-child(10), .courses-table td:nth-child(10) { width: 80px; }
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
      <a href="/admin_panel">Dashboard</a>
      <a href="/admin_panel/manage_courses" class="active">Manage Course</a>
      <a href="/admin_panel/manage_user">Manage User</a>
      <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
    </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Main Content -->
    <main class="main-content">
      <!-- Top bar -->
      <div class="top-bar">
        <div class="top-bar-title">Manage Courses</div>
        @auth
          <div class="user-info">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display: inline;">
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

        <!-- Courses Table -->
        <div class="table-container">
          <div class="table-header">
            <h3 class="table-title">All Courses</h3>
          </div>

          @if(isset($courses) && $courses->isEmpty())
            <div class="empty-state">
              <p>No courses available.</p>
            </div>
          @else
            <div class="table-wrapper">
              <table class="courses-table">
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Videos</th>
                    <th>Video Length</th>
                    <th>Total Duration</th>
                    <th>Price (৳)</th>
                    <th>Added</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($courses as $course)
                    <tr>
                      <td>
                        @if($course->image)
                          <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                        @else
                          <span class="no-image-text">No image</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ url("/admin_panel/manage_resources/{$course->id}/modules") }}" class="course-title-link">{{ $course->title }}</a>
                      </td>
                      <td>
                        <div class="course-description">{{ $course->description }}</div>
                      </td>
                      <td>{{ $course->category }}</td>
                      <td>{{ $course->video_count }}</td>
                      <td>{{ $course->approx_video_length }} mins</td>
                      <td>{{ $course->total_duration }} hrs</td>
                      <td class="course-price">{{ $course->price }}</td>
                      <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                      <td>
                        <div class="actions-container">
                          <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="GET" style="display: inline;">
                            <button type="submit" class="edit-button">
                              <svg class="edit-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                              Edit
                            </button>
                          </form>
                          <form action="/admin_panel/manage_courses/delete-course/{{ $course->id }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this course?');">
                              <svg class="delete-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                              </svg>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>

      @else
        <div style="width: 100%; display: flex; align-items: center; justify-content: center; min-height: 50vh;">
          <p class="not-logged-in">You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
        </div>
      @endauth
    </main>
  </div>
</body>
</html>