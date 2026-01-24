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
            min-height: 100vh;
            display: flex;
            position: relative;
            overflow: hidden;
        }

        /* Top Logo */
        .top-logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
            font-size: 2rem;
            font-weight: bold;
            color: #0E1B33;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
        .top-logo img {
            height: 40px;
            vertical-align: middle;
        }

        /* Left Side - Form Container */
        .left-container {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            z-index: 5;
            order: 2; /* FORM ON RIGHT */
        }

        /* Right Side - Image Container */
        .right-container {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            order: 1; /* IMAGE ON LEFT */
        }

        .right-container img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            animation: fadeIn 1s ease forwards;
        }

        /* Main Container */
        .login-container {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            animation: fadeInUp 0.8s ease forwards;
        }

        /* Login Header */
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0E1B33;
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
            border-color: #0E1B33;
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 27, 51, 0.1);
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
            color: #0E1B33;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .forgot-pass-link a:hover {
            color: #475569;
            text-decoration: underline;
        }

        /* Login Button */
        .login-button {
            width: 100%;
            background: #0E1B33;
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
            background: linear-gradient(135deg, #334155 0%, #475569 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(14, 27, 51, 0.3);
        }
        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
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
            color: #0E1B33;
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            body {
                flex-direction: column;
            }
            .right-container {
                display: none;
            }
            .left-container {
                min-height: 100vh;
                background: linear-gradient(135deg, #0E1B33 0%, #334155 100%);
                order: 1;
            }
            .left-container::before {
                content: '';
                position: absolute;
                inset: 0;
                background: url('/image/hero.png') center/cover;
                opacity: 0.4;
                z-index: 1;
            }
            .login-container {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                position: relative;
                z-index: 5;
            }
            .top-logo {
                color: white;
            }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body>

<div class="top-logo">
    <a href="/">
        <img src="/image/Edvantage.png" alt="EDVANTAGE Logo">
    </a>
</div>

<div class="left-container">
    <div class="login-container">
        <div class="login-header">
            <h2 class="login-title">Sign in</h2>
            <p class="login-subtitle">Welcome back! Please enter your credentials.</p>
        </div>

        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif

        <form action="/login" method="POST" class="login-form" id="loginForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" required>
            </div>

            <div class="forgot-pass-link">
                <a href="/password/reset">Forgot Password?</a>
            </div>

            <button type="submit" class="login-button" id="loginBtn">Sign In</button>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="/register">Create one here</a></p>
        </div>
    </div>
</div>

<div class="right-container">
    <img src="/image/login.jpg" alt="Education Illustration">
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function () {
        const btn = document.getElementById('loginBtn');
        btn.disabled = true;
        btn.innerText = 'Signing In...';
        setTimeout(() => {
            btn.disabled = false;
            btn.innerText = 'Sign In';
        }, 3000);
    });
</script>

</body>
</html>
