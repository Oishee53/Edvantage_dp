<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <style>
        :root {
            --primary-color: #0E1B33;
            --primary-light-hover-bg: #E3E6F3;
            --body-background: #f9fafb;
            --card-background: #ffffff;
            --text-default: #333;
            --text-gray-600: #4b5563;
            --text-gray-500: #6b7280;
            --border-color: #e5e7eb;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --error-color: #EF4444;
            --info-color: #3B82F6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--body-background);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 17.5rem;
            background-color: var(--card-background);
            min-height: 100vh;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
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
        }
        .sidebar-nav a {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
        }
        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: var(--primary-light-hover-bg);
            color: var(--primary-color);
            font-weight: 500;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
        }

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
            transition: 0.3s;
        }

        .logout-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            transition: 0.2s;
        }
        .logout-btn:hover {
            opacity: 0.9;
        }

        /* Dashboard Content Styles */
        .dashboard-content {
            flex: 1;
        }
        .welcome-section {
            color: var(--primary-color);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px -1px rgba(115, 118, 125, 0.3);
        }
        .welcome-title {
            font-size: 1.75rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .welcome-subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--card-background);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 1rem 1rem 0 0;
            background: linear-gradient(var(--primary-color));
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .stat-icon.approved {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }
        .stat-icon.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }
        .stat-icon.rejected {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
        }
        .stat-icon.earnings {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info-color);
        }
        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        .stat-label {
            font-size: 0.875rem;
            color: var(--text-gray-600);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .stat-trend {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .stat-trend.positive {
            color: var(--success-color);
        }
        .stat-trend.negative {
            color: var(--error-color);
        }
        .courses-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .section-card {
            background: var(--card-background);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .course-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .course-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.1);
        }
        .course-info h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        .course-info p {
            font-size: 0.875rem;
            color: var(--text-gray-600);
        }
        .course-students {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary-light-hover-bg);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.875rem;
        }

        .notifications {
            position: relative;
        }

        .notif-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.25rem;
            color: var(--primary-color);
            position: relative;
        }

        .notif-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--error-color);
            color: white;
            font-size: 0.75rem;
            padding: 2px 6px;
            border-radius: 50%;
            font-weight: 600;
        }

        .notif-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 2.5rem;
            width: 320px;
            background: var(--card-background);
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 100;
            overflow: hidden;
        }

        .notif-dropdown.show {
            display: block;
        }

        .notif-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mark-read {
            font-size: 0.75rem;
            color: var(--info-color);
            cursor: pointer;
        }

        .notif-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .notif-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-gray-600);
        }
        .notif-item.unread {
            background: var(--primary-light-hover-bg);
            font-weight: 600;
        }
        .notif-item:last-child {
            border-bottom: none;
        }
        .notif-time {
            font-size: 0.7rem;
            color: var(--text-gray-500);
        }
        .notif-empty {
            padding: 2rem 1rem;
            text-align: center;
            color: var(--text-gray-500);
            font-style: italic;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            backdrop-filter: blur(4px);
        }
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: var(--card-background);
            border-radius: 1rem;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-gray-500);
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        .close-btn:hover {
            background: var(--primary-light-hover-bg);
            color: var(--primary-color);
        }
        .student-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
        }
        .student-item:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.1);
        }
        .student-avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #2D336B);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.25rem;
        }
        .student-details h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }
        .student-details p {
            font-size: 0.875rem;
            color: var(--text-gray-600);
        }
        
        .mobile-menu-btn {
            display: none;
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .courses-section {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            }
        }
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
            .welcome-section {
                padding: 1.5rem;
            }
            .welcome-title {
                font-size: 1.5rem;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .stat-card {
                padding: 1.5rem;
            }
            .stat-value {
                font-size: 2rem;
            }
            .section-card {
                padding: 1.5rem;
            }
            .top-header {
                padding: 0;
                margin-bottom: 1rem;
            }
            .modal-content {
                padding: 1.5rem;
                width: 95%;
            }
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
            <a href="/instructor_homepage" class="active">Dashboard</a>
            <a href="/instructor/manage_courses">Manage Courses</a>
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
                <h1>Instructor Dashboard</h1>
            </div>
                    <div class="user-info">
                        <li class="nav-item dropdown notifications" style="list-style:none;">
                            <button class="notif-btn" onclick="toggleNotifications()">
                                <i class="fa fa-bell"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="notif-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                                @endif
                            </button>

                            <div id="notifDropdown" class="notif-dropdown">
                                <div class="notif-header">
                                    Notifications
                                </div>
                                <div class="notif-list">
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <div class="notif-item unread">
                                        @php
                                            // Decide route based on notification type
                                            switch ($notification->type) {
                                                case 'App\Notifications\approveCourseNotification':
                                                     $route = url("/admin_panel/manage_resources/{$notification->data['course_id']}/modules");
                                                    break;    
                                                case 'App\Notifications\rejectCourseNotification':
                                                    $route = route('rejected.course.show');
                                                    break;
                                                case 'App\Notifications\NewQuestionNotification':
                                                    $route = route('instructor.questions.show', $notification->data['question_id']); 
                                                    break;
                                                case 'App\Notifications\CourseUpdatedNotification':
                                                    $route = route('notifications.read', $notification->id);
                                                    break;
                                                default:
                                                    $route = route('notifications.read', $notification->id);
                                            }
                                        @endphp

                                        <a href="{{ $route }}" class="block">
                                            @if($notification->type === 'App\Notifications\approveCourseNotification')
                                                ✅ "{{ $notification->data['content'] }}".                                     
                                            @elseif($notification->type === 'App\Notifications\rejectCourseNotification')
                                                ❌ Course rejected: "{{ $notification->data['course_title'] }}".
                                            @elseif($notification->type === 'App\Notifications\NewQuestionNotification')
                                                ❓ New Question: "{{ $notification->data['content'] }}".
                                            @elseif($notification->type === 'App\Notifications\CourseUpdatedNotification')
                                                Important : "{{ $notification->data['content'] }}"
                                            @elseif($notification->type === 'App\Notifications\CourseDeleteNotification')
                                                Important : "{{ $notification->data['content'] }}"
                                            @endif

                                            <br>
                                            <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                                        </a>
                                    </div>

                                    @empty
                                        <div class="notif-empty">No new notifications</div>
                                    @endforelse
                                </div>
                            </div>
                        </li>

                        <a href="/homepage" class="student">Student</a>
                        <span>{{ Auth::user()->name }}</span>
                        <form action="/logout" method="POST" style="margin:0;">
                            @csrf
                            <button class="logout-btn">Logout</button>
                        </form>
                    </div>

        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <!-- Welcome Section -->
            <div class="welcome-section">
                <h2 class="welcome-title">Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="welcome-subtitle">Here's what's happening with your courses today</p>
            </div>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card approved"  onclick="window.location='/instructor/manage_courses'">
                    <div class="stat-value">{{ isset($approvedCourses) ? count($approvedCourses) : 0 }}</div>
                    <div class="stat-label">Approved Courses</div>
                </div>

                <div class="stat-card pending" onclick="window.location='/instructor/manage_courses'">
                    <div class="stat-value">{{ isset($pendingCourses) ? count($pendingCourses) : 0 }}</div>
                    <div class="stat-label">Pending Courses</div>
                </div>

                <div class="stat-card rejected" onclick="window.location='{{ route('rejected.course.show') }}'">
                    <div class="stat-value">{{ isset($rejectedCourses) ? count($rejectedCourses) : 0 }}</div>
                    <div class="stat-label">Rejected Courses</div>
                </div>

                <div class="stat-card earnings">
                    <div class="stat-value">৳{{ number_format($totalEarnings ?? 0, 2) }}</div>
                    <div class="stat-label">Total Earnings</div>
                </div>
            </div>

            <!-- Courses Section -->
            <div class="courses-section">
                <div class="section-card">
                    <h3 class="section-title">
                        <i class="fas fa-graduation-cap"></i>
                        My Courses
                    </h3>
                    @if(isset($coursesWithStudents) && count($coursesWithStudents) > 0)
                        @foreach($coursesWithStudents as $course)
                            <div class="course-item" onclick="showStudents('{{ addslashes($course->title) }}', '{{ $course->id }}')">
                                <div class="course-info">
                                    <h4>{{ $course->title }}</h4>
                                    <p>{{ Str::limit($course->description, 100) }}</p>
                                </div>
                                <div class="course-students">
                                    <i class="fas fa-users"></i> {{ $course->student_count ?? 0 }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 2rem; color: var(--text-gray-500);">
                            <i class="fas fa-book-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                            <p>No approved courses yet. Start by creating your first course!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Student Modal -->
        <div class="modal" id="studentsModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="modalTitle">Course Students</h3>
                    <button class="close-btn" onclick="closeModal()">&times;</button>
                </div>
                <div id="studentsContent"></div>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        function toggleNotifications() {
            document.getElementById('notifDropdown').classList.toggle('show');
        }

        // Course students data from Laravel
        const courseStudents = @json(
            isset($coursesWithStudents) ? 
            $coursesWithStudents->mapWithKeys(function($course) {
                return [$course->id => $course->students ?? []];
            }) : []
        );

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function showStudents(courseName, courseId) {
            const modal = document.getElementById('studentsModal');
            const modalTitle = document.getElementById('modalTitle');
            const studentsContent = document.getElementById('studentsContent');
            
            modalTitle.textContent = `${courseName} - Students`;
            const students = courseStudents[courseId] || [];
            let studentsHTML = '';

            if (students.length > 0) {
                students.forEach(student => {
                    const initials = student.name.split(' ').map(n => n[0]).join('');
                    const enrollDate = new Date(student.enroll_date).toLocaleDateString('en-US', {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric'
                    });
                    studentsHTML += `
                        <div class="student-item">
                            <div class="student-avatar">${initials}</div>
                            <div class="student-details">
                                <h4>${student.name}</h4>
                                <p>${student.email}</p>
                                <p style="font-size:0.75rem;color:var(--text-gray-500)">Enrolled: ${enrollDate}</p>
                            </div>
                        </div>
                    `;
                });
            } else {
                studentsHTML = '<p style="text-align:center;color:var(--text-gray-500);padding:2rem;">No students enrolled yet.</p>';
            }

            studentsContent.innerHTML = studentsHTML;
            modal.classList.add('show');
        }

        function closeModal() {
            document.getElementById('studentsModal').classList.remove('show');
        }

        function toggleNotifications() {
            document.getElementById('notifDropdown').classList.toggle('show');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('studentsModal');
            const notifDropdown = document.getElementById('notifDropdown');
            
            if (event.target === modal) {
                closeModal();
            }
            
            // Close notifications when clicking outside
            if (!event.target.closest('.notifications')) {
                notifDropdown.classList.remove('show');
            }
        });

        // Escape key to close modal
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
                document.getElementById('notifDropdown').classList.remove('show');
            }
        });
    </script>
</body>
</html>