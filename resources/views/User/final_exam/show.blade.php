<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Exam - {{ $exam->title }}</title>
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
            padding: 1.5rem;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #0E1B33;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .exam-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
        }

        h1 {
            color: #0E1B33;
            margin-bottom: 0.375rem;
            font-size: 1.5rem;
        }

        .course-name {
            color: #6b7280;
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
        }

        .status-section {
            margin-bottom: 1.25rem;
            font-size: 0.875rem;
        }

        .status-section strong {
            color: #0E1B33;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            border: 1px solid;
        }

        .status-not-started {
            background: #f0f9ff;
            color: #0369a1;
            border-color: #bae6fd;
        }

        .status-in-progress {
            background: #fffbeb;
            color: #92400e;
            border-color: #fde68a;
        }

        .status-submitted {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }

        .status-graded {
            background: #f5f3ff;
            color: #6b21a8;
            border-color: #e9d5ff;
        }

        .exam-details {
            background: #f9fafb;
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            border: 1px solid #f3f4f6;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .detail-item {
            text-align: center;
        }

        .detail-label {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .detail-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0E1B33;
        }

        .description {
            background: #f9fafb;
            border-left: 3px solid #0E1B33;
            padding: 1rem;
            margin-bottom: 1.25rem;
            border-radius: 4px;
        }

        .description h3 {
            color: #0E1B33;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .description p {
            color: #4b5563;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .guidelines-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        .guidelines-box h3 {
            color: #0E1B33;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .guidelines-box ul {
            list-style-position: inside;
            color: #4b5563;
            font-size: 0.8rem;
        }

        .guidelines-box li {
            margin-bottom: 0.5rem;
            padding-left: 0.25rem;
        }

        .guidelines-box strong {
            color: #991b1b;
        }

        .instructions {
            margin-bottom: 1.25rem;
        }

        .instructions h3 {
            color: #0E1B33;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .instructions ul {
            list-style-position: inside;
            color: #4b5563;
            font-size: 0.8rem;
        }

        .instructions li {
            margin-bottom: 0.5rem;
            padding-left: 0.25rem;
        }

        .info-message {
            background: #f0fdf4;
            border-left: 3px solid #22c55e;
            padding: 0.875rem;
            margin-bottom: 1.25rem;
            border-radius: 4px;
            color: #166534;
            font-size: 0.875rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.25rem;
        }

        .btn {
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s;
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

        .submitted-info {
            text-align: center;
            color: #6b7280;
            margin-top: 1.25rem;
            font-size: 0.8rem;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .exam-card {
                padding: 1.25rem;
            }

            .detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('user.course.modules', $exam->course_id) }}" class="back-link">
            ← Back to Course
        </a>

        <div class="exam-card">
            <h1>{{ $exam->title }}</h1>
            <p class="course-name">{{ $exam->course->title }}</p>

            <!-- Status Section -->
            <div class="status-section">
                <strong>Status:</strong>
                @if($submission->status === 'not_started')
                    <span class="status-badge status-not-started">Not Started</span>
                @elseif($submission->status === 'in_progress')
                    <span class="status-badge status-in-progress">In Progress</span>
                @elseif($submission->status === 'submitted')
                    <span class="status-badge status-submitted">Submitted</span>
                @elseif($submission->status === 'graded')
                    <span class="status-badge status-graded">Graded</span>
                @endif
            </div>

            @if($submission->status === 'not_started' || $submission->status === 'in_progress')
                <!-- Exam Details -->
                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Questions</div>
                            <div class="detail-value">{{ $exam->questions()->count() }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Marks</div>
                            <div class="detail-value">{{ $exam->total_marks }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Passing</div>
                            <div class="detail-value">{{ $exam->passing_marks }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value">{{ $exam->duration_minutes }}m</div>
                        </div>
                    </div>
                </div>

                @if($exam->description)
                    <div class="description">
                        <h3>Description</h3>
                        <p>{{ $exam->description }}</p>
                    </div>
                @endif

                <!-- Important Guidelines -->
                <div class="guidelines-box">
                    <h3>Important Guidelines</h3>
                    <ul>
                        <li><strong>Timer starts immediately</strong> when you click "Start Exam"</li>
                        <li>Upload <strong>images of handwritten answers</strong> for each question</li>
                        <li>Upload <strong>1-5 clear photos</strong> per question (max 5MB each)</li>
                        <li><strong>Cannot edit</strong> after submitting the exam</li>
                        <li>Exam will <strong>auto-submit</strong> when time expires</li>
                        <li>Grading within <strong>7 days</strong></li>
                        <li>Need <strong>70% or more</strong> to pass</li>
                    </ul>
                </div>

                <!-- Instructions -->
                <div class="instructions">
                    <h3>How to Take the Exam:</h3>
                    <ul>
                        <li>Write your answers on paper clearly</li>
                        <li>Take photos of each answer (use good lighting)</li>
                        <li>Upload the photos for each question</li>
                        <li>Review all questions before submitting</li>
                        <li>Submit the exam (cannot change after submission)</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    @if($submission->status === 'not_started')
                        <form action="{{ route('student.final-exam.start', $exam->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                Start Exam
                            </button>
                        </form>
                    @else
                        <a href="{{ route('student.final-exam.start', $exam->id) }}" class="btn btn-primary" style="flex: 1;">
                            Continue Exam
                        </a>
                    @endif
                    
                    <a href="{{ route('user.course.modules', $exam->course_id) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            @elseif($submission->status === 'submitted')
                <!-- Submitted Status -->
                <div class="info-message">
                    Your exam has been submitted successfully!
                </div>

                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Submitted</div>
                            <div class="detail-value" style="font-size: 0.875rem;">
                                {{ $submission->submitted_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Time</div>
                            <div class="detail-value" style="font-size: 0.875rem;">
                                {{ $submission->submitted_at->format('g:i A') }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" style="font-size: 0.875rem;">
                                Pending
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Grading</div>
                            <div class="detail-value" style="font-size: 0.875rem;">
                                @php
                                    $deadline = $submission->getGradingDeadline();
                                    $daysRemaining = $submission->getDaysRemainingForGrading();
                                @endphp
                                {{ $daysRemaining }}d
                            </div>
                        </div>
                    </div>
                </div>

                <p class="submitted-info">
                    Your instructor will grade your exam within 7 days.<br>
                    You will be notified when grading is complete.
                </p>

            @elseif($submission->status === 'graded')
                <!-- Graded Status -->
                <div class="info-message" style="{{ $submission->isPassed() ? '' : 'background: #fef2f2; border-color: #fca5a5; color: #991b1b;' }}">
                    @if($submission->isPassed())
                        Congratulations! You have passed the exam!
                    @else
                        Your exam has been graded. You did not meet the passing criteria.
                    @endif
                </div>

                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Score</div>
                            <div class="detail-value" style="color: {{ $submission->isPassed() ? '#22c55e' : '#dc2626' }};">
                                {{ $submission->total_score }}/{{ $exam->total_marks }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Percentage</div>
                            <div class="detail-value" style="color: {{ $submission->isPassed() ? '#22c55e' : '#dc2626' }};">
                                {{ $submission->percentage }}%
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Result</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                @if($submission->isPassed())
                                    <span style="color: #22c55e;">Passed</span>
                                @else
                                    <span style="color: #dc2626;">Failed</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Graded</div>
                            <div class="detail-value" style="font-size: 0.875rem;">
                                {{ $submission->graded_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('student.final-exam.result', $submission->id) }}" class="btn btn-primary" style="flex: 1;">
                        View Detailed Results
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>