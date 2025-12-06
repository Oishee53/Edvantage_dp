<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EDVANTAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
       * {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        /* Header Styles - Updated to match homepage exactly */
        .header {
            background: #fff;
            backdrop-filter: blur(10px);
            padding: 0.5rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: none;
        }
        .logo {
            margin-left: -2rem;
            margin-right:0.75rem;
        }
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-shrink: 0;
        }
        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            margin-left: 1rem;
            margin-right: -1rem;
        }
        .nav-menu a:hover{
            color: #0E1B33;
        }
        .nav-menu a {
            font-family: 'Montserrat', sans-serif;
            text-decoration: none;
            color: #374151;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            margin-right:1rem;
        }
        .btn {
            padding: 0.2rem 0.75rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-outline {
            background: transparent;
            color: #0E1B33;
            border: 2px solid #0E1B33;
        }
        .btn-outline:hover {
            background: #dcdcdd;
            color: #0E1B33;
        }
        .btn-primary {
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33;
        }
        .btn-primary:hover {
            background: #475569;
        }
        .top-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 2rem;
            margin-right: -2rem;
        }
        .icon-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
            color: #0E1B33;
            background: rgba(14, 27, 51, 0.08);
            border: 1px solid rgba(14, 27, 51, 0.2);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }
        .icon-button:hover {
            background: rgba(14, 27, 51, 0.15);
            border-color: rgba(14, 27, 51, 0.3);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }
        .icon-button:active {
            transform: translateY(0);
        }
        .user-menu-button {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #0E1B33 0%, #475569 100%);
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(14, 27, 51, 0.3);
        }
        .user-menu-button:hover {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(14, 27, 51, 0.4);
        }
        .user-menu-button:active {
            transform: translateY(0);
        }
        .user-menu-button i {
            font-size: 1rem;
        }
        .user-menu {
            position: relative;
        }
        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            min-width: 220px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }
        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .user-dropdown a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #374151;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }
        .user-dropdown a:last-child {
            border-bottom: none;
        }
        .user-dropdown a:hover {
            background: #f8fafc;
            color: #0E1B33;
        }
        .user-dropdown .icon {
            margin-right: 12px;
            font-size: 0.9rem;
            width: 16px;
            text-align: center;
            color: #0E1B33;
        }
        .user-dropdown .separator {
            height: 1px;
            background: #e5e7eb;
            margin: 8px 0;
        }
        .search-form {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        .search-input {
            width: 400px;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 24px;
            font-size: 1rem;
        }
        /* Username styling */
        .username {
            margin-left: 1.5rem;
            font-weight: 500;
            color: #374151;
        }

        .profile-container {
            margin-top: 60px; /* Adjusted for fixed header */
            display: grid;
            grid-template-columns: 350px 1fr;
            min-height: 100vh;
        }

        /* Left Sidebar - Updated colors */
        .left-sidebar {
            background: #e7edf4;
            padding: 40px 30px;
            border-right: 1px solid #e2e8f0;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #0E1B33;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid #0E1B33;
        }

        .profile-avatar i {
            font-size: 60px;
            color: white;
        }

        .profile-name {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .profile-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .profile-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-outline {
            background: #f9f9f9;
            color: #0E1B33;
            border: 2px solid #0E1B33;
        }

        .btn-outline:hover {
            background: #0E1B33;
            color: #ffffff;
        }

        .btn-link {
            background: none;
            color: #0E1B33;
            border: none;
            text-decoration: underline;
            padding: 8px 0;
            font-size: 14px;
        }

        .btn-link:hover {
            color: #475569;
        }

        /* Right Main Content */
        .main-content {
            padding: 40px;
            background: #f9f9f9;
            overflow-y: auto;
        }

        .content-section {
            margin-bottom: 50px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: #0E1B33;
            font-size: 20px;
        }

        .section-description {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            gap: 20px;
        }

        .info-item {
            background: #e7edf4;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #0E1B33;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 27, 51, 0.15);
        }

        .info-label {
            font-size: 14px;
            font-weight: 600;
            color: #0E1B33;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .btn-primary {
            background: #0E1B33;
            color: #f9f9f9;
            border: none;
        }

        .btn-primary:hover {
            background: #475569;
            box-shadow: 0 8px 25px rgba(14, 27, 51, 0.3);
        }

        .btn-secondary {
            background: #f9f9f9;
            color: #0E1B33;
            border: 2px solid #0E1B33;
        }

        .btn-secondary:hover {
            background: #dcdcdd;
            color: #0E1B33;
        }

        .add-button {
            background: #f9f9f9;
            color: #0E1B33;
            border: 2px solid #0E1B33;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-button:hover {
            background: #0E1B33;
            color: white;
        }

        /* Bio Section Styles - Updated colors */
        .bio-container {
            background: #e7edf4;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #0E1B33;
        }

        .bio-text {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .bio-placeholder {
            color: #999;
            font-style: italic;
        }

        .bio-textarea {
            width: 100%;
            min-height: 120px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            background: #f9f9f9;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            line-height: 1.6;
            resize: vertical;
            transition: border-color 0.3s ease;
        }

        .bio-textarea:focus {
            outline: none;
            border-color: #0E1B33;
        }

        .bio-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 12px;
            border-radius: 6px;
        }

        .hidden {
            display: none;
        }

        /* Navigation Actions - Updated colors */
        .navigation-actions {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .navigation-actions h3 {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .profile-container {
                grid-template-columns: 300px 1fr;
            }
            
            .left-sidebar {
                padding: 30px 20px;
            }
            
            .main-content {
                padding: 30px 25px;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            
            .profile-container {
                grid-template-columns: 1fr;
            }

            .left-sidebar {
                padding: 20px;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }

            .main-content {
                padding: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .nav-buttons {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

        .category-link {
            font-family: 'Montserrat', sans-serif;
            color: white ;
            font-size: 0.9rem;
            text-decoration: none;   
            transition: color 0.3s ease;
            white-space: nowrap;
            padding: 0.25rem 0;
            padding-left: 1.5rem;
            margin-right: 1rem;
            margin-left: 1rem;
        }
    </style>
</head>
<body>
     <!-- Main Navigation Bar - Updated to match homepage exactly -->
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="/image/Edvantage.png" alt="EDVANTAGE Logo" style="height:40px; vertical-align:middle;">
            </a>
            <form class="search-form" action="{{ route('courses.search') }}" method="GET">
    <input type="text" 
           name="search" 
           placeholder="What do you want to learn?" 
           class="search-input"
           value="{{ request('search') }}"
           autocomplete="off">
          </form>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                </ul>
            </nav>
            <div class="top-icons">
                <a href="/wishlist" class="icon-button" title="Wishlist">
                    <i class="fa-solid fa-heart"></i>
                </a>
                <a href="/cart" class="icon-button" title="Shopping Cart">
                    <i class="fa-solid fa-shopping-bag"></i>
                </a>
                <div class="user-menu">
                    <button class="user-menu-button" title="User Menu">
                        <i class="fa-solid fa-user-circle"></i>
                    </button>
                    <div class="user-dropdown">
                        <a href="/profile"><i class="fa-solid fa-user icon"></i> My Profile</a>
                        <a href="{{ route('courses.enrolled') }}"><i class="fa-solid fa-graduation-cap icon"></i> My Courses</a>
                        <a href="{{ route('user.progress') }}"><i class="fa-solid fa-chart-line icon"></i> My Progress</a>
                        <a href="/homepage"><i class="fa-solid fa-book-open icon"></i> Course Catalog</a>

                       <a href="{{ route('purchase.history') }}"><i class="fa-solid fa-receipt icon"></i> Purchase History</a>
                        <div class="separator"></div>
                        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa-solid fa-right-from-bracket icon"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
            <!-- Hidden logout form -->
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
            <p class="username">{{ explode(' ', $user->name)[0] }}</p>
        </div>
    </header>

    <div class="profile-container">
        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <!-- Profile Header -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h1 class="profile-name">{{ $user->name }}</h1>
                <p class="profile-subtitle">{{ $user->field }} Enthusiast</p>
            </div>

            <!-- Profile Actions -->
            <div class="profile-actions">
                <a href="#" class="btn btn-outline">
                    <i class="fas fa-share-alt"></i>
                    Share profile link
                </a>
                <button class="btn-link">
                    Update profile visibility
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Personal Information Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-user-circle"></i>
                        Personal Information
                    </h2>
                </div>
                <p class="section-description">
                    Manage your personal information and account details. Keep your profile up to date to get the most out of your learning experience.
                </p>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Field of Interest</div>
                        <div class="info-value">{{ $user->field }}</div>
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-cog"></i>
                        Account Information
                    </h2>
                </div>
                <p class="section-description">
                    View your account status and membership details. Your account information helps us provide you with personalized learning recommendations.
                </p>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Bio Section -->
            <div class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        About Me
                    </h2>
                    <button class="add-button" onclick="toggleBioEdit()">
                        <i class="fas fa-edit"></i>
                        <span id="bio-edit-text">Add Bio</span>
                    </button>
                </div>
                <p class="section-description">
                    Share a bit about yourself, your learning goals, and what motivates you. This helps others in the community get to know you better.
                </p>
                <div class="bio-container">
                    <div id="bio-display">
                        <div class="bio-text bio-placeholder">
                            {{ $user->bio ?? 'No bio added yet. Click "Add Bio" to tell others about yourself, your learning journey, and your goals.' }}
                        </div>
                    </div>
                    <div id="bio-edit" class="hidden">
                        <textarea 
                            class="bio-textarea" 
                            placeholder="Tell us about yourself, your learning goals, interests, and what motivates you to learn..."
                            maxlength="500"
                        >{{ $user->bio ?? '' }}</textarea>
                        <div class="bio-actions">
                            <button class="btn btn-primary btn-small" onclick="saveBio()">
                                <i class="fas fa-save"></i>
                                Save Bio
                            </button>
                            <button class="btn btn-secondary btn-small" onclick="cancelBioEdit()">
                                <i class="fas fa-times"></i>
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Actions -->
            <div class="content-section">
                
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBioEdit() {
            const bioDisplay = document.getElementById('bio-display');
            const bioEdit = document.getElementById('bio-edit');
            const editText = document.getElementById('bio-edit-text');
            
            bioDisplay.classList.add('hidden');
            bioEdit.classList.remove('hidden');
            editText.textContent = 'Cancel';
        }

        function cancelBioEdit() {
            const bioDisplay = document.getElementById('bio-display');
            const bioEdit = document.getElementById('bio-edit');
            const editText = document.getElementById('bio-edit-text');
            
            bioDisplay.classList.remove('hidden');
            bioEdit.classList.add('hidden');
            editText.textContent = 'Add Bio';
        }

        function saveBio() {
            const textarea = document.querySelector('.bio-textarea');
            const bioText = textarea.value.trim();
            
            // Here you would typically send the bio to your Laravel backend
            // For now, we'll just update the display
            const bioDisplay = document.querySelector('.bio-text');
            
            if (bioText) {
                bioDisplay.textContent = bioText;
                bioDisplay.classList.remove('bio-placeholder');
            } else {
                bioDisplay.textContent = 'No bio added yet. Click "Add Bio" to tell others about yourself, your learning journey, and your goals.';
                bioDisplay.classList.add('bio-placeholder');
            }
            
            cancelBioEdit();
            
            // Show success message (you can enhance this)
            alert('Bio saved successfully!');
        }
    </script>
</body>
</html>