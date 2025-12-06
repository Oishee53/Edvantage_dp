<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Lecture Resources</title>
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
            --success-bg: #4CAF50;
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

        /* Alert Messages */
        .alert {
            background-color: var(--success-bg);
            color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        /* Course Info Section */
        .course-info {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .course-info h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0 0 0.5rem 0;
        }

        .module-info {
            color: var(--text-gray-600);
            font-size: 1rem;
            margin: 0;
        }

        /* Resource Section */
        .resource-section {
            background-color: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .resource-section-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--edit-bg);
        }

        .resource-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .resource-content {
            padding: 1.5rem;
        }

        .resource-item {
            margin-bottom: 1.5rem;
        }

        .resource-item:last-child {
            margin-bottom: 0;
        }

        .resource-label {
            font-weight: 600;
            color: var(--text-gray-700);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            font-size: 0.875rem;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #1a2645;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }

        .btn-success {
            background-color: var(--green-600);
            color: white;
        }

        .btn-success:hover {
            background-color: #047857;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.2);
        }

        /* Video Player Container */
        .video-container {
            margin-top: 1rem;
            display: none;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        #mux-player {
            width: 100%;
            max-width: 720px;
            border-radius: 0.5rem;
        }

        /* Quiz Section */
        .quiz-info {
            color: var(--text-gray-600);
            font-style: italic;
            margin: 0;
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
            width: 20px;
            height: 20px;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem;
            text-align: center;
            color: var(--text-gray-500);
            font-size: 0.875rem;
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
            
            .course-info, .resource-content {
                padding: 1rem;
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
                    <a href="/instructor/manage_user">Manage Users</a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Top bar -->
                <div class="top-bar">
                    <div class="top-bar-title">Lecture Resources</div>
                    <div class="user-info">
                        <span>{{ auth()->user()->name }}</span>
                        <form action="/logout" method="POST" style="display: inline;">
                            @csrf
                            <button class="logout-button">Logout</button>
                        </form>
                    </div>
                </div>

                <!-- Alert Message -->
                @if(session('error'))
                    <div class="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Course Information -->
                <div class="course-info">
                    <h2>Lecture Resources for Course: {{ $course->name }}</h2>
                    <p class="module-info">Lecture Number: {{ $moduleNumber }}</p>
                </div>

                <!-- Video Content Section -->
                @if($resource->videos)
                    <div class="resource-section">
                        <div class="resource-section-header">
                            <h3 class="resource-section-title">
                                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                </svg>
                                Video Content
                            </h3>
                        </div>
                        <div class="resource-content">
                            <div class="resource-item">
                                <div class="resource-label">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polygon points="10,8 16,12 10,16 10,8"></polygon>
                                    </svg>
                                    Interactive Video Lesson
                                </div>
                                <button class="btn btn-primary" onclick="toggleVideo()">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                    </svg>
                                    View Video
                                </button>
                                
                                <div id="videoPlayer" class="video-container">
                                    <mux-player 
                                        id="mux-player"
                                        playback-id="{{ $resource->videos }}"
                                        stream-type="on-demand"
                                        controls
                                        style="width: 100%; max-width: 720px;">
                                    </mux-player>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PDF Content Section -->
                @if($resource->pdf)
                    <div class="resource-section">
                        <div class="resource-section-header">
                            <h3 class="resource-section-title">
                                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14,2 14,8 20,8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10,9 9,9 8,9"></polyline>
                                </svg>
                                Course Materials
                            </h3>
                        </div>
                        <div class="resource-content">
                            <div class="resource-item">
                                <div class="resource-label">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14,2 14,8 20,8"></polyline>
                                    </svg>
                                    PDF Document
                                </div>
                                <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
                                   target="_blank"
                                   rel="noopener noreferrer" 
                                   class="btn btn-outline">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    View PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quiz Section -->
                <div class="resource-section">
                    <div class="resource-section-header">
                        <h3 class="resource-section-title">
                            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 11H3v4h6m1 0V9a2 2 0 0 1 2-2h2"></path>
                                <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                                <path d="M8.5 8.5a2.5 2.5 0 0 1 0-5"></path>
                            </svg>
                            Lecture Assessment
                        </h3>
                    </div>
                    <div class="resource-content">
                        <div class="resource-item">
                            @if($quiz)
                                <div class="resource-label">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Quiz Available
                                </div>
                                <a href="#" class="btn btn-success">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    View Quiz
                                </a>
                            @else
                                <div class="resource-label">
                                    <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Quiz Status
                                </div>
                                <p class="quiz-info">No quiz available for this lecture.</p>
                            @endif
                        </div>
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
                <p><em>Please log in to access course material</em></p>
                <a href="/" class="login-link">Go to Login</a>
            </div>
        </div>
    @endauth

    <!-- Mux Player Script -->
    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>

    <script>
        function toggleVideo() {
            const playerWrapper = document.getElementById('videoPlayer');
            const player = document.getElementById('mux-player');
            playerWrapper.style.display = (playerWrapper.style.display === 'none') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const player = document.getElementById('mux-player');
            if (!player) return;

            let lastSavedProgress = 0;

            player.addEventListener('timeupdate', async function () {
                const progressPercent = (player.currentTime / player.duration) * 100;

                if (progressPercent - lastSavedProgress >= 10) {
                    lastSavedProgress = progressPercent;

                    await fetch('{{ route("video.progress.save") }}', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            course_id: {{ $course->id }},
                            resource_id: {{ $resource->id }},
                            progress_percent: progressPercent
                        })
                    });
                }
            });

            player.addEventListener('ended', async function () {
                await fetch('{{ route("video.progress.save") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        course_id: {{ $course->id }},
                        resource_id: {{ $resource->id }},
                        progress_percent: 100
                    })
                });
            });
        });
    </script>
</body>
</html>