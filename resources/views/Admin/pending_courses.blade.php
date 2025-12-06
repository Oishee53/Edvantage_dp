<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Courses for Review</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
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
            --success-color: #10b981;
            --success-bg: #d1fae5;
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

    /* Sidebar */
    .sidebar {
      width: 17.5rem; /* w-64 */
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
    }

    .sidebar-header {
      padding: 1.5rem; /* p-6 */
      display: flex;
      align-items: center;
      gap: 0.5rem; /* gap-2 */
      color: var(--primary-color);
      font-weight: 700; /* font-bold */
      font-size: 1.25rem; /* text-xl */
    }

    .sidebar-header img {
      height: 2.5rem; /* h-10 */
    }

    .sidebar-nav {
      margin-top: 2.5rem; /* mt-10 */
    }

    .sidebar-nav a {
      display: block;
      padding: 0.75rem 1.5rem; /* py-3 px-6 */
      color: var(--primary-color);
      font-weight: 500; /* font-medium */
      text-decoration: none;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .sidebar-nav a:hover {
      background-color: var(--primary-light-hover-bg); /* Changed hover background */
      color: #0E1B33;; /* Text color on hover */
    }

    /* Main content */
    .main-content {
      flex: 1; /* flex-1 */
      padding: 2rem; /* p-8 */
    }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem; /* mb-8 */
    }

    .top-bar-title {
      font-size: 1.5rem; /* text-2xl */
      font-weight: 400; /* font-semibold */
      color: var(--primary-color);
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 1rem; /* space-x-4 */
    }

    .user-info span {
      color: var(--primary-color);
      font-weight: 500; /* font-medium */
    }

    .logout-button {
      background-color: var(--primary-color);
      color: white;
      padding: 0.5rem 0.75rem; /* px-3 py-2 */
      border-radius: 0.25rem; /* rounded */
      border: none;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
    }

    .logout-button:hover {
      opacity: 0.9; /* hover:bg-opacity-90 */
    }

        .page-header {
            background: var(--card-background);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .success-message {
            background-color: var(--success-bg);
            color: var(--success-color);
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--success-color);
            font-weight: 500;
        }

        .table-container {
            background: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-gray-700);
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .action-link {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .action-link:hover {
            background-color: var(--primary-light-hover-bg);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-gray-500);
            font-style: italic;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/image/Edvantage.png" class="h-10" alt="Edvantage Logo">
        </div>
        <nav class="sidebar-nav">
            <a href="/admin_panel">Dashboard</a>
            <a href="/admin_panel/manage_courses">Manage Course</a>
            <a href="/admin_panel/manage_user">Manage User</a>
            <a href="/pending-courses" class="active">
                Manage Pending Courses ({{ count($pendingCourses) }})
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="top-bar-title">Pending Courses Management</div>
            @auth
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="logout-button">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <div class="page-header">
            <h2 class="page-title">Pending Courses for Review</h2>
        </div>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Instructor ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingCourses as $notification)
                        <tr>
                            <td>{{ $notification->pending_course_id }}</td>
                            <td>{{ $notification->instructor_id }}</td>
                            <td>
                                <span class="status-badge status-pending">
                                    {{ ucfirst($notification->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.courses.review', $notification->pending_course_id) }}" class="action-link">
                                    View Resources
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                No pending courses found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
