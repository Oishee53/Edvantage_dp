<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Course</title>
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

        /* Updated sidebar to match dashboard exactly - removed fixed positioning */
        .sidebar {
            @if(auth()->user() && auth()->user()->role === 2)
                width: 17.5rem;
            @elseif(auth()->user() && auth()->user()->role === 3)
                width: 15rem;
            @endif
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

        .sidebar-nav a.active {
            background-color: var(--primary-light-hover-bg);
            color: #0E1B33;
            font-weight: 600;
        }

        /* Updated main content to use flex-1 like dashboard, removed margin-left */
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

        /* Form Content */
        .content-area {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .form-card {
            background: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            min-width: 400px;
            max-width: 520px;
            width: 100%;
            font-size: 0.9rem;
        }

        .form-card h2 {
            font-size: 1.125rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .required {
            color: #DC2626;
            font-size: 1em;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1.5px solid #E3E6F3;
            background: #f8fafc;
            font-size: 0.85rem;
            color: var(--text-default);
            font-family: inherit;
            transition: border 0.18s, box-shadow 0.18s;
            box-shadow: 0 1.5px 8px rgba(14, 27, 51, 0.03);
        }

        input[type="file"] {
            background: var(--card-background);
            font-size: 0.85rem;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border: 1.5px solid #0E1B33;
            outline: 2px solid #0E1B33;
            background: var(--card-background);
            box-shadow: 0 0 0 2px rgba(14, 27, 51, 0.07);
        }

        textarea {
            min-height: 56px;
            resize: vertical;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px 0;
            font-size: 0.9rem;
            background: var(--primary-color);
            color: #fff;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.07);
            transition: background 0.2s, transform 0.18s;
            margin-top: 10px;
            letter-spacing: 0.2px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button[type="submit"]:hover,
        button[type="submit"]:focus {
            background: #0A1426;
            transform: translateY(-1px) scale(1.01);
        }

        .back-link {
            display: inline-block;
            margin-top: 14px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            text-align: center;
            transition: color 0.18s;
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
            
            .form-card {
                padding: 1rem;
                min-width: 0;
                max-width: 98vw;
                font-size: 0.85rem;
            }
            
            .form-card h2 { font-size: 1rem; }
            label, input, select, textarea, .back-link { font-size: 0.8rem; }
            button[type="submit"] { font-size: 0.85rem; }
            
            .top-header {
                padding: 0;
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
                <a href="/instructor_homepage">Dashboard</a>
                <a href="/instructor/manage_courses" class="active">Manage Course</a>
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
                <h1>Add New Course</h1>
            </div>
            @auth
                <div class="user-info">
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

        <!-- Form Content -->
        <div class="content-area">
            <div class="form-card">
                @auth
                <h2><i class="fas fa-plus-circle" style="color:var(--primary-color);"></i>Add New Course</h2>
                @if(auth()->user()->role === 2)
                <form action="/admin/manage_courses/create" method="POST" enctype="multipart/form-data">
                @elseif(auth()->user()->role === 3)
                <form action="/instructor/manage_courses/create" method="POST" enctype="multipart/form-data">
                @endif
                    @csrf
                    <div class="form-group">
                        <label for="image">Course Image <span class="required">*</span></label>
                        <input type="file" id="image" name="image" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="title">Course Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title" placeholder="Enter course title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Course Description</label>
                        <textarea id="description" name="description" placeholder="Enter course description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category <span class="required">*</span></label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Development">Mobile Development</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Machine Learning">Machine Learning</option>
                            <option value="Design">Design</option>
                            <option value="Business">Business</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="video_count">Number of Lectures <span class="required">*</span></label>
                        <input type="number" id="video_count" name="video_count"  min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="approx_video_length">Approx Video Length (minutes) <span class="required">*</span></label>
                        <input type="number" id="approx_video_length" name="approx_video_length"  min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="total_duration">Total Duration (hours) <span class="required">*</span></label>
                        <input type="number" id="total_duration" name="total_duration"  step="0.1" min="0.1" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price (৳) <span class="required">*</span></label>
                        <input type="number" id="price" name="price" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="course_prerequisite">Course Prerequisite(If any)</label>
                        <input type="text" id="prerequisite" name="prerequisite">
                    </div>

                    <button type="submit"><i class="fas fa-save"></i> Save Course</button>
                </form>
                @if(auth()->user()->role === 2)
                <a class="back-link" href="/admin_panel/manage_courses"><i class="fas fa-arrow-left"></i> Back to Manage Courses</a>
                @elseif(auth()->user()->role === 3)
                <a class="back-link" href="/instructor/manage_courses"><i class="fas fa-arrow-left"></i> Back to Manage Courses</a>
                @endif
                @else
                <p style="text-align:center;color:#DC2626;">You are not logged in. <a href="/" style="color:var(--primary-color);">Go to Login</a></p>
                @endauth
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
