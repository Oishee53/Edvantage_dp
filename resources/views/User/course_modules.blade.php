<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - Lectures</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9fafb;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Course Header */
        .course-header {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .course-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 0.5rem;
        }

        .course-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .course-meta {
            display: flex;
            gap: 1.5rem;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Module Card */
        .module-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .module-card:hover {
            border-color: #0E1B33;
            box-shadow: 0 4px 8px rgba(14, 27, 51, 0.1);
            transform: translateY(-1px);
        }

        .module-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .module-number {
            width: 40px;
            height: 40px;
            background: #f3f4f6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #0E1B33;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .module-card:hover .module-number {
            background: #0E1B33;
            color: white;
        }

        .module-info h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #0E1B33;
            margin-bottom: 0.25rem;
        }

        .module-info p {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .module-arrow {
            color: #9ca3af;
            transition: all 0.2s;
        }

        .module-card:hover .module-arrow {
            color: #0E1B33;
            transform: translateX(4px);
        }

        /* Empty State */
        .empty-state {
            background: white;
            border-radius: 8px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .empty-icon {
            width: 48px;
            height: 48px;
            background: #f3f4f6;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: #9ca3af;
        }

        .empty-state h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #0E1B33;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Section Divider */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2.5rem 0 1.5rem 0;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider-text {
            color: #6b7280;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        /* Final Exam Card - COMPACT & ELEGANT */
        .final-exam-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 2px solid #e5e7eb;
        }

        .exam-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .exam-title-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .exam-icon {
            width: 36px;
            height: 36px;
            background: #f3f4f6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0E1B33;
        }

        .exam-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0E1B33;
            margin: 0;
        }

        .exam-subtitle {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.1rem;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
            border: 1px solid;
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

        /* Exam Stats - Compact Grid */
        .exam-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .stat-box {
            background: #f9fafb;
            padding: 0.625rem;
            border-radius: 6px;
            text-align: center;
            border: 1px solid #f3f4f6;
        }

        .stat-label {
            font-size: 0.65rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0E1B33;
        }

        /* Exam Actions - Compact */
        .exam-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn {
            flex: 1;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #0E1B33;
            color: white;
            border: 2px solid #0E1B33;
        }

        .btn-primary:hover {
            background: #1a2645;
            border-color: #1a2645;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(14, 27, 51, 0.15);
        }

        .btn-secondary {
            background: white;
            color: #0E1B33;
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            border-color: #0E1B33;
            background: #f9fafb;
        }

        .btn-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
            border: 2px solid #e5e7eb;
        }

        .btn-disabled:hover {
            transform: none;
            box-shadow: none;
        }

        /* Notice Box - Compact */
        .notice-box {
            background: #f9fafb;
            border-left: 3px solid #0E1B33;
            padding: 0.75rem;
            border-radius: 4px;
            margin-top: 0.75rem;
        }

        .notice-box p {
            font-size: 0.75rem;
            color: #4b5563;
            line-height: 1.4;
        }

        .notice-box strong {
            color: #0E1B33;
        }

        /* Submitted Info - Compact */
        .submitted-info {
            background: #f9fafb;
            padding: 0.75rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            text-align: center;
            border: 1px solid #f3f4f6;
        }

        .submitted-info p {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .submitted-info strong {
            color: #0E1B33;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .exam-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .exam-actions {
                flex-direction: column;
            }

            .course-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .exam-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Course Header -->
        <div class="course-header">
            <h1 class="course-title">{{ $course->title }}</h1>
            <p class="course-subtitle">Course Lectures</p>
            
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

        <!-- Modules List -->
        @forelse ($modules as $moduleNumber)
            <a href="{{ route('inside.module', ['courseId' => $course->id, 'moduleNumber' => $moduleNumber]) }}" class="module-card">
                <div class="module-left">
                    <div class="module-number">{{ $moduleNumber }}</div>
                    <div class="module-info">
                        <h3>Lecture {{ $moduleNumber }}</h3>
                        <p>Click to access lecture content</p>
                    </div>
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
                <h3>No Lectures Available</h3>
                <p>This course doesn't have any lectures yet.</p>
            </div>
        @endforelse

        <!-- Final Exam Section -->
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
            <div class="section-divider">
                <div class="divider-line"></div>
                <span class="divider-text">Final Assessment</span>
                <div class="divider-line"></div>
            </div>

            <div class="final-exam-card">
                <div class="exam-header">
                    <div class="exam-title-section">
                        <div class="exam-icon">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="exam-title">Final Exam</h3>
                            <p class="exam-subtitle">{{ $finalExam->title }}</p>
                        </div>
                    </div>

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
                </div>

                <div class="exam-stats">
                    <div class="stat-box">
                        <div class="stat-label">Questions</div>
                        <div class="stat-value">{{ $finalExam->questions()->count() }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Marks</div>
                        <div class="stat-value">{{ $finalExam->total_marks }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Duration</div>
                        <div class="stat-value">{{ $finalExam->duration_minutes }}m</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Passing</div>
                        <div class="stat-value">70%</div>
                    </div>
                </div>

                @if($submission && $submission->status === 'submitted')
                    <div class="submitted-info">
                        <p>Submitted on <strong>{{ $submission->submitted_at->format('M d, Y - g:i A') }}</strong></p>
                    </div>
                @endif

                <div class="exam-actions">
                    @if(!$submission || $submission->status === 'not_started')
                        <a href="{{ route('student.final-exam.show', $course->id) }}" class="btn btn-primary">
                            Start Final Exam
                        </a>
                    @elseif($submission->status === 'in_progress')
                        <a href="{{ route('student.final-exam.start', $finalExam->id) }}" class="btn btn-primary">
                            Continue Exam
                        </a>
                    @elseif($submission->status === 'submitted')
                        <button class="btn btn-disabled" disabled>
                            Awaiting Grading
                        </button>
                    @elseif($submission->status === 'graded')
                        <a href="{{ route('student.final-exam.result', $submission->id) }}" class="btn btn-primary">
                            View Results
                        </a>
                    @endif

                    <a href="{{ route('student.final-exam.show', $course->id) }}" class="btn btn-secondary">
                        Details
                    </a>
                </div>

                @if(!$submission || $submission->status === 'not_started')
                    <div class="notice-box">
                        <p><strong>Note:</strong> Complete all lectures before attempting the final exam. Upload photos of handwritten answers. Passing score: 70%.</p>
                    </div>
                @endif
            </div>
        @endif
    </div>
</body>
</html>