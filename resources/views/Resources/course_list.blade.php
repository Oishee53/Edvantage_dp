<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Courses</title>
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
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        /* Top bar - Matching Dashboard Style */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
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

        .logout-button, .login-button {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s ease-in-out;
        }

        .logout-button {
            background-color: var(--primary-color);
            color: white;
        }

        .logout-button:hover {
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

        /* Section Headers */
        .section-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 1.5rem 0;
        }

        /* Course Tables - Enhanced Card Style */
        .course-section {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .course-section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--edit-bg);
        }

        .course-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .course-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .course-table th {
            background-color: var(--body-background);
            color: var(--text-gray-500);
            font-weight: 500;
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.875rem;
        }

        .course-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-gray-700);
            vertical-align: middle;
        }

        .course-table tbody tr:hover {
            background-color: var(--body-background);
        }

        .course-table tbody tr:last-child td {
            border-bottom: none;
        }

        .course-table a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .course-table a:hover {
            text-decoration: underline;
        }

        /* Status Styling */
        .status-submitted {
            color: var(--green-600);
            font-weight: 600;
        }

        .status-not-submitted {
            color: var(--text-gray-500);
            font-weight: 500;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem;
            text-align: center;
            color: var(--text-gray-500);
            font-size: 0.875rem;
        }

        /* Back Link - Matching Dashboard Button Style */
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

        /* Not logged in state */
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
            }
        }

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
            
            .course-table {
                font-size: 0.75rem;
            }
            
            .course-table th,
            .course-table td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    @auth
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="/image/Edvantage.png" alt="Edvantage Logo">
                <span></span>
            </div>
            <nav class="sidebar-nav">
                @if(auth()->user()->role === 2)
                    <a href="/admin_panel">Dashboard</a>
                    <a href="/admin_panel/manage_courses">Manage Courses</a>
                    <a href="/admin_panel/manage_user">Manage Users</a>
                    <a href="/admin_panel/manage_resources" class="active">Manage Resources</a>
                     <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
                @elseif(auth()->user()->role === 3)
                    <a href="/instructor_homepage">Dashboard</a>
                    <a href="/instructor/manage_courses">Manage Courses</a>
                    <a href="/instructor/manage_resources/add" class="active">Manage Resources</a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Top bar -->
                <div class="top-bar">
                    <div class="top-bar-title">Manage Resources</div>
                    <div class="user-info">
                        <span>{{ auth()->user()->name }}</span>
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
                            <button class="logout-button">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- Approved Courses Section -->
                <div class="course-section">
                    <div class="course-section-header">
                        <h3 class="course-section-title">Approved Courses</h3>
                    </div>
                    @if($courses->isEmpty())
                        <div class="empty-state">
                            <p>No courses available.</p>
                        </div>
                    @else
                        <table class="course-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
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
                                            <a href="{{ url("/admin_panel/manage_resources/{$course->id}/modules") }}">
                                                {{ $course->title }}
                                            </a>
                                        </td>
                                        <td>{{ $course->description }}</td>
                                        <td>{{ $course->video_count }}</td>
                                        <td>{{ $course->approx_video_length }} mins</td>
                                        <td>{{ $course->total_duration }} hrs</td>
                                        <td>{{ $course->price }}</td>
                                        <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                @if(auth()->user()->role === 3)
                    <!-- Pending Courses Section -->
                    <div class="course-section">
                        <div class="course-section-header">
                            <h3 class="course-section-title">Pending Courses</h3>
                        </div>
                        @if($pendingCourses->isEmpty())
                            <div class="empty-state">
                                <p>No courses available.</p>
                            </div>
                        @else
                            <table class="course-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Videos</th>
                                        <th>Video Length</th>
                                        <th>Total Duration</th>
                                        <th>Price (৳)</th>
                                        <th>Added</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingCourses as $course)
                                        <tr>
                                            <td>
                                                <a href="{{ url("/instructor/manage_resources/{$course->id}/modules") }}">
                                                    {{ $course->title }}
                                                </a>
                                            </td>
                                            <td>{{ $course->description }}</td>
                                            <td>{{ $course->video_count }}</td>
                                            <td>{{ $course->approx_video_length }} mins</td>
                                            <td>{{ $course->total_duration }} hrs</td>
                                            <td>{{ $course->price }}</td>
                                            <td>{{ $course->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if(\App\Models\CourseNotification::where('pending_course_id', $course->id)->exists())
                                                    <span class="status-submitted">Submitted</span>
                                                @else
                                                    <span class="status-not-submitted">Not Submitted</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif
            </main>
        </div>

    @else
        <!-- Not logged in state -->
        <div style="width: 100%; display: flex; align-items: center; justify-content: center; min-height: 100vh;">
            <p class="not-logged-in">You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
        </div>
    @endauth
</body>
</html>