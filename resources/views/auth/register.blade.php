<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EDVANTAGE</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
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
            overflow-y: auto; /* ✅ allow page scroll */
        }

        /* ================= LOGO ================= */
        .top-logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 10;
        }
        .top-logo img {
            height: 40px;
        }

        /* ================= LEFT ================= */
        .left-container {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .left-container img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            animation: fadeIn 1s ease forwards;
        }

        /* ================= RIGHT ================= */
        .right-container {
            flex: 1;
            background: white;
            display: flex;
            align-items: center; /* ✅ vertical center */
            justify-content: center;
            padding: 3rem;
        }

        /* ================= FORM ================= */
        .register-container {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            animation: fadeInUp 0.8s ease forwards;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #0E1B33;
        }

        .register-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* ================= ERRORS ================= */
        .error-messages {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .error-messages ul {
            list-style: none;
        }

        .error-messages li {
            margin-bottom: 0.5rem;
        }

        /* ================= FORM ================= */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #0E1B33;
            background: white;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .register-button {
            width: 100%;
            background: #0E1B33;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }

        /* ================= LOGIN LINK ================= */
        .login-link {
            text-align: center;
            margin-top: 2rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 1.5rem;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 1024px) {
            body {
                flex-direction: column;
            }

            .left-container {
                display: none;
            }

            .right-container {
                min-height: 100vh;
                background: linear-gradient(135deg, #0E1B33, #334155);
            }

            .right-container::before {
                content: '';
                position: absolute;
                inset: 0;
                background: url('/image/hero.png') center/cover;
                opacity: 0.4;
                z-index: 0;
            }

            .register-container {
                position: relative;
                z-index: 1;
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(15px);
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
    <img src="/image/login.jpg" alt="Education Illustration">
</div>

<div class="right-container">
    <div class="register-container">

        <div class="register-header">
            <h2 class="register-title">Create Account</h2>
            <p class="register-subtitle">Join EDVANTAGE and start your learning journey</p>
        </div>

        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/register" method="POST" id="registerForm">
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-input" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-input" required value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-input" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Area of Interest</label>
                <input type="text" name="field" class="form-input" value="{{ old('field') }}">
            </div>

            <div class="form-row">
                <input type="password" name="password" class="form-input" placeholder="Password" required>
                <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm" required>
            </div>

            <button class="register-button" id="registerBtn">Create Account</button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="/login">Sign in here</a></p>
        </div>

    </div>
</div>

</body>
</html>
