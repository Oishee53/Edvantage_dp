<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Course | Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Removed Tailwind CDN and config, added custom CSS variables -->
  <style>
    :root {
      --primary-color: #0E1B33;
      --primary-light-hover-bg:  #E3E6F3;
      --body-background: #f9fafb;
      --card-background: #ffffff;
      --text-default: #333;
      --text-gray-600: #4b5563;
      --text-gray-700: #374151;
      --text-gray-500: #6b7280;
      --border-color: #e5e7eb;
      --danger-color: #ef4444;
      --muted-color: #64748b;
      --gray-100: #f3f4f6;
      --blue-50: #eff6ff;
      --red-50: #fef2f2;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--body-background);
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 256px;
      background-color: var(--card-background);
      min-height: 100vh;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--primary-color);
      font-weight: 700;
      font-size: 20px;
    }

    .sidebar-header img {
      height: 40px;
    }

    .sidebar-nav {
      margin-top: 40px;
    }

    .sidebar-nav a {
      display: block;
      padding: 12px 24px;
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
    }

    .sidebar-nav a:hover {
      background-color: var(--primary-light-hover-bg);
      color: #0E1B33;
    }

    .main-content {
      flex: 1;
      padding: 32px;
    }

    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }

    .page-title {
      font-size: 24px;
      font-weight: 400;
      color: var(--primary-color);
    }

    .user-section {
      display: flex;
      align-items: center;
      gap: 16px;
    }

    .user-name {
      color: var(--primary-color);
      font-weight: 500;
    }

    .logout-btn {
      background-color: var(--primary-color);
      color: var(--card-background);
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: opacity 0.2s;
    }

    .logout-btn:hover {
      opacity: 0.9;
    }

    .form-container {
      background-color: var(--card-background);
      max-width: 448px;
      margin: 0 auto;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      border: 2px solid var(--primary-color);
      position: relative;
      overflow: hidden;
    }

    .form-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 6px;
      background: linear-gradient(to right, var(--primary-color), var(--border-color));
      border-radius: 12px 12px 0 0;
    }

    .form-title {
      font-size: 20px;
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 24px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 20px;
      position: relative;
    }

    .form-label {
      font-size: 16px;
      font-weight: 500;
      color: var(--text-gray-700);
    }

    .required {
      color: var(--danger-color);
      font-size: 16px;
    }

    .form-input, .form-select, .form-textarea {
      padding: 8px 12px;
      border: 1px solid var(--border-color);
      border-radius: 6px;
      font-size: 16px;
      background-color: var(--gray-100);
      color: var(--text-gray-700);
      outline: none;
      transition: all 0.2s;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
      border-color: var(--primary-color);
      background-color: var(--blue-50);
    }

    .form-textarea {
      min-height: 80px;
      max-height: 180px;
      resize: vertical;
    }

    .current-image {
      width: 96px;
      height: 96px;
      object-fit: cover;
      border-radius: 8px;
      margin: 8px 0;
      border: 1px solid var(--border-color);
      display: block;
    }

    .small-text {
      color: var(--muted-color);
      font-size: 14px;
    }

    .divider {
      border-top: 2px dashed var(--border-color);
      margin: 16px 0;
      width: 100%;
    }

    .submit-btn {
      background-color: var(--primary-color);
      color: var(--card-background);
      font-weight: 600;
      font-size: 18px;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 12px;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      transition: background-color 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
    }

    .submit-btn:hover {
      background-color: #223c6c;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary-color);
      text-decoration: none;
      font-weight: 500;
      margin-top: 16px;
      transition: color 0.2s;
    }

    .back-link:hover {
      color: #223c6c;;
    }

    .error-message {
      color: var(--danger-color);
      background-color: var(--red-50);
      padding: 16px;
      border-radius: 8px;
      text-align: center;
      margin-top: 32px;
      font-size: 18px;
    }

    .error-message a {
      color: var(--primary-color);
      text-decoration: underline;
      margin-left: 4px;
      font-weight: 500;
      transition: color 0.2s;
    }

    .error-message a:hover {
      color: var(--primary-light-hover-bg);
    }

    @media (min-width: 768px) {
      .form-container {
        max-width: 512px;
      }
    }

    @media (min-width: 1024px) {
      .form-container {
        max-width: 576px;
      }
    }
  </style>
