<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EDVANTAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Reset & Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0E1B33 0%, #334155 100%); /* Darker gradient */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        /* Background Pattern */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/image/hero.png') center/cover;
            opacity: 0.4; /* Increased opacity to make the image visible */
            z-index: 1;
        }
        /* Top Logo */
        .top-logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .top-logo img {
            height: 40px;
            vertical-align: middle;
        }
        /* Main Container */
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 90%;
            position: relative;
            z-index: 5;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeInUp 0.8s ease forwards; /* Animation applied here */
        }
        /* Login Header */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0E1B33; /* Primary dark color */
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }
        /* Error Message */
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .error-message::before {
            content: '⚠️';
            font-size: 1.1rem;
        }
        /* Form Styles */
        .login-form {
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        .form-input:focus {
            outline: none;
            border-color: #0E1B33; /* Primary dark color on focus */
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1); /* Shadow with primary dark color */
        }
        .form-input:hover {
            border-color: #d1d5db;
        }
      .forgot-pass-link {
    text-align: left;
    margin-top: -1rem;
    margin-bottom: 1.5rem;
}
        .forgot-pass-link a {
            color: #0E1B33; /* Primary dark color */
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .forgot-pass-link a:hover {
            color: #475569; /* A slightly lighter shade for hover */
            text-decoration: underline;
        }
        /* Login Button */
        .login-button {
            width: 100%;
            background: #0E1B33; /* Primary dark color */
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }
        .login-button:hover {
            background: linear-gradient(135deg, #334155 0%, #475569 100%); /* Darker gradient for hover */
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14, 27, 51, 0.3); /* Shadow with primary dark color */
        }
        .login-button:active {
            transform: translateY(0);
        }
        /* Loading State */
        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        /* Register Link */
        .register-link {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        .register-link p {
            color: #64748b;
            font-size: 0.95rem;
        }
        .register-link a {
            color: #0E1B33; /* Primary dark color */
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .register-link a:hover {
            color: #475569; /* A slightly lighter shade for hover */
            text-decoration: underline;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
            }
            .login-title {
                font-size: 1.5rem;
            }
            .top-logo {
                top: 1rem;
                left: 1rem;
                font-size: 1.5rem;
            }
        }
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        /* Input Icons (No actual icons in original, but keeping styles for future use) */
        .input-group {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }
        .form-input.with-icon {
            padding-left: 1rem; /* Adjusted from 2.5rem as no icon is present */
        }
        /* Ripple Effect */
        .login-button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .login-button:active::after {
            width: 300px;
            height: 300px;
        }
    </style>
</head>
<body>
    <!-- Top Logo -->
    <div class="top-logo">
        <a href="/" class="logo">
            <img src="/image/Edvantage.png" alt="EDVANTAGE Logo">
        </a>
    </div>
    <!-- Main Container -->
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <h2 class="login-title">Sign in</h2>
            <p class="login-subtitle">Welcome back! Please enter your credentials.</p>
        </div>
        <!-- Error Message -->
        @if (session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        <!-- Login Form -->
        <form action="/login" method="POST" class="login-form" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input with-icon"
                        placeholder="Enter your email"
                        required
                        value="{{ old('email') }}"
                    >
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input with-icon"
                        placeholder="Enter your password"
                        required
                    >
                </div>
            </div>
             <div class="forgot-pass-link">
            <a href="/password/reset">Forgot Password?</a>
            </div>
            <button type="submit" class="login-button" id="loginBtn">
                Sign In
            </button>
        </form>
       
        <!-- Register Link -->
        <div class="register-link">
            <p>Don't have an account? <a href="/register">Create one here</a></p>
        </div>
    </div>
    <script>
        // Form submission handling
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginBtn');
            button.disabled = true;
            button.innerHTML = 'Signing In...';

            // Re-enable button after 3 seconds in case of issues or no redirect
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = 'Sign In';
            }, 3000);
        });

        // Input focus effects (simplified as original was for parentElement)
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#0E1B33';
                this.style.boxShadow = '0 0 0 3px rgba(14, 27, 51, 0.1)';
            });

            input.addEventListener('blur', function() {
                this.style.borderColor = '#e5e7eb';
                this.style.boxShadow = 'none';
            });
        });

        // Auto-focus first input
        document.getElementById('email').focus();
    </script>
</body>
</html>