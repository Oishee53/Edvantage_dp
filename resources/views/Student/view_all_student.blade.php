<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Students</title>
    
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
            margin-top:-1rem;
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
            justify-content: space-between;
        }

        .page-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-header-icon {
            background-color: var(--edit-bg);
            color: var(--edit-text);
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

        .students-count-badge {
            background-color: var(--primary-light-hover-bg);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Search and Filter Bar */
        .search-filter-bar {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .search-filter-content {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .search-input-container {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray-500);
        }

        .export-button {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease-in-out;
            white-space: nowrap;
        }

        .export-button:hover {
            opacity: 0.9;
        }

        /* Students Grid */
        .students-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .student-card {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.2s ease-in-out;
            overflow: hidden;
        }

        .student-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .student-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .student-card-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .student-avatar {
            width: 3rem;
            height: 3rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            font-weight: 600;
        }

        .student-info h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-gray-700);
            margin: 0 0 0.25rem 0;
        }

        .student-id-badge {
            background-color: var(--primary-light-hover-bg);
            color: var(--primary-color);
            padding: 0.125rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .student-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .student-detail {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-detail-icon {
            width: 2rem;
            height: 2rem;
            background-color: #f3f4f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .student-detail-icon i {
            font-size: 0.875rem;
            color: var(--text-gray-500);
        }

        .student-detail-content {
            flex: 1;
        }

        .student-detail-label {
            font-size: 0.75rem;
            color: var(--text-gray-500);
            margin-bottom: 0.125rem;
        }

        .student-detail-value {
            font-weight: 500;
            color: var(--text-gray-700);
            font-size: 0.875rem;
        }

        .student-card-actions {
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        .student-actions-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .student-action-button {
            flex: 1;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            transition: background-color 0.2s ease-in-out;
        }

        .view-button {
            background-color: var(--view-bg);
            color: var(--view-icon);
        }

        .view-button:hover {
            background-color: #d1fae5;
        }

        .edit-button {
            background-color: var(--edit-bg);
            color: var(--edit-text);
        }

        .edit-button:hover {
            background-color: #dbeafe;
        }

        /* Empty State */
        .empty-state {
            background-color: var(--card-background);
            padding: 3rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-center;
        }

        .empty-state-icon {
            background-color: #f3f4f6;
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

        .empty-state-icon i {
            font-size: 2rem;
        }

        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-gray-700);
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            color: var(--text-gray-500);
            margin: 0;
        }

        /* Results Footer */
        .results-footer {
            background-color: var(--card-background);
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            text-align: center;
        }

        .results-footer p {
            color: var(--text-gray-600);
            margin: 0;
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .search-filter-content {
                flex-direction: row;
                align-items: center;
            }
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 16rem;
            }
            
            .main-wrapper {
                margin-left: 16rem;
            }

            .students-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
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

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .top-bar-left {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .students-grid {
                grid-template-columns: 1fr;
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
                    <div class="top-bar-title">All Students</div>
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
                    <div class="page-header-left">
                        <div class="page-header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="page-header-text">
                            <h2>All Registered Students</h2>
                            <p>Complete list of all students in the system</p>
                        </div>
                    </div>
                    <div class="students-count-badge">
                        {{ count($students) }} Students
                    </div>
                </div>
            </div>

            <!-- Students Content -->
            @if($students->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h3>No Students Found</h3>
                    <p>There are no registered students in the system yet.</p>
                </div>
            @else
                <div class="students-grid" id="studentsGrid">
                    @foreach($students as $student)
                        <div class="student-card" 
                             data-name="{{ strtolower($student->name) }}" 
                             data-email="{{ strtolower($student->email) }}" 
                             data-phone="{{ $student->phone }}">
                            <!-- Student Header -->
                            <div class="student-card-header">
                                <div class="student-card-header-content">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div class="student-info">
                                        <h3>{{ $student->name }}</h3>
                                        <span class="student-id-badge">ID: #{{ $student->id }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Student Details -->
                            <div class="student-card-body">
                                <div class="student-detail">
                                    <div class="student-detail-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="student-detail-content">
                                        <div class="student-detail-label">Email</div>
                                        <div class="student-detail-value">{{ $student->email }}</div>
                                    </div>
                                </div>

                                <div class="student-detail">
                                    <div class="student-detail-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="student-detail-content">
                                        <div class="student-detail-label">Phone</div>
                                        <div class="student-detail-value">{{ $student->phone ?? 'Not provided' }}</div>
                                    </div>
                                </div>

                                <div class="student-detail">
                                    <div class="student-detail-icon">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <div class="student-detail-content">
                                        <div class="student-detail-label">Joined</div>
                                        <div class="student-detail-value">{{ $student->created_at ? $student->created_at->format('M d, Y') : 'Unknown' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Back Link -->
                <a href="javascript:history.back()" class="back-link">
                    Back 
                </a>
            @endif
        </main>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const studentCards = document.querySelectorAll('.student-card');
            let visibleCount = 0;
            
            studentCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const email = card.getAttribute('data-email');
                const phone = card.getAttribute('data-phone') || '';
                
                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update results footer
            const resultsFooter = document.querySelector('.results-footer p');
            if (resultsFooter) {
                resultsFooter.textContent = `Showing ${visibleCount} students${searchTerm ? ` matching "${this.value}"` : ''}`;
            }
        });
    </script>
</body>
</html>