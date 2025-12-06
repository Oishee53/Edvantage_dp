<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Lectures - {{ $course->title }}</title>
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
            --warning-color: #f59e0b;
            --success-color: #059669;
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

        .logout-button {
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s ease-in-out;
            background-color: var(--primary-color);
            color: white;
        }

        .logout-button:hover {
            opacity: 0.9;
        }

        /* Course Header */
        .course-header {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .course-header h2 {
            color: var(--primary-color);
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .course-title {
            color: var(--text-gray-600);
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .progress-section {
            margin-top: 1.5rem;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: var(--edit-bg);
            border-radius: 5px;
            margin: 1rem 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--success-color) 0%, #10b981 100%);
            border-radius: 5px;
            transition: width 0.5s ease;
        }

        .progress-text {
            font-size: 0.875rem;
            color: var(--text-gray-600);
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Modules Section */
        .modules-section {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .modules-section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--edit-bg);
        }

        .modules-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .modules-list {
            display: flex;
            flex-direction: column;
        }

        .module-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease-in-out;
        }

        .module-item:last-child {
            border-bottom: none;
        }

        .module-item:hover {
            background-color: var(--body-background);
        }

        .module-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex: 1;
        }

        .module-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .upload-status {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .status-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 12px;
            flex-shrink: 0;
        }

        .status-uploaded {
            background-color: var(--success-color);
            color: white;
        }

        .status-pending {
            background-color: var(--warning-color);
            color: white;
        }

        .status-text {
            font-size: 0.875rem;
            color: var(--text-gray-600);
            font-weight: 500;
        }

        /* Module Actions */
        .module-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-shrink: 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease-in-out;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .btn-view {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .btn-view:hover {
            background-color: #047857;
            border-color: #047857;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #1a2645;
            border-color: #1a2645;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
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
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
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

            .module-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .module-info {
                width: 100%;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .module-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .course-header {
                padding: 1.5rem;
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
                    <a href="/admin_panel/manage_courses" class="active">Manage Courses</a>
                    <a href="/admin_panel/manage_user">Manage Users</a>
                    <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
                @elseif(auth()->user()->role === 3)
                    <a href="/instructor_homepage">Dashboard</a>
                    <a href="/instructor/manage_courses" class="active">Manage Courses</a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Top bar -->
                <div class="top-bar">
                    <div class="top-bar-title">Course Lectures</div>
                    <div class="user-info">
                        <span>{{ auth()->user()->name }}</span>
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
                            <button class="logout-button">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- Course Header -->
                @php
    $totalModules = count($modules);

    if(auth()->user()->role === 3) {
        // Students → Only quizzes count
        $completed = collect($modules)->where('quiz', true)->count();
    } else {
        // Instructors/Admins → Both quiz + resource must be true
        $completed = collect($modules)->filter(fn($m) => $m['quiz'] && $m['resource'])->count();
    }

    $progressPercentage = $totalModules > 0 
        ? round(($completed / $totalModules) * 100, 1) 
        : 0;
@endphp

<div class="progress-section">
    <div class="progress-bar">
        <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
    </div>
    <div class="progress-text">
        {{ $completed }} of {{ $totalModules }} lectures completed ({{ $progressPercentage }}%)
    </div>
</div>

                <!-- Modules Section -->
                <div class="modules-section">
                    <div class="modules-section-header">
                        <h3 class="modules-section-title">Lecture List</h3>
                    </div>
                    <div class="modules-list">
                        @foreach ($modules as $module)
                            <div class="module-item">
                                <div class="module-info">
                                    <div>
                                        <div class="module-title">Lecture {{ $module['id'] }}</div>
                                    </div>
                                    <div class="upload-status">
                                        @if(auth()->user()->role === 3)
                                            <div class="status-row">
                                                @if($module['quiz'])
                                                    <div class="status-icon status-uploaded">✓</div>
                                                    <div class="status-text">Quiz Uploaded</div>
                                                @else
                                                    <div class="status-icon status-pending">!</div>
                                                    <div class="status-text">Quiz Pending</div>
                                                @endif
                                            </div>
                                        @elseif(auth()->user()->role === 2)
                                            <div class="status-row">
                                                @if($module['quiz'])
                                                    <div class="status-icon status-uploaded">✓</div>
                                                    <div class="status-text">Quiz Uploaded</div>
                                                @else
                                                    <div class="status-icon status-pending">!</div>
                                                    <div class="status-text">Quiz Pending</div>
                                                @endif
                                            </div>
                                            <div class="status-row">
                                                @if($module['resource'])
                                                    <div class="status-icon status-uploaded">✓</div>
                                                    <div class="status-text">Resource Uploaded</div>
                                                @else
                                                    <div class="status-icon status-pending">!</div>
                                                    <div class="status-text">Resource Pending</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="module-actions">
                                    <a href="{{ route('inside.module2', ['courseId' => $course->id, 'moduleNumber' => $module['id']]) }}" 
                                       class="btn btn-view">
                                        <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        View
                                    </a>
                                    
                                    @if(auth()->user()->role === 2)
                                        <a href="{{ route('module.create', ['course' => $course->id, 'module' => $module['id']]) }}" 
                                           class="btn btn-primary">
                                            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                @if($module['resource'] || $module['quiz'])
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                @else
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14,2 14,8 20,8"></polyline>
                                                    <line x1="12" y1="18" x2="12" y2="12"></line>
                                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                                @endif
                                            </svg>
                                            {{ $module['resource'] || $module['quiz'] ? 'Edit Resources' : 'Upload Resources' }}
                                        </a>
                                    @elseif(auth()->user()->role === 3)
                                        <a href="{{ route('quiz.create', ['course' => $course->id, 'module' => $module['id']]) }}" 
                                           class="btn btn-primary">
                                            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                @if($module['quiz'])
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                @else
                                                    <path d="M9 11H3v4h6m1 0V9a2 2 0 0 1 2-2h2"></path>
                                                    <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                                    <line x1="12" y1="18" x2="12" y2="12"></line>
                                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                                @endif
                                            </svg>
                                            {{ $module['quiz'] ? 'Edit Quiz' : 'Upload Quiz' }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back Link -->
                <a href="javascript:history.back()" class="back-link">
                    Back 
                </a>
            </main>
        </div>

    @else
        <!-- Not logged in state -->
        <div class="not-logged-in-container">
            <div class="not-logged-in">
                <p>You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
            </div>
        </div>
    @endauth
</body>
</html>