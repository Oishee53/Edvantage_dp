<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Quiz</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Custom CSS Variables */
    :root {
      --primary-color: #0E1B33;
      --primary-light-hover-bg: #2D336B;
      --body-background: #f9fafb;
      --card-background: #ffffff;
      --text-default: #333;
      --text-gray-600: #4b5563;
      --text-gray-700: #374151;
      --text-gray-500: #6b7280;
      --border-color: #e5e7eb;
      --edit-bg: #EDF2FC;
      --edit-text: #0E1B33;
      --delete-bg: #FEF2F2;
      --delete-icon: #DC2626;
      --green-600: #059669;
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
      width: 18rem;
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      position: fixed;
      left: 0;
      top: 0;
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
      display: flex;
      flex-direction: column;
    }

    .sidebar-nav a {
      display: block;
      padding: 0.75rem 1.5rem;
      color: var(--primary-color);
      font-weight: 500;
      text-decoration: none;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
    }

    .sidebar-nav a:hover {
      background-color: #E3E6F3;
      color: var(--primary-color);
    }

    .sidebar-nav a.active {
      background-color: #E3E6F3;
      color: var(--primary-color);
    }


    /* Main Content Wrapper */
    .main-wrapper {
      margin-left: 17.5rem;
      flex: 1;
    }
    /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 2.75rem;
            border-radius: 0.25rem;
            border: 2px solid var(--primary-color);
            transition: all 0.2s ease-in-out;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .back-link:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
        }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
    }

    .top-bar-title {
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

    .logout-button, .login-button, .signup-button {
      padding: 0.5rem 0.75rem;
      border-radius: 0.25rem;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-weight: 500;
      transition: opacity 0.2s ease-in-out;
    }

    .logout-button, .signup-button {
      background-color: var(--primary-color);
      color: white;
    }

    .logout-button:hover, .signup-button:hover {
      opacity: 0.9;
    }

    .login-button {
      border: 1px solid var(--primary-color);
      color: var(--primary-color);
      background-color: transparent;
    }

    .login-button:hover {
      background-color: var(--primary-light-hover-bg);
      color: white;
    }

    .auth-buttons {
      display: flex;
      gap: 0.5rem;
    }

    /* Main Content */
    .main-content {
      padding: 2rem;
    }

    /* Form Styles */
    .form-container {
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    .form-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 2rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      font-weight: 500;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .form-input, .form-textarea, .form-select {
      width: 100%;
      border: 1px solid var(--border-color);
      border-radius: 0.25rem;
      padding: 0.75rem;
      outline: none;
      transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      font-family: 'Montserrat', sans-serif;
    }

    .form-input:focus, .form-textarea:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(14, 27, 51, 0.2);
    }

    .form-textarea {
      resize: vertical;
      min-height: 100px;
    }

    .form-input-small {
      width: auto;
      display: inline-block;
      min-width: 80px;
    }

    /* Question Section */
    .question-section {
      border: 1px solid var(--border-color);
      border-radius: 0.5rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      background-color: #fafbfc;
    }

    .question-title {
      font-size: 1.125rem;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }

    .option-group {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 0.75rem;
      padding: 0.5rem;
      background-color: var(--card-background);
      border-radius: 0.25rem;
      border: 1px solid var(--border-color);
    }

    .option-input {
      flex: 1;
      border: none;
      outline: none;
      padding: 0.25rem;
    }

    .radio-input {
      margin: 0;
    }

    .radio-label {
      font-size: 0.875rem;
      color: var(--text-gray-600);
      margin: 0;
    }

    /* Buttons */
    .btn-primary {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 0.25rem;
      font-weight: 500;
      cursor: pointer;
      transition: opacity 0.2s ease-in-out;
      font-family: 'Montserrat', sans-serif;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

    .btn-secondary {
      background-color: transparent;
      color: var(--primary-color);
      border: 1px solid var(--primary-color);
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
      font-family: 'Montserrat', sans-serif;
    }

    .btn-secondary:hover {
      background-color: var(--primary-color);
      color: white;
    }

    .divider {
      border: none;
      border-top: 1px solid var(--border-color);
      margin: 2rem 0;
    }

    .not-logged-in {
      text-align: center;
      color: var(--text-gray-700);
    }

    .login-link {
      color: var(--primary-color);
      text-decoration: none;
      transition: text-decoration 0.2s ease-in-out;
    }

    .login-link:hover {
      text-decoration: underline;
    }

    .course-info {
      background-color: var(--edit-bg);
      padding: 1rem;
      border-radius: 0.25rem;
      margin-bottom: 2rem;
      color: var(--edit-text);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage Logo">
      <span></span>
    </div>
    <nav class="sidebar-nav">
                @if(auth()->user()->role === 2)
                    <a href="/admin_panel">Dashboard</a>
                    <a href="/admin_panel/manage_courses" class="active">Manage Courses</a>
                    <a href="/admin_panel/manage_user">Manage Users</a>
                    <a href="/pending-courses">Manage Pending Courses ({{ $pendingCoursesCount ?? 0 }})</a>
                @elseif(auth()->user()->role === 3)
                    <a href="/instructor_homepage">Dashboard</a>
                    <a href="/instructor/manage_courses">Manage Courses</a>
                    <a href="/instructor/manage_user" class="active">Manage Users</a>
                @endif
            </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Top bar -->
    <header class="top-bar">
      <h1 class="top-bar-title">Add Quiz</h1>
      @auth
        <div class="user-info">
          <span>{{ auth()->user()->name }}</span>
          <form action="/logout" method="POST">
            @csrf
            <button class="logout-button">Logout</button>
          </form>
        </div>
      @else
        <div class="auth-buttons">
          <a href="/login" class="login-button">Login</a>
          <a href="/register" class="signup-button">Sign Up</a>
        </div>
      @endauth
    </header>

    <!-- Main Content -->
    <section class="main-content">
      @auth
        <div class="course-info">
          <strong>Course:</strong> {{ $course->title ?? 'Sample Course Title' }} | <strong>Lecture:</strong> {{ $moduleNumber ?? '1' }}
        </div>

        <div class="form-container">
          <h2 class="form-title">Add Quiz for Lecture {{ $moduleNumber ?? '1' }} of {{ $course->title ?? 'Sample Course' }}</h2>
          
          <form action="{{ route('quiz.store', ['course' => $course->id ?? 1, 'module' => $moduleNumber ?? 1]) }}" method="POST">
            @csrf

            <input type="hidden" name="course_id" value="{{ $course->id ?? 1 }}">
            <input type="hidden" name="module_number" value="{{ $moduleNumber ?? 1 }}">

            <div class="form-group">
              <label for="title" class="form-label">Quiz Title:</label>
              <input type="text" name="title" id="title" class="form-input" required>
            </div>

            <div class="form-group">
              <label for="description" class="form-label">Quiz Description:</label>
              <textarea name="description" id="description" class="form-textarea" required></textarea>
            </div>

            <hr class="divider">

            <div class="form-group">
              <label for="question_count" class="form-label">Number of Questions:</label>
              <input type="number" name="question_count" id="question_count" class="form-input form-input-small" min="1" max="20" value="5" required>
            </div>

            <div id="questions-section">
              {{-- Questions will be generated by JavaScript --}}
            </div>

            <button type="submit" class="btn-primary">Create Quiz</button>
          </form>
          <a href="javascript:history.back()" class="back-link">
            Back
          </a>

        </div>

        <script>
          document.getElementById('question_count').addEventListener('change', generateQuestions);

          function generateQuestions() {
            const count = parseInt(document.getElementById('question_count').value);
            const container = document.getElementById('questions-section');
            container.innerHTML = '';

            for (let i = 1; i <= count; i++) {
              const qDiv = document.createElement('div');
              qDiv.className = 'question-section';
              qDiv.innerHTML = `
                <h4 class="question-title">Question ${i}</h4>
                <div class="form-group">
                  <label class="form-label">Question Text:</label>
                  <input type="text" name="questions[${i}][text]" class="form-input" required>
                </div>

                <div class="form-group">
                  <label class="form-label">Number of Options:</label>
                  <input type="number" name="questions[${i}][option_count]" class="form-input form-input-small" min="2" max="6" value="4" onchange="generateOptions(${i}, this.value)" required>
                </div>

                <div id="options-${i}">
                  <!-- Options will be generated here -->
                </div>
              `;
              container.appendChild(qDiv);
              generateOptions(i, 4); // Default 4 options
            }
          }

          function generateOptions(qIndex, count) {
            const optContainer = document.getElementById(`options-${qIndex}`);
            optContainer.innerHTML = '';

            for (let j = 1; j <= count; j++) {
              const optionDiv = document.createElement('div');
              optionDiv.className = 'option-group';
              optionDiv.innerHTML = `
                <input type="text" name="questions[${qIndex}][options][${j}][text]" class="option-input" placeholder="Option ${j}" required>
                <input type="radio" name="questions[${qIndex}][correct]" value="${j}" class="radio-input" required>
                <label class="radio-label">Correct</label>
              `;
              optContainer.appendChild(optionDiv);
            }
          }

          // Initial load
          generateQuestions();
        </script>

      @else
        <p class="not-logged-in">You are not logged in. <a href="/" class="login-link">Go to Login</a></p>
      @endauth
    </section>
  </div>

</body>
</html>
