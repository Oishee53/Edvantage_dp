<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Resources - {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        .heading-font {
            font-family: 'Playfair Display', Georgia, serif;
        }
        
        body {
            background: #f9fafb;
            letter-spacing: -0.01em;
        }
        
        .main-container {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Video Player Section */
        .video-section {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .video-container {
            background: #000;
            aspect-ratio: 16/9;
            position: relative;
        }

        .video-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d7377 0%, #14b8a6 100%);
            color: white;
        }

        .play-overlay {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .play-overlay:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .content-area {
            padding: 2rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        .breadcrumb a {
            color: #0d7377;
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb a:hover {
            color: #0a5c5f;
        }

        .course-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0d7377;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .lecture-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .lecture-meta {
            display: flex;
            gap: 1.5rem;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 2rem;
            border-bottom: 2px solid #f3f4f6;
            margin-bottom: 2rem;
        }

        .tab {
            padding: 0.75rem 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            letter-spacing: -0.01em;
        }

        .tab.active {
            color: #0d7377;
            border-bottom-color: #0d7377;
        }

        .tab:hover {
            color: #0d7377;
        }

        /* Tab Content */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Resource Cards */
        .resource-card {
            background: #f9fafb;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid #f3f4f6;
            transition: all 0.2s;
        }

        .resource-card:hover {
            border-color: #0d7377;
            background: white;
        }

        .resource-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .resource-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .resource-icon {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #e5e7eb;
        }

        .resource-icon i {
            color: #0d7377;
            font-size: 1.25rem;
        }

        .resource-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
            letter-spacing: -0.01em;
        }

        .resource-subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .btn-resource {
            padding: 0.625rem 1.25rem;
            background: #0d7377;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: -0.01em;
        }

        .btn-resource:hover {
            background: #0a5c5f;
            transform: translateY(-1px);
        }

        /* Sidebar */
        .sidebar {
            position: sticky;
            top: 2rem;
            height: fit-content;
        }

        .sidebar-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            margin-bottom: 1.5rem;
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        .info-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            letter-spacing: -0.01em;
        }

        /* Question Form */
        .question-form {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }

        .form-input {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        .form-input:focus {
            outline: none;
            border-color: #0d7377;
            box-shadow: 0 0 0 3px rgba(13, 115, 119, 0.1);
        }

        .form-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        .btn-submit {
            padding: 0.875rem 1.5rem;
            background: #0d7377;
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            margin-top: 1rem;
            letter-spacing: -0.01em;
        }

        .btn-submit:hover {
            background: #0a5c5f;
            transform: translateY(-1px);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: #f9fafb;
            border-radius: 12px;
            border: 1px solid #f3f4f6;
        }

        .empty-icon {
            width: 64px;
            height: 64px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
        }

        .empty-icon i {
            font-size: 1.75rem;
            color: #9ca3af;
        }

        .empty-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .empty-text {
            color: #6b7280;
            font-size: 0.95rem;
            font-weight: 500;
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }
        }
    </style>
</head>
<body class="min-h-screen px-20 pt-5">
    @include('layouts.header')

    <div class="pt-24">
        <div class="main-container">
            <!-- Left Content Area -->
            <div>
                <!-- Video Section -->
                <div class="video-section mb-6">
                    @auth
                        @if($resource->videos)
                            <div id="videoPlayer">
                                <mux-player 
                                    id="mux-player"
                                    playback-id="{{ $resource->videos }}"
                                    stream-type="on-demand"
                                    controls
                                    class="w-full aspect-video">
                                </mux-player>
                            </div>
                        @else
                            <div class="video-placeholder">
                                <div class="play-overlay">
                                    <i class="fas fa-play" style="font-size: 2rem; margin-left: 4px;"></i>
                                </div>
                                <p style="font-size: 1rem; opacity: 0.9; font-weight: 500;">No video available for this lecture</p>
                            </div>
                        @endif
                    @else
                        <div class="video-placeholder">
                            <div style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                <i class="fas fa-lock" style="font-size: 1.5rem;"></i>
                            </div>
                            <p style="font-size: 1rem; opacity: 0.9; font-weight: 500;">Please log in to view content</p>
                        </div>
                    @endauth
                </div>

                <!-- Content Area -->
                <div class="content-area">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb">
                        <a href="/my-courses">My Courses</a>
                        <span>/</span>
                        <a href="{{ route('user.course.modules', $course->id) }}">{{ $course->name }}</a>
                        <span>/</span>
                        <span>Lecture {{ $moduleNumber }}</span>
                    </div>

                    <!-- Flash Messages -->
                    @if(session('error'))
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Lecture Header -->
                    <div class="course-title">{{ $course->title }}</div>
                    <h1 class="lecture-title heading-font">{{ $course->name }}</h1>
                    <div class="lecture-meta">
                        <div class="meta-item">
                            <i class="fas fa-book-open" style="color: #0d7377;"></i>
                            <span>Lecture {{ $moduleNumber }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock" style="color: #0d7377;"></i>
                            <span>Self-paced</span>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="tabs">
                        <div class="tab active" data-tab="resources">Resources</div>
                        <div class="tab" data-tab="discussion">Discussion</div>
                        <div class="tab" data-tab="quiz">Quiz</div>
                        <div class="tab" data-tab="ask-question">Ask Question</div>
                    </div>

                    <!-- Tab Content: Resources (PDF Only) -->
                    <div class="tab-content active" id="resources-content">
                        @auth
                            @if($resource->pdf)
                                <div class="resource-card">
                                    <div class="resource-header">
                                        <div class="resource-info">
                                            <div class="resource-icon">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <div class="resource-title">PDF Document</div>
                                                <div class="resource-subtitle">Download or view lecture materials</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="btn-resource">
                                            <i class="fas fa-external-link-alt"></i>
                                            View PDF
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="empty-title heading-font">No PDF Available</div>
                                    <div class="empty-text">There are no PDF resources for this lecture yet.</div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="empty-title heading-font">Login Required</div>
                                <div class="empty-text">Please log in to access lecture resources.</div>
                            </div>
                        @endauth
                    </div>

                    <!-- Tab Content: Discussion (Forum Only) -->
                    <div class="tab-content" id="discussion-content">
                        @if($forum)
                            <x-discussion-forum :forum="$forum" :course="$course" />
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div class="empty-title heading-font">No Discussion Available</div>
                                <div class="empty-text">Discussion forum is not available for this lecture.</div>
                            </div>
                        @endif
                    </div>

                    <!-- Tab Content: Quiz (Quiz Only) -->
                    <div class="tab-content" id="quiz-content">
                        @auth
                            @if($quiz)
                                <div class="resource-card">
                                    <div class="resource-header">
                                        <div class="resource-info">
                                            <div class="resource-icon">
                                                <i class="fas fa-question-circle"></i>
                                            </div>
                                            <div>
                                                <div class="resource-title">Lecture Quiz</div>
                                                <div class="resource-subtitle">Test your knowledge</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('user.quiz.start', ['course' => $course->id, 'module' => $moduleNumber]) }}"
                                           class="btn-resource">
                                            <i class="fas fa-play"></i>
                                            Take Quiz
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <div class="empty-title heading-font">No Quiz Available</div>
                                    <div class="empty-text">There is no quiz for this lecture yet.</div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div class="empty-title heading-font">Login Required</div>
                                <div class="empty-text">Please log in to access the quiz.</div>
                            </div>
                        @endauth
                    </div>

                    <!-- Tab Content: Ask Question (Question Form Only) -->
                    <div class="tab-content" id="ask-question-content">
                        <div class="question-form">
                            <form action="{{ route('questions.store') }}" method="POST">
                                @csrf
                                <label for="question" class="form-label">
                                    <i class="fas fa-comment-dots" style="color: #0d7377; margin-right: 0.5rem;"></i>
                                    Ask a Question
                                </label>
                                <input type="text" 
                                       id="question" 
                                       name="question"
                                       class="form-input"
                                       placeholder="Type your question here..."
                                       required>

                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="module_number" value="{{ $moduleNumber }}">

                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane"></i>
                                    Post Question
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="sidebar">
                <!-- Lecture Info -->
                <div class="sidebar-section">
                    <div class="sidebar-title heading-font">Lecture Details</div>
                    <div class="info-item">
                        <span class="info-label">Module</span>
                        <span class="info-value">Lecture {{ $moduleNumber }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Course</span>
                        <span class="info-value">{{ $course->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Type</span>
                        <span class="info-value">Video + Resources</span>
                    </div>
                    @if($resource->videos)
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value" style="color: #10b981;">
                            <i class="fas fa-circle" style="font-size: 0.5rem; margin-right: 0.375rem;"></i>
                            Available
                        </span>
                    </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="sidebar-section">
                    <div class="sidebar-title heading-font">Quick Actions</div>
                    <a href="{{ route('user.course.modules', $course->id) }}" 
                       style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 8px; text-decoration: none; color: #1f2937; margin-bottom: 0.5rem; transition: all 0.2s; font-weight: 500;">
                        <i class="fas fa-arrow-left" style="color: #0d7377;"></i>
                        <span style="font-size: 0.875rem;">Back to Course</span>
                    </a>
                    <a href="#" 
                       style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 8px; text-decoration: none; color: #1f2937; margin-bottom: 0.5rem; transition: all 0.2s; font-weight: 500;">
                        <i class="fas fa-bookmark" style="color: #0d7377;"></i>
                        <span style="font-size: 0.875rem;">Save for Later</span>
                    </a>
                    <a href="#" 
                       style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 8px; text-decoration: none; color: #1f2937; transition: all 0.2s; font-weight: 500;">
                        <i class="fas fa-share-alt" style="color: #0d7377;"></i>
                        <span style="font-size: 0.875rem;">Share</span>
                    </a>
                </div>

                <!-- Progress Note -->
                @if($resource->videos)
                <div class="sidebar-section" style="background: #f0fdfa; border-color: #ccfbf1;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; color: #0f766e;">
                        <i class="fas fa-info-circle"></i>
                        <div style="font-size: 0.875rem; line-height: 1.5; font-weight: 500;">
                            Your progress is automatically saved as you watch the video
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>
    <script>
        // Tab Switching Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and contents
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show corresponding content
                    const tabName = this.getAttribute('data-tab');
                    const targetContent = document.getElementById(tabName + '-content');
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });

        // Video Progress Tracking
        document.addEventListener('DOMContentLoaded', function () {
            const player = document.getElementById('mux-player');
            if (!player) return;

            let lastSavedProgress = 0;

            player.addEventListener('timeupdate', async function () {
                const progressPercent = (player.currentTime / player.duration) * 100;

                if (progressPercent - lastSavedProgress >= 10) {
                    lastSavedProgress = progressPercent;

                    try {
                        await fetch('{{ route("video.progress.save") }}', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                course_id: {{ $course->id }},
                                resource_id: {{ $resource->id }},
                                progress_percent: progressPercent
                            })
                        });
                    } catch (error) {
                        console.error('Failed to save progress:', error);
                    }
                }
            });

            player.addEventListener('ended', async function () {
                await fetch('{{ route("video.progress.save") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        course_id: {{ $course->id }},
                        resource_id: {{ $resource->id }},
                        progress_percent: 100
                    })
                });
            });
        });
    </script>
</body>
</html>