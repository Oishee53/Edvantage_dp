<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results - {{ $submission->exam->title }}</title>
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

        /* Header Card - COMPACT */
        .result-header {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .exam-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 0.375rem;
        }

        .course-name {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        /* Result Badge - COMPACT */
        .result-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 700;
            margin: 0.75rem 0;
            border: 2px solid;
        }

        .result-pass {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .result-fail {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Score Grid - COMPACT */
        .score-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin: 1rem 0;
        }

        .score-item {
            text-align: center;
            padding: 0.875rem;
            background: #f9fafb;
            border-radius: 6px;
            border: 1px solid #f3f4f6;
        }

        .score-label {
            font-size: 0.7rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 0.375rem;
        }

        .score-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0E1B33;
        }

        /* Submission Details - COMPACT */
        .submission-details {
            text-align: center;
            color: #6b7280;
            font-size: 0.75rem;
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
        }

        .submission-details p {
            margin: 0.125rem 0;
        }

        .submission-details strong {
            color: #0E1B33;
            font-weight: 600;
        }

        /* Overall Feedback Card - COMPACT */
        .feedback-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .feedback-title {
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 0.625rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .feedback-text {
            color: #4b5563;
            line-height: 1.5;
            font-size: 0.875rem;
        }

        /* Question Results Card - COMPACT */
        .questions-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .questions-header {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .question-result {
            background: #f9fafb;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-left: 3px solid #e5e7eb;
        }

        .question-result.full-marks {
            border-left-color: #22c55e;
            background: #f0fdf4;
        }

        .question-result.partial-marks {
            border-left-color: #f59e0b;
            background: #fffbeb;
        }

        .question-result.no-marks {
            border-left-color: #ef4444;
            background: #fef2f2;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.625rem;
        }

        .question-number {
            font-weight: 700;
            color: #0E1B33;
            font-size: 0.95rem;
        }

        .marks-badge {
            padding: 0.3rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            border: 1px solid;
        }

        .marks-full {
            background: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }

        .marks-partial {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        .marks-zero {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        .question-text {
            color: #4b5563;
            margin-bottom: 0.625rem;
            line-height: 1.4;
            font-size: 0.875rem;
        }

        .instructor-comment {
            background: white;
            padding: 0.75rem;
            border-radius: 6px;
            border-left: 3px solid #0E1B33;
            margin-top: 0.625rem;
        }

        .comment-label {
            font-size: 0.65rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.3rem;
            letter-spacing: 0.03em;
        }

        .comment-text {
            color: #1f2937;
            font-size: 0.8rem;
            line-height: 1.4;
        }

        /* Action Buttons - COMPACT */
        .actions-card {
            background: white;
            border-radius: 8px;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .button-group {
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
            display: block;
            text-align: center;
        }

        .btn-primary:hover {
            background: #1a2645;
            border-color: #1a2645;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(14, 27, 51, 0.15);
        }

        @media (max-width: 768px) {
            .score-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            body {
                padding: 1rem;
            }

            .container {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Result Header Card -->
        <div class="result-header">
            <h1 class="exam-title">{{ $submission->exam->title }}</h1>
            <p class="course-name">{{ $submission->exam->course->title }}</p>

            <!-- Pass/Fail Badge -->
            @if($submission->percentage >= 70)
                <div class="result-badge result-pass">
                    PASSED
                </div>
            @else
                <div class="result-badge result-fail">
                    FAILED
                </div>
            @endif

            <!-- Score Grid -->
            <div class="score-grid">
                <div class="score-item">
                    <div class="score-label">Your Score</div>
                    <div class="score-value">{{ $submission->total_score }}/{{ $submission->exam->total_marks }}</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Percentage</div>
                    <div class="score-value">{{ number_format($submission->percentage, 1) }}%</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Passing</div>
                    <div class="score-value">{{ $submission->exam->passing_marks }}</div>
                </div>
            </div>

            <!-- Submission Details -->
            <div class="submission-details">
                <p><strong>Submitted:</strong> {{ $submission->submitted_at->format('M d, Y - g:i A') }}</p>
                <p><strong>Graded:</strong> {{ $submission->graded_at->format('M d, Y - g:i A') }}</p>
            </div>
        </div>

        <!-- Overall Feedback -->
        @if($submission->instructor_feedback)
            <div class="feedback-card">
                <h3 class="feedback-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                    Instructor's Overall Feedback
                </h3>
                <p class="feedback-text">{{ $submission->instructor_feedback }}</p>
            </div>
        @endif

        <!-- Question-wise Results -->
        <div class="questions-card">
            <h2 class="questions-header">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Question-wise Results
            </h2>

            @foreach($submission->answers as $answer)
                @php
                    $percentage = $answer->question->marks > 0 ? ($answer->marks_obtained / $answer->question->marks) * 100 : 0;
                    $class = $percentage >= 100 ? 'full-marks' : ($percentage >= 50 ? 'partial-marks' : 'no-marks');
                    $badgeClass = $percentage >= 100 ? 'marks-full' : ($percentage >= 50 ? 'marks-partial' : 'marks-zero');
                @endphp

                <div class="question-result {{ $class }}">
                    <div class="question-header">
                        <span class="question-number">Question {{ $answer->question->question_number }}</span>
                        <span class="marks-badge {{ $badgeClass }}">
                            {{ $answer->marks_obtained }}/{{ $answer->question->marks }} marks
                        </span>
                    </div>

                    <p class="question-text">{{ $answer->question->question_text }}</p>

                    @if($answer->instructor_comment)
                        <div class="instructor-comment">
                            <div class="comment-label">Instructor's Comment</div>
                            <div class="comment-text">{{ $answer->instructor_comment }}</div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="actions-card">
            <a href="{{ route('user.course.modules', $submission->exam->course_id) }}" 
               class="btn btn-primary" style="display: block;">
                Back to Course
            </a>
        </div>
    </div>
</body>
</html>