<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Management</title>
    
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
            --instructor-bg: #FEF3C7;
            --instructor-icon: #D97706;
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
            z-index: 1000;
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
            width: calc(100% - 17.5rem);
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

        .page-header h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
        }

        .page-header p {
            color: var(--text-gray-600);
            margin: 0;
            font-size: 0.875rem;
        }

        /* Action Cards Grid */
        .action-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .action-card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            transition: box-shadow 0.2s ease-in-out;
        }

        .action-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .action-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .action-card-icon {
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-card-icon.view {
            background-color: var(--view-bg);
            color: var(--view-icon);
        }

        .action-card-icon.edit {
            background-color: var(--edit-bg);
            color: var(--edit-text);
        }

        .action-card-icon.instructor {
            background-color: var(--instructor-bg);
            color: var(--instructor-icon);
        }

        .action-card-icon i {
            font-size: 1.25rem;
        }

        .action-card-content h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.25rem 0;
        }

        .action-card-content p {
            color: var(--text-gray-600);
            font-size: 0.875rem;
            margin: 0;
        }

        .action-card-button {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            transition: opacity 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .action-card-button:hover {
            opacity: 0.9;
        }

        .action-card-button i {
            font-size: 0.875rem;
        }

        /* Stats Grid - Matching Dashboard Style */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--card-background);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .stat-card-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card-info {
            display: flex;
            flex-direction: column;
        }

        .stat-card-label {
            color: var(--text-gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .stat-card-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-card-icon {
            padding: 0.75rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card-icon.users {
            background-color: var(--primary-light-hover-bg);
            color: var(--primary-color);
        }

        .stat-card-icon.enrolled {
            background-color: var(--view-bg);
            color: var(--view-icon);
        }

        .stat-card-icon.new {
            background-color: var(--edit-bg);
            color: var(--edit-text);
        }

        .stat-card-icon.instructors {
            background-color: var(--instructor-bg);
            color: var(--instructor-icon);
        }

        .stat-card-icon i {
            font-size: 1.25rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .sidebar {
                width: 16rem;
            }
            
            .main-wrapper {
                margin-left: 16rem;
                width: calc(100% - 16rem);
            }

            .action-cards-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
            
            .main-content {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .action-cards-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .main-content {
                padding: 0.5rem;
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
            <a href="/admin_panel">Dashboard</a>
            <a href="/admin_panel/manage_courses">Manage Course</a>
            <a href="/admin_panel/manage_user" class="active">Manage User</a>
            <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top bar -->
            <div class="top-bar">
                <div class="top-bar-title">User Management</div>
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
                <h2>Student Management</h2>
                <p>Manage and view student information and enrollments</p>
            </div>

            <!-- Action Cards -->
            <div class="action-cards-grid">
                <!-- View Enrolled Students Card -->
                <div class="action-card">
                    <div class="action-card-header">
                        <div class="action-card-content">
                            <h3>Enrolled Students</h3>
                            <p>View students who are enrolled in courses</p>
                        </div>
                    </div>
                    <form action="/admin_panel/manage_user/view_enrolled_student" method="GET">
                        <button type="submit" class="action-card-button">
                            <i class="fas fa-list"></i>
                            View Enrolled Students
                        </button>
                    </form>
                </div>

                <!-- View All Students Card -->
                <div class="action-card">
                    <div class="action-card-header">
                        <div class="action-card-content">
                            <h3>All Students</h3>
                            <p>View complete list of all registered students</p>
                        </div>
                    </div>
                    <form action="/admin_panel/manage_user/view_all_student" method="GET">
                        <button type="submit" class="action-card-button">
                            <i class="fas fa-list"></i>
                            View All Students
                        </button>
                    </form>
                </div>

                <!-- View All Instructors Card -->
                <div class="action-card">
                    <div class="action-card-header">
                        <div class="action-card-content">
                            <h3>Instructors</h3>
                            <p>View all users who registered as instructors</p>
                        </div>
                    </div>
                    <form action="/admin_panel/manage_user/view_all_instructors" method="GET">
                        <button type="submit" class="action-card-button">
                            <i class="fas fa-list"></i>
                            View All Instructors
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <div class="stat-card-label">Total Students</div>
                            <div class="stat-card-value">{{ $totalStudents ?? 156 }}</div>
                        </div>
                        <div class="stat-card-icon users">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <div class="stat-card-label">Enrolled Students</div>
                            <div class="stat-card-value">{{ $enrolledStudents ?? 89 }}</div>
                        </div>
                        <div class="stat-card-icon enrolled">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-content">
                        <div class="stat-card-info">
                            <div class="stat-card-label">Total Instructors</div>
                            <div class="stat-card-value">{{ $totalInstructors ?? 24 }}</div>
                        </div>
                        <div class="stat-card-icon instructors">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>