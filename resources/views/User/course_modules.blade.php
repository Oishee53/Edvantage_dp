<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - Lectures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .heading-font {
            font-family: 'Playfair Display', Georgia, serif;
        }

        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }

        body {
            background-color: #f9fafb;
            color: #333;
            letter-spacing: -0.01em;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Course Header */
        .course-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .course-title {
            font-size: 2rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .course-subtitle {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: -0.01em;
        }

        .course-meta {
            display: flex;
            gap: 2rem;
            margin-top: 1.25rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-weight: 500;
        }

        /* Tabs */
        .tabs-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            border-bottom: 2px solid #f3f4f6;
            margin-bottom: 2rem;
        }

        .tab {
            padding: 0.875rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all 0.2s;
            letter-spacing: -0.01em;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
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

        /* Module Card - NO NUMBERS */
        .module-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .module-card:hover {
            border-color: #0d7377;
            background: white;
            box-shadow: 0 4px 12px rgba(13, 115, 119, 0.12);
            transform: translateY(-2px);
        }

        .module-info h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
            letter-spacing: -0.01em;
        }

        .module-info p {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
        }

        .module-arrow {
            color: #9ca3af;
            transition: all 0.2s;
        }

        .module-card:hover .module-arrow {
            color: #0d7377;
            transform: translateX(4px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            background: #f3f4f6;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            color: #9ca3af;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.625rem;
            letter-spacing: -0.02em;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* Final Exam Card - NO STATS */
        .final-exam-card {
            background: #f9fafb;
            border-radius: 10px;
            padding: 1.75rem;
            border: 1px solid #e5e7eb;
        }

        .exam-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .exam-title-section {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .exam-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0d7377;
            border: 1px solid #e5e7eb;
        }

        .exam-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .exam-subtitle {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.2rem;
            font-weight: 500;
        }

        /* Button and Status in top right */
        .exam-actions-top {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            border: 1px solid;
            letter-spacing: -0.01em;
        }

        .status-not-started {
            background: #f9fafb;
            color: #6b7280;
            border-color: #e5e7eb;
        }

        .status-pending {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .status-passed {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .status-failed {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Small Button in Top Right */
        .btn-small {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            border: 2px solid;
            cursor: pointer;
            letter-spacing: -0.01em;
            white-space: nowrap;
        }

        .btn-small.btn-primary {
            background: #0d7377;
            color: white;
            border-color: #0d7377;
        }

        .btn-small.btn-primary:hover {
            background: #0a5c5f;
            border-color: #0a5c5f;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(13, 115, 119, 0.25);
        }

        .btn-small.btn-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            border-color: #e5e7eb;
        }

        .btn-small.btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Notice Box */
        .notice-box {
            background: white;
            border-left: 3px solid #0d7377;
            padding: 1rem;
            border-radius: 6px;
            margin-top: 1rem;
            border: 1px solid #e5e7eb;
            border-left: 3px solid #0d7377;
        }

        .notice-box p {
            font-size: 0.8rem;
            color: #4b5563;
            line-height: 1.5;
            font-weight: 500;
        }

        .notice-box strong {
            color: #0d7377;
            font-weight: 600;
        }

        /* Submitted Info */
        .submitted-info {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .submitted-info p {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
        }

        .submitted-info strong {
            color: #1f2937;
            font-size: 0.85rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1.5rem 1rem;
            }

            .course-header {
                padding: 1.5rem;
            }

            .course-title {
                font-size: 1.5rem;
            }

            .tabs-container {
                padding: 1rem;
            }

            .tabs {
                gap: 0.5rem;
            }

            .tab {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .course-meta {
                flex-direction: column;
                gap: 0.625rem;
            }

            .exam-header {
                flex-wrap: wrap;
            }

            .exam-actions-top {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body class="px-20 pt-5">
    @include('layouts.header')

    <div class="pt-24">
        <div class="container">
            <!-- Course Header -->
            <div class="course-header">
                <h1 class="course-title heading-font">{{ $course->title }}</h1>
                <p class="course-subtitle">Course Content</p>
                
                <div class="course-meta">
                    <div class="meta-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>{{ count($modules) }} Lectures</span>
                    </div>
                    <div class="meta-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Self-paced</span>
                    </div>
                </div>
            </div>

            <!-- Tabs Container -->
            <div class="tabs-container">
                <!-- Tabs -->
                <div class="tabs">
                    <button class="tab active" data-tab="lectures">
                        <i class="fas fa-book-open" style="margin-right: 0.5rem;"></i>
                        Lectures
                    </button>
                    <button class="tab" data-tab="final-exam">
                        <i class="fas fa-file-alt" style="margin-right: 0.5rem;"></i>
                        Final Exam
                    </button>
                      <button class="tab" data-tab="assignments">
        <i class="fas fa-tasks" style="margin-right: 0.5rem;"></i>
        Assignments
    </button>
                </div>

                <!-- Tab Content: Lectures -->
                <div class="tab-content active" id="lectures-content">
                    @foreach($course->liveClasses as $class)
    <div>
        <h4>{{ $class->title }}</h4>
        <p>{{ $class->schedule_datetime }}</p>
        <a href="{{ $class->meeting_link }}" target="_blank">Join Class</a>
    </div>
@endforeach

                    @forelse ($modules as $moduleNumber)
                        <a href="{{ route('inside.module', ['courseId' => $course->id, 'moduleNumber' => $moduleNumber]) }}" class="module-card">
                            <div class="module-info">
                                <h3>Lecture {{ $moduleNumber }}</h3>
                                <p>Click to access lecture content</p>
                            </div>
                            <svg class="module-arrow" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="heading-font">No Lectures Available</h3>
                            <p>This course doesn't have any lectures yet.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tab Content: Final Exam -->
                <div class="tab-content" id="final-exam-content">
                    @php
                        $finalExam = \App\Models\FinalExam::where('course_id', $course->id)
                            ->where('status', 'published')
                            ->first();
                        
                        $submission = null;
                        if ($finalExam && auth()->check()) {
                            $submission = \App\Models\FinalExamSubmission::where('final_exam_id', $finalExam->id)
                                ->where('user_id', auth()->id())
                                ->first();
                        }
                    @endphp

                    @if($finalExam)
                        <div class="final-exam-card">
                            <div class="exam-header">
                                <div class="exam-title-section">
                                    <div class="exam-icon">
                                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="exam-title heading-font">Final Exam</h3>
                                        <p class="exam-subtitle">{{ $finalExam->title }}</p>
                                    </div>
                                </div>

                                <div class="exam-actions-top">
                                    @if($submission)
                                        @if($submission->status === 'not_started' || $submission->status === 'in_progress')
                                            <span class="status-badge status-not-started">Not Completed</span>
                                        @elseif($submission->status === 'submitted')
                                            <span class="status-badge status-pending">Awaiting Grading</span>
                                        @elseif($submission->status === 'graded')
                                            @if($submission->percentage >= 70)
                                                <span class="status-badge status-passed">Passed · {{ number_format($submission->percentage, 0) }}%</span>
                                            @else
                                                <span class="status-badge status-failed">Failed · {{ number_format($submission->percentage, 0) }}%</span>
                                            @endif
                                        @endif
                                    @else
                                        <span class="status-badge status-not-started">Not Started</span>
                                    @endif

                                    @if(!$submission || $submission->status === 'not_started')
                                        <a href="{{ route('student.final-exam.show', $course->id) }}" class="btn-small btn-primary">
                                            Start Exam
                                        </a>
                                    @elseif($submission->status === 'in_progress')
                                        <a href="{{ route('student.final-exam.start', $finalExam->id) }}" class="btn-small btn-primary">
                                            Continue
                                        </a>
                                    @elseif($submission->status === 'submitted')
                                        <button class="btn-small btn-disabled" disabled>
                                            Pending
                                        </button>
                                    @elseif($submission->status === 'graded')
                                        <a href="{{ route('student.final-exam.result', $submission->id) }}" class="btn-small btn-primary">
                                            View Results
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if($submission && $submission->status === 'submitted')
                                <div class="submitted-info">
                                    <p>Submitted on <strong>{{ $submission->submitted_at->format('M d, Y - g:i A') }}</strong></p>
                                </div>
                            @endif

                            @if(!$submission || $submission->status === 'not_started')
                                <div class="notice-box">
                                    <p><strong>Note:</strong> Complete all lectures before attempting the final exam. Upload photos of handwritten answers. Passing score: 70%.</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="heading-font">No Final Exam Available</h3>
                            <p>The final exam has not been published yet.</p>
                        </div>
                    @endif
                </div>
                <!-- Tab Content: Assignments -->
<div class="tab-content" id="assignments-content">
    @php
        $assignments = \App\Models\Assignment::where('course_id', $course->id)->latest()->get();
    @endphp

    @if($assignments->count() > 0)
        @foreach($assignments as $assignment)
<a href="{{ route('assignment.show', $assignment->id) }}" class="block">
    <div class="final-exam-card" style="margin-bottom: 1rem;">
        <div class="exam-header">
            <div class="exam-title-section">
                <div class="exam-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div>
                    <h3 class="exam-title heading-font">{{ $assignment->title }}</h3>
                    <p class="exam-subtitle">{{ $assignment->description }}</p>
                </div>
            </div>
        </div>

        <div class="notice-box">
            <p><strong>Deadline:</strong> 
                {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y - g:i A') }}
            </p>
        </div>
    </div>
</a>
@endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <h3 class="heading-font">No Assignments Available</h3>
            <p>This course doesn't have any assignments yet.</p>
        </div>
    @endif
</div>
            </div>
        </div>
    </div>

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
    </script>
</body>
</html>