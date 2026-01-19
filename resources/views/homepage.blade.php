<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDVANTAGE - Your Virtual Classroom Redefined</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        }
        /* Header Styles */
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
            color: #8b8b8d;
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
            border: 2px solid #475569;
        }
        .btn.btn-primary {
            background: #0E1B33;
            color: white;
            border: 4px solid #0E1B33; /* Increased border size */
        }
        .btn.btn-primary:hover {
            background: #475569;
            border:4px solid #475569;
        }
        .top-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 2rem; /* Add this line to move all icons (including heart) to the right */
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
        
        /* Notification Button Styles */
        .notification-button {
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc2626;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .notification-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            min-width: 320px;
            max-width: 400px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-button:hover .notification-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            background: #f8fafc;
            border-radius: 12px 12px 0 0;
        }
        
        .notification-header h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item:hover {
            background: #f8fafc;
        }
        
        .notification-rejected {
            border-left: 4px solid #dc2626;
        }
        
        .notification-answered {
            border-left: 4px solid #16a34a;
        }
        
        .notification-content {
            margin-bottom: 8px;
        }
        
        .notification-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        
        .notification-text {
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.4;
            margin-bottom: 6px;
        }
        
        .notification-instructor {
            color: #6b7280;
            font-size: 0.8rem;
            font-style: italic;
        }
        
        .notification-action {
            display: inline-block;
            padding: 4px 12px;
            background: #0E1B33;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .notification-action:hover {
            background: #475569;
            color: white;
        }
        
        .no-notifications {
            padding: 40px 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
        }
        
        .no-notifications i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
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
        .category-bar {
            background: #0E1B33;
            backdrop-filter: blur(10px);
            padding: 0.5rem 0 0.25rem 0;
            position: fixed;
            width: 100%;
            top: 56px;
            z-index: 999;
            border: none;
            box-shadow: 0 12px 32px 0 rgba(0,0,0,0.22), 0 2px 8px 0 rgba(0,0,0,0.12);
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
        .category-link:hover {
            color: #8b8b8d;
        }
       .search-form {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    margin-right: 1rem;
    position: relative;
}

.search-input {
    width: 400px;
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 24px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #0E1B33;
    box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
}
        /* Username styling */
        .username {
            margin-left: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        /* Notification Button Styles */
        .notification-button {
            position: relative;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc2626;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .notification-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #e2e8f0;
            min-width: 320px;
            max-width: 400px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-button:hover .notification-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .notification-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            background: #f8fafc;
            border-radius: 12px 12px 0 0;
        }
        
        .notification-header h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-item:hover {
            background: #f8fafc;
        }
        
        .notification-rejected {
            border-left: 4px solid #dc2626;
        }
        
        .notification-answered {
            border-left: 4px solid #16a34a;
        }
        
        .notification-content {
            margin-bottom: 8px;
        }
        
        .notification-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }
        
        .notification-text {
            color: #64748b;
            font-size: 0.85rem;
            line-height: 1.4;
            margin-bottom: 6px;
        }
        
        .notification-instructor {
            color: #6b7280;
            font-size: 0.8rem;
            font-style: italic;
        }
        
        .notification-action {
            display: inline-block;
            padding: 4px 12px;
            background: #0E1B33;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .notification-action:hover {
            background: #475569;
            color: white;
        }
        
        .no-notifications {
            padding: 40px 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 0.9rem;
        }
        
        .no-notifications i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
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
        .category-bar {
            background: #0E1B33;
            backdrop-filter: blur(10px);
            padding: 0.5rem 0 0.25rem 0;
            position: fixed;
            width: 100%;
            top: 56px;
            z-index: 999;
            border: none;
            box-shadow: 0 12px 32px 0 rgba(0,0,0,0.22), 0 2px 8px 0 rgba(0,0,0,0.12);
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
        .category-link:hover {
            color: #8b8b8d;
        }
       .search-form {
    flex: 0 0 auto;
    display: flex;
    align-items: center;
    margin-right: 1rem;
    position: relative;
}

.search-input {
    width: 400px;
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 24px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #0E1B33;
    box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
}
        /* Username styling */
        .username {
            margin-left: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin-top: 88px; /* Reduced from 96px to remove gap */
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background:
                linear-gradient(135deg, rgba(32,42,68,0.75) 0%, rgba(102,126,234,0.5) 100%),
                url('/image/hero.png') center center/cover no-repeat;
            opacity: 1;
            z-index: 1;
        }
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        .hero h1 {
            font-family:'Montserrat', sans-serif;
            font-size: 3.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-hero {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            border-radius: 50px;
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .section-title {
      font-size: 28px;
      font-weight: 600;
      color: var(--text-dark);
    }

  
        /* Courses Section */
        .courses-section {
            padding: 5rem 0;
            background: #f8fafc;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-title h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #1e293b;
            margin-bottom: 1rem;
        }
        .section-title p {
            font-size: 1.1rem;
            color: #64748b;
        }
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2.5rem 0.5rem;
            margin-top: 2rem;
        }
        .course-card {
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid #c4c6ca;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 340px;
            width: 280px;
            transition: box-shadow 0.2s;
            position: relative;
            margin: 0 auto;
            box-sizing: border-box;
            text-align: left;
        }
        .course-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.10);
            border: #0E1B33 1.3px solid;
        }
        .course-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-bottom: 1px solid #f1f1f1;
        }
        .course-content {
            padding: 10px 12px 8px 12px;
            display: flex;
            flex-direction: column;
            flex: 1 1 auto;
            min-height: 0;
        }
        .course-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
            min-height: 2.4em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .course-category {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .course-category-badge {
            display: inline-block;
            background: #dcdcdd;
            color: #0E1B33;
            font-size: 0.85rem;
            font-weight: 500;
            border-radius: 16px;
            padding: 3px 14px;
            margin: 4px -10 6px 0;
            border: none;
            cursor: default;
        }
        .course-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 2px;
        }
        .stars {
            color: #f59e0b;
            font-size: 1rem;
            letter-spacing: 1px;
        }
        .rating-number {
            font-size: 0.95rem;
            font-weight: 600;
            color: #f59e0b;
        }
        .rating-count {
            font-size: 0.85rem;
            color: #9ca3af;
        }
        .course-price {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: -1;
            margin-bottom: 0px;
        }
        .course-actions {
            display: flex;
            justify-content: space-between; /* Aligns items to ends */
            align-items: center; /* Vertically centers items */
            margin-top: auto;
            
        }
        .taka-bold {
            font-weight: 790;
            font-size: 1.3rem;
            letter-spacing: 0.5px;
        }
        
      .btn-details {
            flex: 1;
            background: #f3f4f6;
            color: #374151;
            text-align: center;
            padding: 6px 6px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline;
            margin-right:100px;
            border: #bebfc0 1px solid;

            margin-bottom:50px;
        }
        .btn-details:hover {
            background: #ffffff;
            border: #bebfc0 1px solid;
        }
        .btn-details i {
            font-size: 1rem; /* Ensure icon size is consistent */
        }
        .btn-icon-action { /* Style for wishlist and cart icons */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px; /* Fixed width */
            height: 30px; /* Fixed height */
            font-size: 1.1rem;
            color: #f3f4f6;; /* White icon color */
            background: #0E1B33; /* Updated to match image's purple */
            border: none;
            border-radius: 50%; /* Circular shape */
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 50px; /* Space below the icons */
        }
        .btn-icon-action:hover {
            background: #475569; /* Darker purple on hover */
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .btn-icon-action i {
            font-size: 1rem; /* Ensure icon size is consistent */
        }
        .action-icons-group {
            display: flex;
            gap: 8px; /* Space between wishlist and cart */
        }
        #loadMoreBtn {
            padding: 0.5rem 1rem;
            font-size: 1.2rem;
            border-radius: 5px;
            font-weight: 500;
        }
        @media (max-width: 1200px) {
            .courses-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 480px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
   <!-- Main Navigation Bar -->
   @include('layouts.header')

   @include('layouts.category-bar')

   @include('layouts.hero')
    

      {{-- ================= RECOMMENDED COURSES ================= --}}
{{-- ================= RECOMMENDED COURSES ================= --}}
@if(auth()->check() && isset($recommendedCourses) && count($recommendedCourses))
<section id="recommended" class="py-16 bg-gray-50"> 
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="text-center mb-12 pt-5">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Recommended For You</h2>
                <p class="text-xl text-gray-600">Courses based on your searches and learning activity</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 pb-8 px-8">
                @foreach($recommendedCourses as $course)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-2xl border border-gray-200 hover:border-teal-500 transition-all cursor-pointer group transform hover:-translate-y-2 duration-300">
                        <!-- Image -->
                        <div class="relative overflow-hidden h-48">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="https://via.placeholder.com/300x140?text=Course+Image" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 space-y-3">
                            <!-- Category Badge -->
                            @if($course->category)
                                <span class="inline-block bg-teal-100 text-teal-700 text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $course->category }}
                                </span>
                            @endif

                            <!-- Title -->
                            <h3 class="font-bold text-lg text-gray-900 line-clamp-2 min-h-[3.5rem]">
                                {{ $course->title }}
                            </h3>

                            <!-- Rating -->
                            @if($course->ratings->count())
                            <div class="flex items-center gap-2">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($course->averageRating()))
                                            <svg class="w-4 h-4 text-yellow-500 fill-yellow-500" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="font-semibold text-sm text-yellow-600">{{ $course->averageRating() }}</span>
                                <span class="text-xs text-gray-500">({{ $course->ratings->count() }})</span>
                            </div>
                            @endif

                            <!-- Price -->
                            <div class="pt-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-gray-900">৳</span>
                                    <span class="text-2xl font-bold text-gray-900">{{ number_format($course->price ?? 0, 0) }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-2">
                                <!-- Details Button -->
                                <a href="{{ route('courses.details', $course->id) }}" 
                                   class="flex-1 px-2 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-center text-sm font-semibold rounded-md transition-colors">
                                    Details
                                </a>
                                
                                <!-- Action Buttons Row -->
                                <div class="flex gap-2">
                                    <!-- Wishlist Button -->
                                    <form method="POST" action="{{ route('wishlist.add', $course->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full px-2 py-2 bg-pink-50 hover:bg-pink-100 text-pink-600 text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2"
                                                title="Add to Wishlist">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <!-- Cart Button -->
                                    <form method="POST" action="{{ route('cart.add', $course->id) }}" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" 
                                                class="w-full px-2 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-md transition-colors flex items-center justify-center gap-2 shadow-md"
                                                title="Add to Cart">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
{{-- ================= END RECOMMENDED COURSES ================= --}}


@include('layouts.featured-course')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-input');
    const searchForm = document.querySelector('.search-form');
    
    // Submit on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            if (this.value.trim().length > 0) {
                searchForm.submit();
            }
        }
    });
});
  // Smooth scrolling for navigation links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      document.querySelector(this.getAttribute('href')).scrollIntoView({
        behavior: 'smooth'
      });
    });
  });

  // Header background on scroll
  window.addEventListener('scroll', function () {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
      header.style.background = 'rgba(255, 255, 255, 0.98)';
    } else {
      header.style.background = 'rgba(255, 255, 255, 0.95)';
    }
  });

  // Session-based alerts for cart and wishlist
  @if(session('cart_added'))
    if (confirm("{{ session('cart_added') }} Go to cart?")) {
      window.location.href = "{{ route('cart.all') }}";
    }
  @endif

  @if(session('wishlist_added'))
    if (confirm("{{ session('wishlist_added') }} Go to wishlist?")) {
      window.location.href = "{{ route('wishlist.all') }}";
    }
  @endif
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const cards = document.querySelectorAll('#coursesGrid .course-card');

    let visible = 4;
    const increment = 4;

    if (!loadMoreBtn || cards.length === 0) return;

    loadMoreBtn.addEventListener('click', function () {
        let shown = 0;

        for (let i = visible; i < cards.length && shown < increment; i++) {
            cards[i].style.display = 'flex';
            shown++;
        }

        visible += shown;

        if (visible >= cards.length) {
            loadMoreBtn.style.display = 'none';
        }
    });
});
</script>


</body>
</html>