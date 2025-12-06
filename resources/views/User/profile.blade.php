<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EDVANTAGE</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            padding-top: 70px;
            min-height: 100vh;
        }
        
        /* Header hover effects */
        .navbar a:hover,
        .navbar button:hover {
            transform: translateY(-2px);
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa !important;
            padding-left: 1.25rem !important;
        }
        
        /* Sidebar styling */
        .sidebar {
            background: #e7edf4;
            min-height: calc(100vh - 70px);
            padding: 2.5rem 2rem;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            background: #0E1B33;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 4px solid #0E1B33;
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }
        
        .profile-name {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .profile-subtitle {
            font-size: 1rem;
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        /* Main content styling */
        .main-content {
            padding: 2.5rem;
            background: #f9f9f9;
            min-height: calc(100vh - 70px);
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0;
        }
        
        .section-title i {
            color: #0E1B33;
            font-size: 1.25rem;
        }
        
        .section-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }
        
        .info-card {
            background: #e7edf4;
            padding: 1.25rem;
            border-radius: 12px;
            border-left: 4px solid #0E1B33;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 27, 51, 0.15);
        }
        
        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #0E1B33;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .info-value {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
        }
        
        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #0E1B33;
        }
        
        .btn-outline-custom {
            background: #f9f9f9;
            color: #0E1B33;
        }
        
        .btn-outline-custom:hover {
            background: #0E1B33;
            color: #ffffff;
        }
        
        .btn-primary-custom {
            background: #0E1B33;
            color: #ffffff;
            border: 2px solid #0E1B33;
        }
        
        .btn-primary-custom:hover {
            background: #475569;
            border-color: #475569;
        }
        
        .bio-container {
            background: #e7edf4;
            padding: 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #0E1B33;
        }
        
        .bio-textarea {
            width: 100%;
            min-height: 120px;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            background: #f9f9f9;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            line-height: 1.6;
            resize: vertical;
        }
        
        .bio-textarea:focus {
            outline: none;
            border-color: #0E1B33;
        }
        
        .section-divider {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
            margin-bottom: 1.25rem;
        }
        
        .nav-actions-card {
            background: #f8f9ff;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .sidebar {
                min-height: auto;
                padding: 2rem 1.5rem;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .main-content {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header Component -->
    @include('layouts.header')
    
    <!-- Main Profile Container -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Left Sidebar -->
            <div class="col-12 col-lg-3 sidebar">
                <!-- Profile Header -->
                <div class="text-center">
                    <div class="profile-avatar">
                        <i class="fas fa-user text-white" style="font-size: 60px;"></i>
                    </div>
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    <p class="profile-subtitle">{{ $user->field }} Enthusiast</p>
                </div>
                
                <!-- Profile Actions -->
                <div class="d-grid gap-3">
                    <button class="btn btn-outline-custom d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-share-alt"></i>
                        Share profile link
                    </button>
                    <button class="btn btn-link text-decoration-underline text-dark p-0" style="font-size: 0.875rem;">
                        Update profile visibility
                    </button>
                </div>
            </div>
            
            <!-- Right Main Content -->
            <div class="col-12 col-lg-9 main-content">
                <!-- Personal Information Section -->
                <div class="mb-5">
                    <div class="section-divider">
                        <h2 class="section-title">
                            <i class="fas fa-user-circle"></i>
                            Personal Information
                        </h2>
                    </div>
                    <p class="section-description">
                        Manage your personal information and account details. Keep your profile up to date to get the most out of your learning experience.
                    </p>
                    <div>
                        <div class="info-card">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">{{ $user->phone ?? 'Not provided' }}</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Field of Interest</div>
                            <div class="info-value">{{ $user->field }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Account Information Section -->
                <div class="mb-5">
                    <div class="section-divider">
                        <h2 class="section-title">
                            <i class="fas fa-cog"></i>
                            Account Information
                        </h2>
                    </div>
                    <p class="section-description">
                        View your account status and membership details. Your account information helps us provide you with personalized learning recommendations.
                    </p>
                    <div>
                        <div class="info-card">
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Bio Section -->
                <div class="mb-5">
                    <div class="d-flex justify-content-between align-items-center section-divider">
                        <h2 class="section-title">
                            <i class="fas fa-file-alt"></i>
                            About Me
                        </h2>
                        <button class="btn btn-outline-custom btn-sm d-flex align-items-center gap-2" onclick="toggleBioEdit()" style="padding: 0.5rem 1rem;">
                            <i class="fas fa-edit"></i>
                            <span id="bio-edit-text">Add Bio</span>
                        </button>
                    </div>
                    <p class="section-description">
                        Share a bit about yourself, your learning goals, and what motivates you. This helps others in the community get to know you better.
                    </p>
                    <div class="bio-container">
                        <div id="bio-display">
                            <p class="mb-0 {{ $user->bio ? '' : 'text-muted fst-italic' }}">
                                {{ $user->bio ?? 'No bio added yet. Click "Add Bio" to tell others about yourself, your learning journey, and your goals.' }}
                            </p>
                        </div>
                        <div id="bio-edit" class="d-none">
                            <textarea 
                                class="bio-textarea mb-3"
                                placeholder="Tell us about yourself, your learning goals, interests, and what motivates you to learn..."
                                maxlength="500"
                            >{{ $user->bio ?? '' }}</textarea>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary-custom btn-sm d-flex align-items-center gap-2" onclick="saveBio()" style="padding: 0.5rem 1rem;">
                                    <i class="fas fa-save"></i>
                                    Save Bio
                                </button>
                                <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2" onclick="cancelBioEdit()" style="padding: 0.5rem 1rem;">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
              
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        function toggleBioEdit() {
            const bioDisplay = document.getElementById('bio-display');
            const bioEdit = document.getElementById('bio-edit');
            const editText = document.getElementById('bio-edit-text');
            
            bioDisplay.classList.add('d-none');
            bioEdit.classList.remove('d-none');
            editText.textContent = 'Cancel';
        }

        function cancelBioEdit() {
            const bioDisplay = document.getElementById('bio-display');
            const bioEdit = document.getElementById('bio-edit');
            const editText = document.getElementById('bio-edit-text');
            
            bioDisplay.classList.remove('d-none');
            bioEdit.classList.add('d-none');
            editText.textContent = 'Add Bio';
        }

        function saveBio() {
            const textarea = document.querySelector('#bio-edit textarea');
            const bioText = textarea.value.trim();
            const bioDisplay = document.querySelector('#bio-display p');
            
            if (bioText) {
                bioDisplay.textContent = bioText;
                bioDisplay.classList.remove('text-muted', 'fst-italic');
            } else {
                bioDisplay.textContent = 'No bio added yet. Click "Add Bio" to tell others about yourself, your learning journey, and your goals.';
                bioDisplay.classList.add('text-muted', 'fst-italic');
            }
            
            cancelBioEdit();
            
            // Show success notification
            const toastHtml = `
                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
                    <div class="toast show align-items-center text-white bg-success border-0 rounded-3" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="fas fa-check-circle me-2"></i>Bio saved successfully!
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.position-fixed').remove()"></button>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', toastHtml);
            
            setTimeout(() => {
                const toast = document.querySelector('.position-fixed');
                if (toast) toast.remove();
            }, 3000);
        }
    </script>
</body>
</html>