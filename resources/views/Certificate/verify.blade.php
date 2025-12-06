<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification - Edvantage</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        
        /* Header Styles - Matching the second blade exactly */
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
        /* Username styling */
        .username {
            margin-left: 1.5rem;
            font-weight: 500;
            color: #374151;
        }
        
        /* Main content padding to account for fixed header */
        body {
            padding-top: 80px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .search-input {
                width: 300px;
            }
            .username {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Simplified Header -->
    <header class="header">
        <div class="nav-container">
            <a href="/" class="logo">
                <img src="/image/Edvantage.png" alt="EDVANTAGE Logo" style="height:40px; vertical-align:middle;">
            </a>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-shield-alt text-gray-600 text-lg"></i>
                </div>
                <h1 class="text-2xl font-semibold text-gray-900">Certificate Verification</h1>
            </div>
            <p class="text-gray-600">Verify the authenticity of Edvantage certificates</p>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <!-- Certificate ID Display -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="text-center">
                    <div class="text-sm font-medium text-gray-700 mb-2">Certificate ID</div>
                    <div class="font-mono text-lg font-semibold text-gray-900 bg-white px-4 py-2 rounded-lg border border-gray-200 inline-block">
                        {{ $certificate_id }}
                    </div>
                </div>
            </div>

            <!-- Verification Result -->
            <div class="px-6 py-8">
                <div class="text-center mb-8">
                    @if($certificate)
                        <!-- Verified State -->
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">Certificate Verified</h2>
                        <p class="text-gray-600">This certificate is authentic and was issued by Edvantage.</p>

                        <!-- Certificate Details -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Certificate Details</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-user text-gray-500 w-4"></i>
                                        <span class="font-medium text-gray-700">Student Name</span>
                                    </div>
                                    <span class="text-gray-900 font-medium">{{ $certificate->user->name }}</span>
                                </div>

                                <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-book text-gray-500 w-4"></i>
                                        <span class="font-medium text-gray-700">Course Title</span>
                                    </div>
                                    <span class="text-gray-900 font-medium">{{ $certificate->course->title }}</span>
                                </div>

                                <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-calendar text-gray-500 w-4"></i>
                                        <span class="font-medium text-gray-700">Completion Date</span>
                                    </div>
                                    <span class="text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($certificate->completion_date)->format('F j, Y') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between py-3 border-b border-gray-200 last:border-b-0">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-star text-gray-500 w-4"></i>
                                        <span class="font-medium text-gray-700">Final Score</span>
                                    </div>
                                    <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $certificate->average_score }}%
                                    </span>
                                </div>

                                <div class="flex items-center justify-between py-3">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-certificate text-gray-500 w-4"></i>
                                        <span class="font-medium text-gray-700">Issued On</span>
                                    </div>
                                    <span class="text-gray-900 font-medium">
                                        {{ \Carbon\Carbon::parse($certificate->created_at)->format('F j, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Failed State -->
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-times-circle text-red-600 text-3xl"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-red-600 mb-2">Verification Failed</h2>
                        <div class="text-gray-600 text-left max-w-md mx-auto">
                            <p class="mb-3"><strong>Certificate not found.</strong></p>
                            <p class="mb-3">The certificate ID does not match any records in our database. This could mean:</p>
                            <ul class="list-disc pl-5 space-y-1 mb-3">
                                <li>The certificate ID was entered incorrectly</li>
                                <li>The certificate has not been issued yet</li>
                                <li>The certificate may have been revoked</li>
                            </ul>
                            <p>Please verify the certificate ID and try again.</p>
                        </div>
                    @endif
                </div>

                    <a href="/" class="inline-flex items-center gap-2 bg-white text-gray-900 px-6 py-3 rounded-xl border border-gray-300 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-graduation-cap text-sm"></i>
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-8">
        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Edvantage. All rights reserved.</p>
    </div>

    <script>
        // Toggle between verified and failed states for demonstration
        function toggleVerificationState() {
            const verifiedState = document.getElementById('verified-state');
            const failedState = document.getElementById('failed-state');
            const certificateDetails = document.getElementById('certificate-details');
            
            if (verifiedState.style.display === 'block') {
                verifiedState.style.display = 'none';
                failedState.style.display = 'block';
                certificateDetails.style.display = 'none';
            } else {
                verifiedState.style.display = 'block';
                failedState.style.display = 'none';
                certificateDetails.style.display = 'block';
            }
        }

        // Add click event to certificate ID for demo purposes
        document.addEventListener('DOMContentLoaded', function() {
            const certificateId = document.querySelector('.font-mono');
            if (certificateId) {
                certificateId.style.cursor = 'pointer';
                certificateId.title = 'Click to toggle verification state (demo)';
                certificateId.addEventListener('click', toggleVerificationState);
            }
        });
    </script>
</body>
</html>