<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }} - Exam Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #f1f3f5;
            --text-primary: #000000;
            --text-secondary: #495057;
            --text-tertiary: #6c757d;
            --border-color: #dee2e6;
            --border-light: #e9ecef;
            --accent: #212529;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .breadcrumb {
            font-size: 0.875rem;
            color: var(--text-tertiary);
            margin-top: 0.25rem;
        }

        .breadcrumb a {
            color: var(--text-tertiary);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--text-primary);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
            white-space: nowrap;
        }

        .btn:hover {
            background-color: var(--bg-tertiary);
            border-color: var(--accent);
        }

        .btn-primary {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .btn-primary:hover {
            background-color: #000000;
        }

        .pending-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 0.375rem;
            background-color: #dc3545;
            color: white;
            border-radius: 10px;
            font-size: 0.6875rem;
            font-weight: 700;
        }

        /* Main Grid Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        /* Cards */
        .card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.25rem;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 0.9375rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* Exam Info */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-light);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 0.875rem;
            color: var(--text-tertiary);
        }

        .info-value {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-draft {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-published {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .stat-box {
            padding: 1rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-light);
            border-radius: 4px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
            margin-top: 0.25rem;
        }

        .stat-detail {
            font-size: 0.75rem;
            color: #dc3545;
            font-weight: 600;
            margin-top: 0.25rem;
        }

        /* Description */
        .description-box {
            padding: 1rem;
            background: var(--bg-tertiary);
            border-left: 3px solid var(--accent);
            border-radius: 3px;
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Questions */
        .question-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .question-item {
            padding: 1rem;
            border: 1px solid var(--border-light);
            border-radius: 4px;
            transition: border-color 0.15s ease;
        }

        .question-item:hover {
            border-color: var(--border-color);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .question-number {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .marks-badge {
            padding: 0.1875rem 0.625rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .question-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        .criteria-box {
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border-radius: 3px;
            margin-top: 0.75rem;
        }

        .criteria-label {
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-tertiary);
            letter-spacing: 0.025em;
            margin-bottom: 0.375rem;
        }

        .criteria-text {
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        /* Sidebar Actions */
        .action-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        @media (max-width: 968px) {
            .main-grid {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-wrap: wrap;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .container {
                padding: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .action-bar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $exam->title }}</h1>
                <div class="breadcrumb">
                    <a href="/instructor/manage_courses">Manage Courses</a> / 
                    <a href="/instructor/manage_courses">{{ $exam->course->title }}</a> / 
                    <span>Exam Details</span>
                </div>
            </div>
            <div class="action-bar">
                @if($totalSubmissions == 0)
                    <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" class="btn">
                        Edit Exam
                    </a>
                @endif
                <a href="/instructor/manage_courses" class="btn">
                    Back
                </a>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="main-grid">
            <!-- Left Column: Questions -->
            <div>
                <div class="card">
                    <div class="card-header">Exam Questions ({{ $exam->questions()->count() }})</div>
                    <div class="card-body">
                        <div class="question-list">
                            @foreach($exam->questions as $question)
                                <div class="question-item">
                                    <div class="question-header">
                                        <span class="question-number">Question {{ $question->question_number }}</span>
                                        <span class="marks-badge">{{ $question->marks }} marks</span>
                                    </div>
                                    <div class="question-text">{{ $question->question_text }}</div>
                                    @if($question->marking_criteria)
                                        <div class="criteria-box">
                                            <div class="criteria-label">Marking Criteria</div>
                                            <div class="criteria-text">{{ $question->marking_criteria }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Info & Actions -->
            <div>
                <!-- Status & Info -->
                <div class="card">
                    <div class="card-header">Exam Information</div>
                    <div class="card-body">
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            @if($exam->status === 'draft')
                                <span class="status-badge status-draft">Draft</span>
                            @else
                                <span class="status-badge status-published">Published</span>
                            @endif
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Marks</span>
                            <span class="info-value">{{ $exam->total_marks }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Passing Marks</span>
                            <span class="info-value">{{ $exam->passing_marks }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Duration</span>
                            <span class="info-value">{{ $exam->duration_minutes }} minutes</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Questions</span>
                            <span class="info-value">{{ $exam->questions()->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($exam->description)
                    <div class="card" style="margin-top: 1rem;">
                        <div class="card-header">Description</div>
                        <div class="card-body">
                            <div class="description-box">
                                {{ $exam->description }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Submissions Stats -->
                <div class="card" style="margin-top: 1rem;">
                    <div class="card-header">Submissions</div>
                    <div class="card-body">
                        <div class="stats-grid">
                            <div class="stat-box">
                                <div class="stat-value">{{ $totalSubmissions }}</div>
                                <div class="stat-label">Total</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">{{ $pendingGrading }}</div>
                                <div class="stat-label">Pending</div>
                                @if($pendingGrading > 0)
                                    <div class="stat-detail">Needs grading</div>
                                @endif
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">{{ $graded }}</div>
                                <div class="stat-label">Graded</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-value">{{ $passed }}</div>
                                <div class="stat-label">Passed</div>
                                @if($graded > 0)
                                    <div class="stat-detail">{{ round(($passed / $graded) * 100) }}% pass rate</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card" style="margin-top: 1rem;">
                    <div class="card-header">Actions</div>
                    <div class="card-body">
                        <div class="action-list">
                            <a href="{{ route('instructor.final-exams.submissions', $exam->id) }}" class="btn btn-primary">
                                View All Submissions
                                @if($pendingGrading > 0)
                                    <span class="pending-badge">{{ $pendingGrading }}</span>
                                @endif
                            </a>
                            @if($totalSubmissions == 0)
                                <a href="{{ route('instructor.final-exams.edit', $exam->id) }}" class="btn">
                                    Edit Exam
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>