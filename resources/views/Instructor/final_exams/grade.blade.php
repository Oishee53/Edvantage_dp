<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Exam - {{ $submission->exam->title }}</title>
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
            padding: 1.5rem;
        }

        /* Header */
        .page-header {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            font-size: 0.875rem;
            color: var(--text-tertiary);
        }

        .student-info {
            text-align: right;
        }

        .student-label {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .student-name {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 0.125rem;
        }

        .student-email {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            margin-top: 0.125rem;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .info-box {
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-light);
            border-radius: 4px;
        }

        .info-label {
            font-size: 0.6875rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .info-subtext {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.125rem;
        }

        /* Question Card */
        .question-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 1rem;
            overflow: hidden;
        }

        .question-header {
            padding: 1rem;
            background: var(--bg-tertiary);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: start;
        }

        .question-title {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .question-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .marks-badge {
            padding: 0.375rem 0.875rem;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.8125rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .criteria-box {
            margin-top: 0.75rem;
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border-left: 3px solid var(--accent);
            border-radius: 3px;
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

        .question-body {
            padding: 1rem;
        }

        .section-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        /* Images Grid */
        .images-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .image-container {
            position: relative;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.15s ease;
        }

        .image-container:hover {
            border-color: var(--accent);
        }

        .image-container img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .image-overlay {
            position: absolute;
            top: 0.375rem;
            right: 0.375rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-size: 0.6875rem;
        }

        .no-answer {
            padding: 1rem;
            background: var(--bg-tertiary);
            border: 1px dashed var(--border-color);
            border-radius: 4px;
            text-align: center;
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        /* Grading Section */
        .grading-section {
            padding: 1rem;
            background: var(--bg-tertiary);
            border-top: 1px solid var(--border-color);
        }

        .grading-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.375rem;
        }

        .form-input {
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.15s ease;
            background: var(--bg-primary);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        textarea.form-input {
            resize: vertical;
            font-weight: 400;
            min-height: 80px;
        }

        /* Summary Card */
        .summary-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .summary-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .score-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .score-item {
            text-align: center;
        }

        .score-label {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .score-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-top: 0.25rem;
        }

        .result-badge {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-pass {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-fail {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .badge-pending {
            background-color: var(--bg-tertiary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
            background: var(--bg-primary);
            color: var(--text-primary);
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

        .btn-group {
            display: flex;
            gap: 0.75rem;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .modal.active {
            display: flex;
        }

        .modal img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 4px;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: white;
            color: black;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1024px) {
            .images-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header-top {
                flex-direction: column;
                gap: 1rem;
            }

            .student-info {
                text-align: left;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .images-grid {
                grid-template-columns: 1fr;
            }

            .grading-grid {
                grid-template-columns: 1fr;
            }

            .score-display {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-top">
                <div>
                    <h1 class="page-title">{{ $submission->exam->title }}</h1>
                    <p class="page-subtitle">Grading Submission</p>
                </div>
                <div class="student-info">
                    <div class="student-label">Student</div>
                    <div class="student-name">{{ $submission->user->name }}</div>
                    <div class="student-email">{{ $submission->user->email }}</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-label">Questions</div>
                    <div class="info-value">{{ $submission->exam->questions()->count() }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Total Marks</div>
                    <div class="info-value">{{ $submission->exam->total_marks }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Submitted At</div>
                    <div class="info-value" style="font-size: 0.875rem;">{{ $submission->submitted_at->format('M d, Y') }}</div>
                    <div class="info-subtext">{{ $submission->submitted_at->format('g:i A') }}</div>
                </div>
                <div class="info-box">
                    <div class="info-label">Status</div>
                    @if($submission->status === 'graded')
                        <div class="info-value" style="font-size: 0.875rem; color: #155724;">Graded</div>
                    @else
                        <div class="info-value" style="font-size: 0.875rem; color: #856404;">Pending</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grading Form -->
        <form action="{{ route('instructor.final-exams.save-grades', $submission->id) }}" method="POST" id="grading-form">
            @csrf

            <!-- Questions -->
            @foreach($submission->answers as $answer)
                <div class="question-card">
                    <div class="question-header">
                        <div style="flex: 1;">
                            <h3 class="question-title">Question {{ $answer->question->question_number }}</h3>
                            <p class="question-text">{{ $answer->question->question_text }}</p>
                            
                            @if($answer->question->marking_criteria)
                                <div class="criteria-box">
                                    <div class="criteria-label">Marking Criteria</div>
                                    <div class="criteria-text">{{ $answer->question->marking_criteria }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="marks-badge">{{ $answer->question->marks }} marks</div>
                    </div>

                    <div class="question-body">
                        <div class="section-label">Student's Answer</div>
                        
                        @php
                            $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
                        @endphp

                        @if(count($images) > 0)
                            <div class="images-grid">
                                @foreach($images as $imageUrl)
                                    <div class="image-container" onclick="enlargeImage('{{ $imageUrl }}')">
                                        <img src="{{ $imageUrl }}" alt="Answer Image">
                                        <div class="image-overlay">Click to enlarge</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="no-answer">No images uploaded</div>
                        @endif
                    </div>

                    <div class="grading-section">
                        <div class="grading-grid">
                            <div class="form-group">
                                <label class="form-label">Marks (out of {{ $answer->question->marks }})</label>
                                <input type="number" 
                                       name="marks[{{ $answer->id }}]" 
                                       min="0" 
                                       max="{{ $answer->question->marks }}" 
                                       step="0.5"
                                       class="form-input"
                                       placeholder="0"
                                       value="{{ $answer->marks_obtained ?? '' }}"
                                       required
                                       onchange="calculateTotal()">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Comment/Feedback (optional)</label>
                                <textarea name="comments[{{ $answer->id }}]" 
                                          class="form-input"
                                          placeholder="Write your feedback...">{{ $answer->instructor_comment ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($submission->webcam_playback_id)
    <h3 class="mt-4 font-bold">Webcam Recording</h3>
    <video controls width="600">
        <source src="https://stream.mux.com/{{ $submission->webcam_playback_id }}.m3u8" type="application/x-mpegURL">
    </video>
@endif


            <!-- Summary -->
            <div class="summary-card">
                <h3 class="summary-title">Overall Feedback & Summary</h3>
                
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label">Overall Feedback</label>
                    <textarea name="overall_feedback" 
                              class="form-input"
                              style="min-height: 100px;"
                              placeholder="Write overall feedback for the student...">{{ $submission->instructor_feedback ?? '' }}</textarea>
                </div>

                <div class="score-display">
                    <div class="score-item">
                        <div class="score-label">Total Score</div>
                        <div class="score-value" id="total-score">0</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Out of</div>
                        <div class="score-value">{{ $submission->exam->total_marks }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Percentage</div>
                        <div class="score-value" id="percentage">0%</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Result</div>
                        <div id="result-badge" style="margin-top: 0.25rem;">
                            <span class="result-badge badge-pending">Not Graded</span>
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">
                        @if($submission->status === 'graded')
                            Update Grading & Notify Student
                        @else
                            Submit Grading & Notify Student
                        @endif
                    </button>
                    <a href="{{ route('instructor.final-exams.submissions', $submission->exam->id) }}" class="btn">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="modal" onclick="closeModal()">
        <button class="modal-close" onclick="closeModal()">×</button>
        <img id="modal-image" src="" onclick="event.stopPropagation()">
    </div>

    <script>
        function calculateTotal() {
            let total = 0;
            const totalMarks = {{ $submission->exam->total_marks }};
            
            document.querySelectorAll('input[name^="marks"]').forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            document.getElementById('total-score').textContent = total.toFixed(1);
            
            const percentage = (total / totalMarks * 100).toFixed(1);
            document.getElementById('percentage').textContent = percentage + '%';

            const resultBadge = document.getElementById('result-badge');
            if (percentage >= 70) {
                resultBadge.innerHTML = '<span class="result-badge badge-pass">Pass</span>';
            } else if (percentage > 0) {
                resultBadge.innerHTML = '<span class="result-badge badge-fail">Fail</span>';
            } else {
                resultBadge.innerHTML = '<span class="result-badge badge-pending">Not Graded</span>';
            }
        }

        function enlargeImage(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            document.getElementById('image-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('image-modal').classList.remove('active');
        }

        document.getElementById('grading-form').addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('input[name^="marks"]');
            let allFilled = true;

            inputs.forEach(input => {
                if (input.value === '' || input.value === null) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                e.preventDefault();
                alert('Please enter marks for all questions before submitting!');
                return false;
            }

            return confirm('Are you sure you want to submit this grading? The student will be notified.');
        });

        calculateTotal();
    </script>
</body>
</html>