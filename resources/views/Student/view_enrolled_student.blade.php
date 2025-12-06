<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enrolled Students</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    
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
            --view-bg: #ECFDF5;
            --view-icon: #16A34A;
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

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 17.5rem;
            flex: 1;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
        }

        /* Top bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .top-bar-title {
            font-size: 1.5rem;
            font-weight: 400;
            color: var(--primary-color);
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
            margin-top:1rem;
            
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
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

        /* Page Header Section */
        .page-header {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .page-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-header-icon {
            background-color: var(--view-bg);
            color: var(--view-icon);
            padding: 0.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-header-icon i {
            font-size: 1.25rem;
        }

        .page-header-text h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.25rem 0;
        }

        .page-header-text p {
            color: var(--text-gray-600);
            margin: 0;
            font-size: 0.875rem;
        }

        /* Course Cards */
        .courses-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .course-card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.2s ease-in-out;
            overflow: hidden;
        }

        .course-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .course-card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem;
        }

        .course-card-header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .course-card-info h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .course-card-stats {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .course-card-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .course-card-body {
            padding: 1.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-state-icon {
            background-color: var(--primary-light-hover-bg);
            color: var(--text-gray-500);
            padding: 1rem;
            border-radius: 50%;
            width: 4rem;
            height: 4rem;
            margin: 0 auto 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon i {
            font-size: 1.5rem;
        }

        .empty-state h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-gray-700);
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            color: var(--text-gray-500);
            font-size: 0.875rem;
            margin: 0;
        }

        /* Students Table */
        .students-table-container {
            overflow-x: auto;
        }

        .students-table {
            width: 100%;
            border-collapse: collapse;
        }

        .students-table th {
            text-align: left;
            padding: 0.75rem 1rem;
            font-weight: 600;
            color: var(--primary-color);
            border-bottom: 2px solid var(--border-color);
            font-size: 0.875rem;
        }

        .students-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .students-table tr:hover {
            background-color: #f9fafb;
        }

        .student-id-badge {
            background-color: var(--primary-light-hover-bg);
            color: var(--primary-color);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 2rem;
            height: 2rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .student-name {
            font-weight: 500;
            color: var(--text-gray-700);
        }

        .student-email, .student-phone {
            color: var(--text-gray-600);
            font-size: 0.875rem;
        }

        .unenroll-button {
            background-color: var(--delete-bg);
            color: var(--delete-icon);
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .unenroll-button:hover {
            background-color: #fca5a5;
        }

        /* No Courses State */
        .no-courses-state {
            background-color: var(--card-background);
            padding: 3rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .no-courses-icon {
            background-color: var(--primary-light-hover-bg);
            color: var(--text-gray-500);
            padding: 1.5rem;
            border-radius: 50%;
            width: 5rem;
            height: 5rem;
            margin: 0 auto 1.5rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .no-courses-icon i {
            font-size: 2rem;
        }

        .no-courses-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-gray-700);
            margin: 0 0 0.5rem 0;
        }

        .no-courses-state p {
            color: var(--text-gray-500);
            margin: 0 0 1.5rem 0;
        }

        .create-course-button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease-in-out;
        }

        .create-course-button:hover {
            opacity: 0.9;
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

            .students-table-container {
                overflow-x: scroll;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .top-bar-left {
                flex-direction: column;
                align-items: flex-start;
            }
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
            <a href="/admin_panel/dashboard">Dashboard</a>
            <a href="/admin_panel/manage_courses">Manage Course</a>
            <a href="/admin_panel/manage_user" class="active">Manage User</a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top bar -->
            <div class="top-bar">
                <div class="top-bar-left">
                    <div class="top-bar-title">Enrolled Students</div>
                </div>
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

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-header-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="page-header-text">
                        <h2>Enrolled Students Per Course</h2>
                        <p>View and manage students enrolled in each course</p>
                    </div>
                </div>
            </div>

            <!-- Courses Container -->
            <div class="courses-container">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-card-header">
                            <div class="course-card-header-content">
                                <div class="course-card-info">
                                    <h3>{{ $course->title }}</h3>
                                    <div class="course-card-stats">
                                        <i class="fas fa-users"></i>
                                        <span>{{ $course->students->count() }} Students Enrolled</span>
                                    </div>
                                </div>
                                <div class="course-card-badge">{{ $course->students->count() }}</div>
                            </div>
                        </div>
                        <div class="course-card-body">
                            @if($course->students->isEmpty())
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-user-slash"></i>
                                    </div>
                                    <h4>No students enrolled in this course</h4>
                                    <p>Students will appear here once they enroll</p>
                                </div>
                            @else
                                <div class="students-table-container">
                                    <table class="students-table">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($course->students as $student)
                                                <tr>
                                                    <td>
                                                        <span class="student-id-badge">#{{ $student->id }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="student-info">
                                                            <div class="student-avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                                                            <span class="student-name">{{ $student->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="student-email">{{ $student->email }}</td>
                                                    <td class="student-phone">{{ $student->phone }}</td>
                                                    <td>
                                                        <form action="/admin_panel/manage_user/unenroll_student/{{$course->id}}/{{$student->id}}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="unenroll-button" onclick="return confirm('Are you sure you want to unenroll {{ $student->name }} from {{ $course->title }}?')">
                                                                <i class="fas fa-user-minus"></i>
                                                                Unenroll
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($courses->isEmpty())
                    <div class="no-courses-state">
                        <div class="no-courses-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>No Courses Available</h3>
                        <p>There are no courses created yet.</p>
                        <a href="/admin_panel/manage_courses" class="create-course-button">
                            <i class="fas fa-plus"></i>
                            Create Course
                        </a>
                    </div>
                @endif
            </div>
            <a href="/admin_panel/manage_user" class="back-link">
                 Back
            </a>
        </main>
    </div>
</body>
</html>