<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses</title>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    /* Custom CSS Variables */
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
      --edit-bg: #EDF2FC;
      --edit-text: #0E1B33;
      --delete-bg: #FEF2F2;
      --delete-icon: #DC2626;
      --green-600: #059669;
      --success-color: #059669;
      --warning-color: #f59e0b;
      --purple-color: #8b5cf6;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background-color: var(--body-background);
      margin: 0;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
      width: 17.5rem;
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
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
    }

    .sidebar-nav a.active {
      background-color: var(--primary-light-hover-bg);
      color: var(--primary-color);
    }

    /* Main Content Wrapper */
    .main-wrapper {
      margin-left: 17.5rem;
      flex: 1;
      max-width: calc(100vw - 17.5rem);
      overflow-x: hidden;
    }

    .main-content {
      flex: 1;
      padding: 2rem;
      max-width: 100%;
      box-sizing: border-box;
    }

    /* Top bar */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      flex-wrap: wrap;
      gap: 1rem;
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

    .logout-button {
      padding: 0.5rem 0.75rem;
      border-radius: 0.25rem;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
      background-color: var(--primary-color);
      color: white;
    }

    .logout-button:hover {
      opacity: 0.9;
    }

    /* Add Course Button */
    .add-course-button {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background-color: var(--primary-color);
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 0.375rem;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
      white-space: nowrap;
      margin-left: auto;
    }

    .add-course-button:hover {
      background-color: #1a2645;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(14, 27, 51, 0.2);
    }

    /* Section Headers */
    .section-header {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--primary-color);
      margin: 2rem 0 1rem 0;
      padding-left: 0.5rem;
      border-left: 4px solid var(--primary-color);
    }

    .section-header:first-of-type {
      margin-top: 1rem;
    }

    /* Course Card - NEW STYLE */
    .course-card {
      background: var(--card-background);
      border-radius: 0.5rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .course-card:hover {
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
      transform: translateY(-2px);
    }

    .course-header {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border-color);
    }

    .course-image-large {
      width: 120px;
      height: 90px;
      object-fit: cover;
      border-radius: 0.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .course-info {
      flex: 1;
    }

    .course-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 0.5rem;
    }

    .course-meta {
      display: flex;
      gap: 1.5rem;
      font-size: 0.875rem;
      color: var(--text-gray-600);
    }

    .course-meta-item {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .course-actions {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
      margin-top: 0.5rem;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 0.375rem;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      font-size: 0.875rem;
      font-weight: 500;
      text-decoration: none;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .btn-primary {
      background-color: var(--primary-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: #1a2645;
      transform: translateY(-1px);
    }

    .btn-view {
      background-color: #3b82f6;
      color: white;
    }

    .btn-view:hover {
      background-color: #2563eb;
    }

    .btn-edit {
      background-color: #6366f1;
      color: white;
    }

    .btn-edit:hover {
      background-color: #4f46e5;
    }

    .btn-success {
      background-color: var(--success-color);
      color: white;
    }

    .btn-success:hover {
      background-color: #047857;
    }

    .btn-purple {
      background-color: var(--purple-color);
      color: white;
    }

    .btn-purple:hover {
      background-color: #7c3aed;
    }

    .btn-warning {
      background-color: var(--warning-color);
      color: white;
    }

    .btn-warning:hover {
      background-color: #d97706;
    }

    /* Final Exam Section - NEW */
    .final-exam-section {
      margin-top: 1rem;
      padding-top: 1rem;
      border-top: 2px solid #f3f4f6;
    }

    .final-exam-header {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-bottom: 0.75rem;
    }

    .final-exam-header h4 {
      font-size: 1rem;
      color: var(--primary-color);
      margin: 0;
    }

    .exam-status-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.25rem;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .exam-status-draft {
      background-color: #fef3c7;
      color: #92400e;
    }

    .exam-status-published {
      background-color: #d1fae5;
      color: #065f46;
    }

    .exam-info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
      gap: 0.75rem;
      margin: 0.75rem 0;
      padding: 0.75rem;
      background: #f9fafb;
      border-radius: 0.375rem;
    }

    .exam-info-item {
      font-size: 0.75rem;
    }

    .exam-info-label {
      color: var(--text-gray-600);
      margin-bottom: 0.25rem;
    }

    .exam-info-value {
      font-weight: 600;
      color: var(--primary-color);
      font-size: 0.875rem;
    }

    .pending-badge {
      background-color: #fee2e2;
      color: #dc2626;
      padding: 0.125rem 0.5rem;
      border-radius: 10px;
      font-size: 0.75rem;
      font-weight: 600;
      margin-left: 0.25rem;
    }

    .no-courses {
      text-align: center;
      color: var(--text-gray-500);
      font-style: italic;
      padding: 3rem 2rem;
      background-color: var(--card-background);
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .sidebar {
        width: 16rem;
      }
      
      .main-wrapper {
        margin-left: 16rem;
        max-width: calc(100vw - 16rem);
      }

      .add-course-button {
        margin-left: 0;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
      
      .main-wrapper {
        margin-left: 0;
        max-width: 100vw;
      }
      
      .main-content {
        padding: 1rem;
      }

      .course-header {
        flex-direction: column;
      }

      .course-image-large {
        width: 100%;
        height: 150px;
      }

      .course-actions {
        justify-content: stretch;
      }

      .btn {
        flex: 1;
        justify-content: center;
      }

      .exam-info-grid {
        grid-template-columns: 1fr 1fr;
      }

      .top-bar {
        flex-direction: column;
        align-items: stretch;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="/image/Edvantage.png" alt="Edvantage Logo">
    </div>
    <nav class="sidebar-nav">
      <a href="/instructor_homepage">Dashboard</a>
      <a href="/instructor/manage_courses" class="active">Manage Course</a>
    </nav>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="main-wrapper">
    <!-- Main Content -->
    <main class="main-content">
      <!-- Top bar -->
      <div class="top-bar">
        <div class="top-bar-title">Manage Courses</div>
        @auth
          <div class="user-info">
            <span>{{ auth()->user()->name }}</span>
            <form action="/logout" method="POST" style="display: inline;">
              @csrf
              <button class="logout-button">Logout</button>
            </form>
          </div>
        @endauth
      </div>

      @auth
      <!-- Add Course Button -->
      <div style="margin-bottom: 2rem;">
        <form action="/manage_courses/add" method="GET">
          <button type="submit" class="add-course-button">
            ➕ Add New Course
          </button>
        </form>
      </div>

      <!-- Approved Courses Section -->
      <p class="section-header">Approved Courses</p>
      @if(isset($courses) && $courses->isEmpty())
          <div class="no-courses">No approved courses available.</div>
      @else
          @foreach($courses as $course)
              <div class="course-card">
                <div class="course-header">
                  @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image-large">
                  @endif
                  
                  <div class="course-info">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <div class="course-meta">
                      <span class="course-meta-item">📚 {{ $course->category }}</span>
                      <span class="course-meta-item">🎥 {{ $course->video_count }} videos</span>
                      <span class="course-meta-item">⏱️ {{ $course->total_duration }} hrs</span>
                      <span class="course-meta-item" style="color: var(--success-color); font-weight: 600;">৳{{ $course->price }}</span>
                    </div>
                    <p style="color: var(--text-gray-600); font-size: 0.875rem; margin-top: 0.5rem;">
                      {{ Str::limit($course->description, 100) }}
                    </p>
                  </div>
                </div>

                <div class="course-actions">
                  <a href="{{ url("/admin_panel/manage_resources/{$course->id}/modules") }}" class="btn btn-primary">
                    📂 Manage Modules
                  </a>
                </div>

                <!-- 🆕 FINAL EXAM SECTION -->
                <div class="final-exam-section">
                  <div class="final-exam-header">
                    <h4>📝 Final Exam</h4>
                    @php
                        $finalExam = \App\Models\FinalExam::where('course_id', $course->id)->first();
                    @endphp
                    
                    @if($finalExam)
                        @if($finalExam->status === 'draft')
                            <span class="exam-status-badge exam-status-draft">📄 Draft</span>
                        @else
                            <span class="exam-status-badge exam-status-published">✅ Published</span>
                        @endif
                    @endif
                  </div>

                  @if($finalExam)
                      <!-- Exam exists - show details and actions -->
                      <div class="exam-info-grid">
                        <div class="exam-info-item">
                          <div class="exam-info-label">Questions</div>
                          <div class="exam-info-value">{{ $finalExam->questions()->count() }}</div>
                        </div>
                        <div class="exam-info-item">
                          <div class="exam-info-label">Total Marks</div>
                          <div class="exam-info-value">{{ $finalExam->total_marks }}</div>
                        </div>
                        <div class="exam-info-item">
                          <div class="exam-info-label">Duration</div>
                          <div class="exam-info-value">{{ $finalExam->duration_minutes }} min</div>
                        </div>
                        <div class="exam-info-item">
                          <div class="exam-info-label">Submissions</div>
                          <div class="exam-info-value">
                            {{ $finalExam->submissions()->count() }}
                            @php
                                $pendingCount = $finalExam->pendingGradingSubmissions()->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="pending-badge">{{ $pendingCount }}</span>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="course-actions">
                        <!-- View Exam -->
                        <a href="{{ route('instructor.final-exams.show', $finalExam->id) }}" class="btn btn-view">
                          👁️ View Exam
                        </a>

                        <!-- Edit (only if no submissions) -->
                        @if(!$finalExam->submissions()->exists())
                            <a href="{{ route('instructor.final-exams.edit', $finalExam->id) }}" class="btn btn-edit">
                              ✏️ Edit Exam
                            </a>
                        @endif

                        <!-- Publish (if draft) -->
                        @if($finalExam->status === 'draft')
                            <form action="{{ route('instructor.final-exams.publish', $finalExam->id) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-success" onclick="return confirm('Publish this exam? Students will be able to take it.')">
                                ✅ Publish Exam
                              </button>
                            </form>
                        @endif

                        <!-- Unpublish (if published and no submissions) -->
                        @if($finalExam->status === 'published' && !$finalExam->submissions()->whereIn('status', ['submitted', 'graded'])->exists())
                            <form action="{{ route('instructor.final-exams.unpublish', $finalExam->id) }}" method="POST" style="display: inline;">
                              @csrf
                              <button type="submit" class="btn btn-warning" onclick="return confirm('Unpublish this exam? Students will not be able to see it.')">
                                ⏸️ Unpublish
                              </button>
                            </form>
                        @endif

                        <!-- View Submissions -->
                        <a href="{{ route('instructor.final-exams.submissions', $finalExam->id) }}" class="btn btn-purple">
                          📊 View Submissions
                          @if($pendingCount > 0)
                              <span style="background: white; color: var(--purple-color); padding: 0.125rem 0.5rem; border-radius: 10px; font-size: 0.75rem; font-weight: 700;">
                                {{ $pendingCount }}
                              </span>
                          @endif
                        </a>
                      </div>
                  @else
                      <!-- No exam yet - show create button -->
                      <div style="text-align: center; padding: 1rem; background: #f3f4f6; border-radius: 0.375rem;">
                        <p style="color: var(--text-gray-600); margin-bottom: 1rem; font-size: 0.875rem;">
                          No final exam created for this course yet.
                        </p>
                        <a href="{{ route('instructor.final-exams.create') }}?course_id={{ $course->id }}" class="btn btn-primary">
                          ➕ Create Final Exam
                        </a>
                      </div>
                  @endif
                </div>
              </div>
          @endforeach
      @endif

      <!-- Pending Courses Section -->
      <p class="section-header">Pending Courses (Awaiting Admin Approval)</p>
      @if(isset($pendingCourses) && $pendingCourses->isEmpty())
          <div class="no-courses">No pending courses available.</div>
      @else
          @foreach($pendingCourses as $course)
              <div class="course-card" style="border-left: 4px solid var(--warning-color);">
                <div class="course-header">
                  @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image-large">
                  @endif
                  
                  <div class="course-info">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <div class="course-meta">
                      <span class="course-meta-item">📚 {{ $course->category }}</span>
                      <span class="course-meta-item">🎥 {{ $course->video_count }} videos</span>
                      <span class="course-meta-item">⏱️ {{ $course->total_duration }} hrs</span>
                      <span class="course-meta-item" style="color: var(--success-color); font-weight: 600;">৳{{ $course->price }}</span>
                    </div>
                    <div style="margin-top: 0.5rem;">
                      @if(\App\Models\CourseNotification::where('pending_course_id', $course->id)->exists())
                        <span style="display: inline-block; background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                          ✅ Submitted for Approval
                        </span>
                      @else
                        <span style="display: inline-block; background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                          ⚠️ Not Yet Submitted
                        </span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="course-actions">
                  <a href="{{ url("/instructor/manage_resources/{$course->id}/modules") }}" class="btn btn-primary">
                    📂 Manage Modules
                  </a>
                  
                  <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="GET" style="display: inline;">
                    <button type="submit" class="btn btn-edit">
                      ✏️ Edit Course
                    </button>
                  </form>
                  
                  <form action="/admin_panel/manage_courses/delete-course/{{ $course->id }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background-color: var(--delete-bg); color: var(--delete-icon);" onclick="return confirm('Are you sure you want to delete this course?');">
                      🗑️ Delete
                    </button>
                  </form>
                </div>

                <div style="margin-top: 1rem; padding: 0.75rem; background: #fef3c7; border-radius: 0.375rem; font-size: 0.875rem; color: #92400e;">
                  <strong>Note:</strong> You can only create final exams for approved courses. This course is awaiting admin approval.
                </div>
              </div>
          @endforeach
      @endif

      @else
      <div style="text-align: center; padding: 3rem;">
        <p>You are not logged in. <a href="/" style="color: var(--primary-color); text-decoration: underline;">Go to Login</a></p>
      </div>
      @endauth
    </main>
  </div>
</body>
</html>