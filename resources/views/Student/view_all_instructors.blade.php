<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instructor List</title>
    
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
            --instructor-bg: #dedcd5;
            --instructor-icon: #6f85b4;
            --warning-bg: #dedcd5;
            --warning-text: #92400E;
            --sidebar-width: 17.5rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--body-background);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Layout Container */
        .layout-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar - Matching Dashboard Style */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--card-background);
            min-height: 100vh;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
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
            width: auto;
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
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 100%;
            overflow-x: hidden;
        }

        /* Top bar */
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
            margin: 0;
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
            white-space: nowrap;
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-header-icon {
            padding: 0.75rem;
            border-radius: 0.5rem;
            background-color: var(--instructor-bg);
            color: var(--instructor-icon);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .page-header-icon i {
            font-size: 1.5rem;
        }

        .page-header-text {
            min-width: 0;
        }

        .page-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.25rem 0;
        }

        .page-header p {
            color: var(--text-gray-600);
            margin: 0;
            font-size: 0.875rem;
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
            font-size: 0.875rem;
            margin-top: -1rem;
            align-self: flex-start;
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }

        /* Table Container */
        .table-container {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .table-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .instructor-count {
            background-color: var(--instructor-bg);
            color: var(--instructor-icon);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
        }

        /* Table Scroll Wrapper */
        .table-scroll {
            overflow-x: auto;
            overflow-y: visible;
        }

        /* Table Styles */
        .instructor-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .instructor-table thead {
            background-color: var(--body-background);
        }

        .instructor-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: var(--text-gray-700);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }

        .instructor-table td {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .instructor-table tbody tr:hover {
            background-color: var(--body-background);
        }

        .instructor-id {
            font-weight: 600;
            color: var(--primary-color);
            white-space: nowrap;
        }

        .instructor-name {
            font-weight: 500;
            color: var(--text-default);
            white-space: nowrap;
        }

        .instructor-email {
            color: var(--text-gray-600);
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .instructor-phone {
            color: var(--text-gray-600);
            white-space: nowrap;
        }

        .instructor-expertise,
        .instructor-qualifications {
            color: var(--text-gray-600);
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .instructor-bio {
            color: var(--text-gray-600);
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .instructor-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
            min-width: fit-content;
        }

        /* Action Buttons */
        .action-button {
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: opacity 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .action-button:hover {
            opacity: 0.9;
        }

        .action-button.view {
            background-color: var(--view-bg);
            color: var(--view-icon);
        }

        .action-button.unenroll {
            background-color: var(--warning-bg);
            color: var(--warning-text);
        }

        .action-button.delete {
            background-color: var(--delete-bg);
            color: var(--delete-icon);
        }

        .action-button i {
            font-size: 0.75rem;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-gray-500);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.875rem;
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 16rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
            }
            
            .main-content {
                padding: 1rem;
                padding-top: 4rem;
            }

            .top-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .page-header-content {
                width: 100%;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .instructor-table th,
            .instructor-table td {
                padding: 0.75rem 1rem;
            }

            .instructor-actions {
                flex-direction: column;
                gap: 0.25rem;
                width: 100%;
                min-width: 120px;
            }

            .action-button {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.5rem;
                padding-top: 4rem;
            }

            .instructor-table {
                min-width: 600px;
            }

            .instructor-table th,
            .instructor-table td {
                padding: 0.5rem;
            }

            .table-header {
                padding: 1rem;
            }

            .page-header {
                padding: 1rem;
            }
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="layout-container">
        <!-- Mobile Sidebar Toggle -->
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
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
                    <h1 class="top-bar-title">Instructor Management</h1>
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
                        <div class="page-header-text">
                            <h2>Instructor List</h2>
                            <p>Manage and view all registered instructors</p>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="table-title">All Instructors</h3>
                        <div class="instructor-count">{{ count($users ?? []) }} Instructors</div>
                    </div>
                    
                    <div class="table-scroll">
                        @if(isset($users) && count($users) > 0)
                            <table class="instructor-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Area of Expertise</th>
                                        <th>Qualification</th>
                                        <th>Bio</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="instructor-id">#{{ $user->id }}</td>
                                        <td class="instructor-name">{{ $user->name }}</td>
                                        <td class="instructor-email">{{ $user->email }}</td>
                                        <td class="instructor-phone">{{ $user->phone ?? 'N/A' }}</td>
                                        <td class="instructor-expertise">{{ $user->instructor->area_of_expertise ?? 'N/A' }}</td>
                                        <td class="instructor-qualifications">{{ $user->instructor->qualification ?? 'N/A' }}</td>
                                        <td class="instructor-bio">{{ $user->instructor->bio ?? 'N/A' }}</td>
                                    
                                        <td>
                                            <div class="instructor-actions">
                                                <a href="/admin_panel/manage_user/unenroll_instructor/{{$user->id}}" class="action-button unenroll">
                                                    <i class="fas fa-user-times"></i>
                                                    Unenroll
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <h3>No Instructors Found</h3>
                                <p>There are currently no instructors registered in the system.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Back Link -->
                <a href="javascript:history.back()" class="back-link">
                    Back
                </a>
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        // Close sidebar when clicking on a link on mobile
        document.querySelectorAll('.sidebar-nav a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    toggleSidebar();
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.sidebar-overlay');
                
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            }
        });
    </script>
</body>
</html>