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
      --success-color: #059669;
      --warning-color: #f59e0b;
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
      transition: all 0.2s ease-in-out;
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

    /* Search and Add Section */


    .add-course-button {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background-color: var(--primary-color);
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 0.375rem;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
      white-space: nowrap;
      margin-left: 50rem;
    }

    .add-course-button:hover {
      background-color: #1a2645;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
    }

    /* Section Headers */
    .section-header {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-color);
      margin: 2rem 0 1rem 0;
      padding-left: 0.5rem;
      border-left: 4px solid var(--primary-color);
    }

    .section-header:first-of-type {
      margin-top: 1rem;
    }

    /* Table */
    .table-wrapper {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      margin-bottom: 2rem;
      max-width: 100%;
    }

    .table-scroll {
      overflow-x: auto;
      max-width: 100%;
    }

    .courses-table {
      width: 100%;
      font-size: 0.8rem;
      color: var(--text-gray-700);
      border-collapse: collapse;
      min-width: 900px;
    }

    .courses-table thead {
      background-color: var(--edit-bg);
      color: var(--primary-color);
    }

    .courses-table th {
      padding: 0.75rem 1rem;
      text-align: left;
      font-weight: 600;
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      border-bottom: 1px solid var(--border-color);
      white-space: nowrap;
    }

    .courses-table td {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid var(--border-color);
      vertical-align: middle;
      font-size: 0.8rem;
    }

    .courses-table tbody tr:hover {
      background-color: var(--body-background);
    }

    .courses-table tbody tr:last-child td {
      border-bottom: none;
    }

    /* Column width optimization */
    .courses-table th:nth-child(1), .courses-table td:nth-child(1) { width: 80px; } /* Image */
    .courses-table th:nth-child(2), .courses-table td:nth-child(2) { width: 150px; } /* Title */
    .courses-table th:nth-child(3), .courses-table td:nth-child(3) { width: 180px; } /* Description */
    .courses-table th:nth-child(4), .courses-table td:nth-child(4) { width: 100px; } /* Category */
    .courses-table th:nth-child(5), .courses-table td:nth-child(5) { width: 70px; } /* Videos */
    .courses-table th:nth-child(6), .courses-table td:nth-child(6) { width: 90px; } /* Video Length */
    .courses-table th:nth-child(7), .courses-table td:nth-child(7) { width: 90px; } /* Total Duration */
    .courses-table th:nth-child(8), .courses-table td:nth-child(8) { width: 80px; } /* Price */
    .courses-table th:nth-child(9), .courses-table td:nth-child(9) { width: 110px; } /* Added */
    .courses-table th:nth-child(10), .courses-table td:nth-child(10) { width: 80px; } /* Status */
    .courses-table th:nth-child(11), .courses-table td:nth-child(11) { width: 120px; } /* Actions */

    .course-image {
      width: 4rem;
      height: 3rem;
      object-fit: cover;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .course-title-link {
      color: var(--primary-color);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
      display: block;
      max-width: 140px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .course-title-link:hover {
      text-decoration: underline;
      color: #1a2645;
    }

    .course-description {
      max-width: 170px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      color: var(--text-gray-600);
    }

    .course-price {
      color: var(--success-color);
      font-weight: 700;
      font-size: 0.9rem;
    }

    .no-image-text {
      color: var(--text-gray-500);
      font-style: italic;
      font-size: 0.7rem;
    }

    .status-submitted {
      color: var(--success-color);
      font-weight: 600;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .status-not-submitted {
      color: var(--warning-color);
      font-weight: 600;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    /* Action Buttons */
    .actions-container {
      display: flex;
      gap: 0.375rem;
      align-items: center;
    }

    .edit-button {
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      background-color: var(--edit-bg);
      color: var(--edit-text);
      padding: 0.375rem 0.5rem;
      border-radius: 0.25rem;
      font-weight: 500;
      font-size: 0.7rem;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
    }

    .edit-button:hover {
      background-color: #dbeafe;
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(14, 27, 51, 0.1);
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
      transition: all 0.2s ease-in-out;
    }

    .delete-button:hover {
      background-color: #fee2e2;
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
    }

    .edit-icon, .delete-icon {
      width: 0.75rem;
      height: 0.75rem;
    }

    .delete-icon {
      width: 0.875rem;
      height: 0.875rem;
    }

    /* No courses message */
    .no-courses {
      text-align: center;
      color: var(--text-gray-500);
      font-style: italic;
      padding: 3rem 2rem;
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      margin-bottom: 2rem;
    }

    /* Not logged in state */
    .not-logged-in-container {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background-color: var(--body-background);
    }

    .not-logged-in {
      text-align: center;
      color: var(--text-gray-700);
      padding: 2rem;
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .login-link {
      color: var(--primary-color);
      text-decoration: none;
      transition: text-decoration 0.2s ease-in-out;
      font-weight: 500;
    }

    .login-link:hover {
      text-decoration: underline;
    }

    /* Icons */
    .icon {
      width: 16px;
      height: 16px;
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
        min-width: 800px;
      }

      .courses-table th, .courses-table td {
        padding: 0.5rem 0.75rem;
      }

      .course-image {
        width: 3.5rem;
        height: 2.5rem;
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
        gap: 1rem;
      }

      .search-input {
        min-width: auto;
      }

      .courses-table {
        font-size: 0.7rem;
        min-width: 700px;
      }

      .courses-table th, .courses-table td {
        padding: 0.375rem 0.5rem;
      }

      .course-description, .course-title-link {
        max-width: 100px;
      }

      .course-image {
        width: 3rem;
        height: 2.25rem;
      }

      .edit-button {
        font-size: 0.65rem;
        padding: 0.25rem 0.375rem;
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
        min-width: 600px;
      }

      .course-description, .course-title-link {
        max-width: 80px;
      }

      .courses-table th:nth-child(2), .courses-table td:nth-child(2) { width: 100px; }
      .courses-table th:nth-child(3), .courses-table td:nth-child(3) { width: 100px; }
      .courses-table th:nth-child(11), .courses-table td:nth-child(11) { width: 90px; }
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
      <a href="/instructor_homepage">Dashboard</a>
      <a href="/instructor/manage_courses" class="active">Manage Course</a>
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
      <!-- Search and Add Section -->
      <div class="search-add-section">
        <form action="/manage_courses/add" method="GET">
          <button type="submit" class="add-course-button">
            Add Course
          </button>
        </form>
      </div>

      <!-- Approved Courses Section -->
      <p class="section-header">Approved Courses</p>
      @if(isset($courses) && $courses->isEmpty())
          <div class="no-courses">No courses available.</div>
      @else
      <div class="table-wrapper">
          <div class="table-scroll">
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
                          <td class="course-description">{{ $course->description }}</td>
                          <td>{{ $course->category }}</td>
                          <td>{{ $course->video_count }}</td>
                          <td>{{ $course->approx_video_length }} mins</td>
                          <td>{{ $course->total_duration }} hrs</td>
                          <td class="course-price">{{ $course->price }}</td>
                          <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
      @endif

      <!-- Pending Courses Section -->
      <p class="section-header">Pending Courses</p>
      @if(isset($pendingCourses) && $pendingCourses->isEmpty())
          <div class="no-courses">No pending courses available.</div>
      @else
      <div class="table-wrapper">
          <div class="table-scroll">
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
                          <th>Status</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($pendingCourses as $course)
                      <tr>
                          <td>
                              @if($course->image)
                                  <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                              @else
                                  <span class="no-image-text">No image</span>
                              @endif
                          </td>
                          <td>
                              <a href="{{ url("/instructor/manage_resources/{$course->id}/modules") }}" class="course-title-link">{{ $course->title }}</a>
                          </td>
                          <td class="course-description">{{ $course->description }}</td>
                          <td>{{ $course->category }}</td>
                          <td>{{ $course->video_count }}</td>
                          <td>{{ $course->approx_video_length }} mins</td>
                          <td>{{ $course->total_duration }} hrs</td>
                          <td class="course-price">{{ $course->price }}</td>
                          <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                          <td>
                            @if(\App\Models\CourseNotification::where('pending_course_id', $course->id)->exists())
                              <span class="status-submitted">Submitted</span>
                            @else
                              <span class="status-not-submitted">Not Submitted</span>
                            @endif
                          </td>
                          <td>
                            <div class="actions-container">
                              <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="GET">
                                <button type="submit" class="edit-button">
                                  <svg class="edit-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                  </svg>
                                  Edit
                                </button>
                              </form>
                              <form action="/admin_panel/manage_courses/delete-course/{{ $course->id }}" method="POST">
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
      </div>
      @endif

      @else
      <div class="not-logged-in-container">
        <div class="not-logged-in">
          <p>You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
        </div>
      </div>
      @endauth
    </main>
  </div>
</body>
</html>