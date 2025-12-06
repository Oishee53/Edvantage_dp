<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Question - Instructor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Updated font weights to match dashboard exactly (400, 600, 700) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Updated CSS variables to match dashboard exactly */
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
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        /* Updated body to use flex layout like dashboard */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--body-background);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Updated sidebar to match dashboard exactly */
        .sidebar {
            width: 17.5rem;
            background-color: var(--card-background);
            min-height: 100vh;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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

        /* Updated sidebar nav spacing to match dashboard */
        .sidebar-nav {
            margin-top: 2.5rem;
        }

        .sidebar-nav a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .sidebar-nav a:hover {
            background-color: var(--primary-light-hover-bg);
            color: #0E1B33;
        }

       

        /* Updated main content to use flex-1 like dashboard */
        .main-content {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
        }

        /* Updated top header to match dashboard top-bar styling */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .top-header h1 {
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

        .student {
            display: inline-block;
            padding: 8px 16px;
            background-color: #f9fafb;
            color: #0E1B33;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        /* Added notification icon and badge styling */
        .notification-container {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease-in-out;
             background-color: var(--primary-light-hover-bg);
        }


        
        .notification-icon {
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: linear-gradient(135deg, #10B981, #34D399);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.125rem 0.375rem;
            border-radius: 9999px;
            min-width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s ease-in-out;
        }

        .logout-btn:hover {
            opacity: 0.9;
        }

        /* Question Content Styling */
        .content-area {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .question-card {
            background: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            min-width: 500px;
            max-width: 700px;
            width: 100%;
        }

        .question-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .question-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, #10B981, #34D399);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .question-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .question-content {
            margin-bottom: 1.5rem;
        }

        .question-content h2 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .question-text {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid var(--primary-color);
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-default);
            margin-bottom: 1rem;
        }

        .question-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-gray-600);
            margin-bottom: 1.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.answered {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .answer-section {
            background: #f0f9ff;
            padding: 1.25rem;
            border-radius: 0.5rem;
            border: 1px solid #e0f2fe;
            margin-bottom: 1.5rem;
        }

        .answer-section h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .answer-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-default);
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1.5px solid #E3E6F3;
            background: #f8fafc;
            font-size: 0.9rem;
            color: var(--text-default);
            font-family: inherit;
            transition: border 0.18s, box-shadow 0.18s;
            box-shadow: 0 1.5px 8px rgba(14, 27, 51, 0.03);
            min-height: 100px;
            resize: vertical;
        }

        textarea:focus {
            border: 1.5px solid #0E1B33;
            outline: 2px solid #0E1B33;
            background: var(--card-background);
            box-shadow: 0 0 0 2px rgba(14, 27, 51, 0.07);
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.15);
        }

        .btn-primary:hover {
            background: #0A1426;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.15);
        }

        .btn-danger:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.18s;
            padding: 0.5rem 0;
        }

        .back-link:hover {
            color: #0A1426;
            text-decoration: underline;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                min-height: auto;
                order: 2;
                transform: translateY(100%);
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                transition: transform 0.3s;
            }
            
            .sidebar.open {
                transform: translateY(0);
            }
            
            .main-content {
                order: 1;
                padding: 1rem;
            }
            
            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                font-size: 1.2rem;
                color: var(--primary-color);
                cursor: pointer;
            }
            
            .question-card {
                padding: 1.5rem;
                min-width: 0;
                max-width: 100%;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .top-header {
                margin-bottom: 1rem;
            }
        }

        .mobile-menu-btn {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="/image/Edvantage.png" alt="Edvantage Logo">
        </div>
        <nav class="sidebar-nav">            
            <<a href="/instructor_homepage">Dashboard</a>
            <a href="/instructor/manage_courses">Manage Course</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1>View Question</h1>
            </div>
            @auth
                <div class="user-info">
                    <a href="/homepage" class="student">Student</a>
                    <div class="notification-container" title="Notifications">
                        <i class="fas fa-bell notification-icon"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST" style="margin: 0;">
                        @csrf
                        <button class="logout-btn">Logout</button>
                    </form>
                </div>
            @else
                <div style="display: flex; gap: 8px;">
                    <a href="/login" style="border: 1px solid var(--primary-color); color: var(--primary-color); padding: 8px 16px; border-radius: 4px; text-decoration: none;">Login</a>
                    <a href="/register" style="background: var(--primary-color); color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Sign Up</a>
                </div>
            @endauth
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <div class="question-card">
                <!-- Question Header -->
                <div class="question-header">
                   
                    <h1 class="question-title">Student Question</h1>
                </div>

                <!-- Question Content -->
                <div class="question-content">
                    <h2><i class="fas fa-comment-dots"></i> Question:</h2>
                    <div class="question-text">
                        {{ $question->content }}
                    </div>
                    
                    <div class="question-meta">
                        <i class="fas fa-user"></i>
                        <strong>Asked by:</strong> {{ $question->user->name }}
                        <span style="margin-left: auto;">
                            <div class="status-badge {{ $question->status }}">
                                @if($question->status === 'pending')
                                    <i class="fas fa-clock"></i> Pending
                                @elseif($question->status === 'answered')
                                    <i class="fas fa-check-circle"></i> Answered
                                @else
                                    <i class="fas fa-times-circle"></i> Rejected
                                @endif
                            </div>
                        </span>
                    </div>
                </div>

                @if ($question->status === 'pending')
                    <!-- Answer Form -->
                    <div class="form-section">
                        <form method="POST" action="{{ route('instructor.answer', $question->id) }}">
                            @csrf
                            <div class="form-group">
                                <label for="answer"><i class="fas fa-reply"></i> Your Answer:</label>
                                <textarea name="answer" id="answer" placeholder="Write your detailed answer here..." required></textarea>
                            </div>
                            
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i>
                                    Submit Answer
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('instructor.reject', $question->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this question?')">
                                <i class="fas fa-times"></i>
                                Reject Question
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Display Answer if exists -->
                    @if ($question->answer)
                        <div class="answer-section">
                            <h3><i class="fas fa-check-circle"></i> Answer:</h3>
                            <div class="answer-text">{{ $question->answer }}</div>
                        </div>
                    @endif
                @endif

                <!-- Back Link -->
                <a href="{{ url()->previous() }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </a>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuBtn.contains(event.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>
