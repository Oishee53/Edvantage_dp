<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Submissions - {{ $exam->title }}</title>
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

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.875rem 1rem;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .stat-label {
            font-size: 0.6875rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
            margin-top: 0.25rem;
        }

        /* Table Card */
        .table-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            overflow: hidden;
        }

        .table-header {
            padding: 1rem 1.25rem;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            font-size: 0.9375rem;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
        }

        th {
            padding: 0.875rem 1.25rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        tbody tr {
            border-bottom: 1px solid var(--border-light);
            transition: background-color 0.15s ease;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background-color: var(--bg-secondary);
        }

        td {
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
        }

        .student-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.125rem;
        }

        .student-email {
            font-size: 0.8125rem;
            color: var(--text-tertiary);
        }

        .date-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .status-graded {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .status-other {
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        /* Score Display */
        .score-value {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .score-percentage {
            font-size: 0.8125rem;
            margin-top: 0.125rem;
        }

        .score-pass {
            color: #155724;
        }

        .score-fail {
            color: #dc3545;
        }

        .score-na {
            color: var(--text-tertiary);
        }

        /* Buttons */
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

        .btn-sm {
            padding: 0.375rem 0.875rem;
            font-size: 0.8125rem;
        }

        .empty-state {
            padding: 3rem 2rem;
            text-align: center;
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        .back-button {
            margin-top: 1.5rem;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .table-card {
                overflow-x: auto;
            }

            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Exam Submissions</h1>
                <div class="breadcrumb">
                    <a href="/instructor/manage_courses">Manage Courses</a> / 
                    <a href="/instructor/manage_courses">{{ $exam->course->title }}</a> / 
                    <span>{{ $exam->title }}</span>
                </div>
            </div>
            <div>
                <a href="/instructor/manage_courses" class="btn">Back</a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ $submissions->count() }}</div>
                <div class="stat-label">Total Submissions</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $submissions->where('status', 'submitted')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ $submissions->where('status', 'graded')->count() }}</div>
                <div class="stat-label">Graded</div>
            </div>
            <div class="stat-card">
                @php
                    $graded = $submissions->where('status', 'graded')->count();
                    $passed = $submissions->where('status', 'graded')->where('percentage', '>=', 70)->count();
                    $passRate = $graded > 0 ? round(($passed / $graded) * 100) : 0;
                @endphp
                <div class="stat-value">{{ $passRate }}%</div>
                <div class="stat-label">Pass Rate</div>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="table-card">
            <div class="table-header">All Submissions ({{ $submissions->count() }})</div>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>
                                <div class="student-name">{{ $submission->user->name }}</div>
                                <div class="student-email">{{ $submission->user->email }}</div>
                            </td>
                            <td>
                                <span class="date-text">
                                    {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y g:i A') : 'Not submitted' }}
                                </span>
                            </td>
                            <td>
                                @if($submission->status === 'submitted')
                                    <span class="status-badge status-pending">Pending</span>
                                @elseif($submission->status === 'graded')
                                    <span class="status-badge status-graded">Graded</span>
                                @else
                                    <span class="status-badge status-other">{{ ucfirst($submission->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($submission->status === 'graded')
                                    <div class="score-value">{{ $submission->total_score }}/{{ $exam->total_marks }}</div>
                                    <div class="score-percentage {{ $submission->percentage >= 70 ? 'score-pass' : 'score-fail' }}">
                                        {{ number_format($submission->percentage, 1) }}%
                                    </div>
                                @else
                                    <span class="score-na">Not graded</span>
                                @endif
                            </td>
                            <td>
                                @if($submission->status === 'submitted')
                                    <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" class="btn btn-sm btn-primary">
                                        Grade Now
                                    </a>
                                @elseif($submission->status === 'graded')
                                    <a href="{{ route('instructor.final-exams.grade-submission', $submission->id) }}" class="btn btn-sm">
                                        View Grading
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">No submissions yet</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>