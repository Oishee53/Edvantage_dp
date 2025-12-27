<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Exam - {{ $exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9fafb;
            padding: 2rem;
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
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .exam-card {
            background: white;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h1 {
            color: #0E1B33;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .course-name {
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .exam-details {
            background: #f3f4f6;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .detail-item {
            text-align: center;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0E1B33;
        }

        .description {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 4px;
        }

        .description h3 {
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .instructions {
            margin-bottom: 2rem;
        }

        .instructions h3 {
            color: #0E1B33;
            margin-bottom: 1rem;
        }

        .instructions ul {
            list-style-position: inside;
            color: #374151;
        }

        .instructions li {
            margin-bottom: 0.75rem;
            padding-left: 0.5rem;
        }

        .status-section {
            margin-bottom: 2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1rem;
        }

        .status-not-started {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-in-progress {
            background: #fef3c7;
            color: #92400e;
        }

        .status-submitted {
            background: #d1fae5;
            color: #065f46;
        }

        .status-graded {
            background: #e0e7ff;
            color: #3730a3;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #059669;
            color: white;
        }

        .btn-primary:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .warning-box {
            background: #fef2f2;
            border: 2px solid #fca5a5;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .warning-box h3 {
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .warning-box ul {
            color: #991b1b;
            list-style-position: inside;
        }

        .info-message {
            background: #d1fae5;
            border-left: 4px solid #10b981;
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 4px;
            color: #065f46;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .exam-card {
                padding: 1.5rem;
            }

            .detail-grid {
                grid-template-columns: 1fr;
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
                <strong>Status: </strong>
                @if($submission->status === 'not_started')
                    <span class="status-badge status-not-started">Not Started</span>
                @elseif($submission->status === 'in_progress')
                    <span class="status-badge status-in-progress">In Progress</span>
                @elseif($submission->status === 'submitted')
                    <span class="status-badge status-submitted">Submitted - Waiting for Grading</span>
                @elseif($submission->status === 'graded')
                    <span class="status-badge status-graded">Graded</span>
                @endif
            </div>

            @if($submission->status === 'not_started' || $submission->status === 'in_progress')
                <!-- Exam Details -->
                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Total Questions</div>
                            <div class="detail-value">{{ $exam->questions()->count() }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total Marks</div>
                            <div class="detail-value">{{ $exam->total_marks }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Passing Marks</div>
                            <div class="detail-value">{{ $exam->passing_marks }} (70%)</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value">{{ $exam->duration_minutes }} min</div>
                        </div>
                    </div>
                </div>

                @if($exam->description)
                    <div class="description">
                        <h3>Description</h3>
                        <p>{{ $exam->description }}</p>
                    </div>
                @endif

                <!-- Important Warning -->
                <div class="warning-box">
                    <h3>⚠️ Important Guidelines</h3>
                    <ul>
                        <li><strong>Timer starts immediately</strong> when you click "Start Exam"</li>
                        <li>You must <strong>upload images of your handwritten answers</strong> for each question</li>
                        <li>Upload <strong>1-5 clear photos</strong> per question (max 5MB each)</li>
                        <li><strong>You cannot edit answers</strong> after submitting the exam</li>
                        <li>Exam will <strong>auto-submit</strong> when time expires</li>
                        <li>Your answers will be <strong>graded within 7 days</strong></li>
                        <li>You need <strong>70% or more</strong> to pass</li>
                    </ul>
                </div>

                <!-- Instructions -->
                <div class="instructions">
                    <h3>How to Take the Exam:</h3>
                    <ul>
                        <li>📝 <strong>Write</strong> your answers on paper clearly</li>
                        <li>📸 <strong>Take photos</strong> of each answer (use good lighting)</li>
                        <li>📤 <strong>Upload</strong> the photos for each question</li>
                        <li>✅ <strong>Review</strong> all questions before submitting</li>
                        <li>🚀 <strong>Submit</strong> the exam (cannot change after submission)</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    @if($submission->status === 'not_started')
                        <form action="{{ route('student.final-exam.start', $exam->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="width: 100%;">
                                🚀 Start Exam
                            </button>
                        </form>
                    @else
                        <a href="{{ route('student.final-exam.start', $exam->id) }}" class="btn btn-primary" style="flex: 1;">
                            ⏯️ Continue Exam
                        </a>
                    @endif
                    
                    <a href="{{ route('user.course.modules', $exam->course_id) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            @elseif($submission->status === 'submitted')
                <!-- Submitted Status -->
                <div class="info-message">
                    ✅ Your exam has been submitted successfully!
                </div>

                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Submitted At</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                {{ $submission->submitted_at->format('M d, Y - g:i A') }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Grading Status</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                ⏳ Pending
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Expected Grading</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                @php
                                    $deadline = $submission->getGradingDeadline();
                                    $daysRemaining = $submission->getDaysRemainingForGrading();
                                @endphp
                                {{ $daysRemaining }} days
                            </div>
                        </div>
                    </div>
                </div>

                <p style="text-align: center; color: #6b7280; margin-top: 2rem;">
                    Your instructor will grade your exam within 7 days.<br>
                    You will be notified when grading is complete.
                </p>

            @elseif($submission->status === 'graded')
                <!-- Graded Status -->
                <div class="info-message" style="{{ $submission->isPassed() ? '' : 'background: #fee2e2; border-color: #fca5a5; color: #991b1b;' }}">
                    @if($submission->isPassed())
                        🎉 Congratulations! You have passed the exam!
                    @else
                        Your exam has been graded. You did not meet the passing criteria.
                    @endif
                </div>

                <div class="exam-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">Your Score</div>
                            <div class="detail-value" style="color: {{ $submission->isPassed() ? '#059669' : '#dc2626' }};">
                                {{ $submission->total_score }} / {{ $exam->total_marks }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Percentage</div>
                            <div class="detail-value" style="color: {{ $submission->isPassed() ? '#059669' : '#dc2626' }};">
                                {{ $submission->percentage }}%
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Result</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                @if($submission->isPassed())
                                    <span style="color: #059669;">✅ Passed</span>
                                @else
                                    <span style="color: #dc2626;">❌ Failed</span>
                                @endif
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Graded At</div>
                            <div class="detail-value" style="font-size: 1rem;">
                                {{ $submission->graded_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('student.final-exam.result', $submission->id) }}" class="btn btn-primary" style="flex: 1;">
                        📊 View Detailed Results
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>