</head>
<body>
  @auth
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage Logo">
    </div>
    <nav class="sidebar-nav">
            @if(auth()->user() && auth()->user()->role === 2)
                <a href="/admin_panel">Dashboard</a>
                <a href="/admin_panel/manage_courses">Manage Courses</a>
                <a href="/admin_panel/manage_courses" class="active">Manage Courses</a>
                <a href="/admin_panel/manage_user">Manage User</a>
                <a href="/admin_panel/manage_resources">Manage Resources</a>
            @elseif(auth()->user() && auth()->user()->role === 3)
                <a href="/instructor_homepage">Dashboard</a>
                <a href="/instructor/manage_courses">Manage Course</a>
                <a href="/instructor/manage_resources/add">Manage Resources</a>
            @endif
        </nav>
  </aside>

  <!-- Main content -->
  <main class="main-content">
    <!-- Top bar -->
    <div class="top-bar">
      <div class="page-title">Edit Course</div>
      @auth
        <div class="user-section">
          <span class="user-name">{{ auth()->user()->name }}</span>
          <form action="/logout" method="POST">
            @csrf
            <button class="logout-btn">
              Logout
            </button>
          </form>
        </div>
      @endauth
    </div>

    <div class="form-container">
      <h2 class="form-title">
        <i class="fas fa-pen-to-square"></i> Edit Course
      </h2>
      <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="form-label">Course Image</label>
          @if($course->image)
            <img src="{{ asset('storage/' . $course->image) }}" class="current-image" alt="{{ $course->title }}">
            <small class="small-text">Choose new image to replace:</small>
          @else
            <small class="small-text">No image uploaded.</small>
          @endif
          <input type="file" name="image" accept="image/*" class="form-input" />
        </div>

        <div class="form-group">
          <label for="title" class="form-label">Course Title <span class="required">*</span></label>
          <input type="text" id="title" name="title" value="{{ old('title', $course->title) }}" required class="form-input" />
        </div>

        <div class="form-group">
          <label for="description" class="form-label">Course Description</label>
          <textarea id="description" name="description" class="form-textarea">{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="form-group">
          <label for="category" class="form-label">Category <span class="required">*</span></label>
          <select id="category" name="category" required class="form-select">
            <option value="">Select Category</option>
            <option value="Web Development" {{ old('category', $course->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
            <option value="Mobile Development" {{ old('category', $course->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
            <option value="Data Science" {{ old('category', $course->category) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
            <option value="Machine Learning" {{ old('category', $course->category) == 'Machine Learning' ? 'selected' : '' }}>Machine Learning</option>
            <option value="Design" {{ old('category', $course->category) == 'Design' ? 'selected' : '' }}>Design</option>
            <option value="Business" {{ old('category', $course->category) == 'Business' ? 'selected' : '' }}>Business</option>
            <option value="Marketing" {{ old('category', $course->category) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
            <option value="Other" {{ old('category', $course->category) == 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>

        <div class="form-group">
          <label for="video_count" class="form-label">Number of Lectures <span class="required">*</span></label>
          <input type="number" id="video_count" name="video_count" value="{{ old('video_count', $course->video_count) }}" min="1" required class="form-input" />
        </div>

        <div class="form-group">
          <label for="approx_video_length" class="form-label">Approx. Video Length (minutes) <span class="required">*</span></label>
          <input type="number" id="approx_video_length" name="approx_video_length" value="{{ old('approx_video_length', $course->approx_video_length) }}" min="1" required class="form-input" />
        </div>

        <div class="form-group">
          <label for="total_duration" class="form-label">Total Duration (hours) <span class="required">*</span></label>
          <input type="number" id="total_duration" name="total_duration" value="{{ old('total_duration', $course->total_duration) }}" step="0.1" min="0.1" required class="form-input" />
        </div>

        <div class="form-group">
          <label for="price" class="form-label">Price (৳) <span class="required">*</span></label>
          <input type="number" id="price" name="price" value="{{ old('price', $course->price) }}" step="0.1" min="0" required class="form-input" />
        </div>

        <hr class="divider" />

        <button type="submit" class="submit-btn">
          Update Course
        </button>
      </form>

       @if(auth()->user()->role === 2)
          <a class="back-link" href="/admin_panel/manage_courses"><i class="fas fa-arrow-left"></i> Back to Manage Courses</a>
        @elseif(auth()->user()->role === 3)
          <a class="back-link" href="/instructor/manage_courses"><i class="fas fa-arrow-left"></i> Back to Manage Courses</a>
        @endif
      @else
        <p class="error-message">You are not logged in.<a href="/">Go to Login</a></p>
      @endauth
    </div>
  </main>
</body>
</html>
