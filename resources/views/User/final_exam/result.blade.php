<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results - {{ $submission->exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .result-card {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        .header {
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 3px solid #f3f4f6;
            margin-bottom: 2rem;
        }

        .exam-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .course-name {
            color: #6b7280;
            font-size: 1rem;
        }

        /* Result Badge */
        .result-badge {
            display: inline-block;
            padding: 1rem 2rem;
            border-radius: 3rem;
            font-size: 2rem;
            font-weight: 700;
            margin: 1.5rem 0;
        }

        .result-pass {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .result-fail {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        /* Score Grid */
        .score-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .score-item {
            text-align: center;
            padding: 1.5rem;
            background: #f9fafb;
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
        }

        .score-label {
            font-size: 0.875rem;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .score-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .score-percentage {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Question Results */
        .question-result {
            background: #f9fafb;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #e5e7eb;
        }

        .question-result.full-marks {
            border-left-color: #10b981;
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
            margin-bottom: 1rem;
        }

        .question-number {
            font-weight: 700;
            color: #1f2937;
            font-size: 1.1rem;
        }

        .marks-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .marks-full {
            background: #d1fae5;
            color: #065f46;
        }

        .marks-partial {
            background: #fef3c7;
            color: #92400e;
        }

        .marks-zero {
            background: #fee2e2;
            color: #991b1b;
        }

        .question-text {
            color: #4b5563;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .instructor-comment {
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 3px solid #3b82f6;
            margin-top: 0.75rem;
        }

        .comment-label {
            font-size: 0.75rem;
            color: #3b82f6;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .comment-text {
            color: #1f2937;
            font-size: 0.875rem;
        }

        /* Overall Feedback */
        .overall-feedback {
            background: linear-gradient(135deg, #e0e7ff 0%, #ddd6fe 100%);
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin: 2rem 0;
        }

        .feedback-title {
            font-weight: 700;
            color: #4c1d95;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .feedback-text {
            color: #5b21b6;
            line-height: 1.6;
        }

        /* Buttons */
        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }

        @media (max-width: 768px) {
            .score-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Main Result Card -->
        <div class="result-card">
            <div class="header">
                <h1 class="exam-title">{{ $submission->exam->title }}</h1>
                <p class="course-name">{{ $submission->exam->course->title }}</p>

                <!-- Pass/Fail Badge -->
                @if($submission->percentage >= 70)
                    <div class="result-badge result-pass">
                        ✅ PASSED
                    </div>
                @else
                    <div class="result-badge result-fail">
                        ❌ FAILED
                    </div>
                @endif
            </div>

            <!-- Score Grid -->
            <div class="score-grid">
                <div class="score-item">
                    <div class="score-label">Your Score</div>
                    <div class="score-value">{{ $submission->total_score }}/{{ $submission->exam->total_marks }}</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Percentage</div>
                    <div class="score-value score-percentage">{{ number_format($submission->percentage, 1) }}%</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Passing Marks</div>
                    <div class="score-value">{{ $submission->exam->passing_marks }}</div>
                </div>
            </div>

            <!-- Submission Details -->
            <div style="text-align: center; color: #6b7280; font-size: 0.875rem; margin: 1rem 0;">
                <p><strong>Submitted:</strong> {{ $submission->submitted_at->format('M d, Y g:i A') }}</p>
                <p><strong>Graded:</strong> {{ $submission->graded_at->format('M d, Y g:i A') }}</p>
            </div>
        </div>

        <!-- Overall Feedback -->
        @if($submission->instructor_feedback)
            <div class="result-card">
                <div class="overall-feedback">
                    <div class="feedback-title">📝 Instructor's Overall Feedback</div>
                    <div class="feedback-text">{{ $submission->instructor_feedback }}</div>
                </div>
            </div>
        @endif

        <!-- Question-wise Results -->
        <div class="result-card">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">
                📊 Question-wise Results
            </h2>

            @foreach($submission->answers as $answer)
                @php
                    $percentage = ($answer->marks_obtained / $answer->question->marks) * 100;
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
        <div class="result-card">
            <div class="button-group">
                @if($submission->percentage >= 70)
                    <a href="{{ route('certificate.generate', ['userId' => auth()->id(), 'courseId' => $submission->exam->course_id]) }}" 
                       class="btn btn-primary">
                        🏆 Download Certificate
                    </a>
                @endif
                <a href="{{ route('user.course.modules', $submission->exam->course_id) }}" 
                   class="btn btn-secondary">
                    ← Back to Course
                </a>
            </div>
        </div>
    </div>
</body>
</html>