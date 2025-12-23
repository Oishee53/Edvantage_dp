<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Final Exam</title>
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
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h1 {
            color: #0E1B33;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #374151;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-family: inherit;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .question-card {
            background: #f3f4f6;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            position: relative;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .question-number {
            font-weight: 700;
            color: #0E1B33;
            font-size: 1.1rem;
        }

        .remove-question-btn {
            background: #DC2626;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .remove-question-btn:hover {
            background: #B91C1C;
        }

        .add-question-btn {
            background: #0E1B33;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 1.5rem;
        }

        .add-question-btn:hover {
            background: #1a2645;
        }

        .submit-btn {
            background: #059669;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
        }

        .submit-btn:hover {
            background: #047857;
        }

        .error {
            background: #FEE2E2;
            color: #DC2626;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .info-box {
            background: #DBEAFE;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            border-left: 4px solid #3B82F6;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .total-marks-display {
            background: #FEF3C7;
            padding: 1rem;
            border-radius: 4px;
            margin: 1rem 0;
            text-align: center;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Final Exam</h1>

        <div class="info-box">
            <strong>📋 Important:</strong> You can save as draft or publish immediately. Passing mark is automatically set to 70%.
        </div>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('instructor.final-exams.store') }}" method="POST" id="examForm">
            @csrf

            <!-- Course Selection -->
            <div class="form-group">
                <label for="course_id">Select Course *</label>
                <select name="course_id" id="course_id" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Exam Title -->
            <div class="form-group">
                <label for="title">Exam Title *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                       placeholder="e.g., Final Written Examination" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description / Instructions</label>
                <textarea name="description" id="description" 
                          placeholder="Provide instructions or overview for students">{{ old('description') }}</textarea>
            </div>

            <!-- Total Marks and Duration -->
            <div class="row">
                <div class="form-group">
                    <label for="total_marks">Total Marks *</label>
                    <input type="number" name="total_marks" id="total_marks" 
                           value="{{ old('total_marks', 100) }}" min="1" required>
                    <small style="color: #6b7280;">Must match sum of question marks</small>
                </div>

                <div class="form-group">
                    <label for="duration_minutes">Duration (minutes) *</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" 
                           value="{{ old('duration_minutes', 180) }}" min="30" max="480" required>
                    <small style="color: #6b7280;">Default: 180 minutes (3 hours)</small>
                </div>
            </div>

            <!-- Questions Section -->
            <h2 style="margin: 2rem 0 1rem 0; color: #0E1B33;">Exam Questions</h2>

            <div id="questions-container">
                <!-- Questions will be added here dynamically -->
            </div>

            <button type="button" class="add-question-btn" onclick="addQuestion()">
                + Add Question
            </button>

            <div class="total-marks-display" id="totalMarksCheck">
                Total Question Marks: <span id="sumDisplay">0</span> / <span id="targetMarks">100</span>
            </div>

            <!-- Publish Option -->
            <div class="form-group" style="margin: 2rem 0;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="publish_now" value="1" style="width: auto; margin-right: 0.5rem;">
                    <span>Publish immediately (make available to students now)</span>
                </label>
                <small style="color: #6b7280; margin-left: 1.75rem;">
                    If unchecked, exam will be saved as draft. You can publish it later.
                </small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Create Final Exam</button>
        </form>
    </div>

    <script>
        let questionCount = 0;

        // Add initial question
        document.addEventListener('DOMContentLoaded', function() {
            addQuestion();
            updateTotalMarks();
            
            // Watch for changes in total_marks input
            document.getElementById('total_marks').addEventListener('input', updateTotalMarks);
        });

        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questions-container');
            
            const questionCard = document.createElement('div');
            questionCard.className = 'question-card';
            questionCard.innerHTML = `
                <div class="question-header">
                    <span class="question-number">Question ${questionCount}</span>
                    <button type="button" class="remove-question-btn" onclick="removeQuestion(this)">
                        Remove
                    </button>
                </div>

                <div class="form-group">
                    <label>Question Text *</label>
                    <textarea name="questions[${questionCount-1}][question_text]" required 
                              placeholder="Enter the question..."></textarea>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label>Marks for this Question *</label>
                        <input type="number" name="questions[${questionCount-1}][marks]" 
                               min="1" required value="20" onchange="updateTotalMarks()">
                    </div>
                </div>

                <div class="form-group">
                    <label>Marking Criteria (Optional)</label>
                    <textarea name="questions[${questionCount-1}][marking_criteria]" 
                              placeholder="Guidelines for grading this question..."></textarea>
                </div>
            `;
            
            container.appendChild(questionCard);
            updateTotalMarks();
        }

        function removeQuestion(button) {
            if (document.querySelectorAll('.question-card').length <= 1) {
                alert('You must have at least one question!');
                return;
            }
            
            button.closest('.question-card').remove();
            updateQuestionNumbers();
            updateTotalMarks();
        }

        function updateQuestionNumbers() {
            const questions = document.querySelectorAll('.question-card');
            questions.forEach((card, index) => {
                card.querySelector('.question-number').textContent = `Question ${index + 1}`;
            });
        }

        function updateTotalMarks() {
            const marksInputs = document.querySelectorAll('input[name*="[marks]"]');
            let sum = 0;
            
            marksInputs.forEach(input => {
                sum += parseInt(input.value) || 0;
            });
            
            const targetMarks = parseInt(document.getElementById('total_marks').value) || 100;
            
            document.getElementById('sumDisplay').textContent = sum;
            document.getElementById('targetMarks').textContent = targetMarks;
            
            // Visual feedback
            const display = document.getElementById('totalMarksCheck');
            if (sum === targetMarks) {
                display.style.background = '#D1FAE5';
                display.style.color = '#065F46';
            } else {
                display.style.background = '#FEF3C7';
                display.style.color = '#92400E';
            }
        }

        // Validate before submit
        document.getElementById('examForm').addEventListener('submit', function(e) {
            const marksInputs = document.querySelectorAll('input[name*="[marks]"]');
            let sum = 0;
            marksInputs.forEach(input => {
                sum += parseInt(input.value) || 0;
            });
            
            const targetMarks = parseInt(document.getElementById('total_marks').value) || 100;
            
            if (sum !== targetMarks) {
                e.preventDefault();
                alert(`Sum of question marks (${sum}) must equal total marks (${targetMarks})`);
            }
        });
    </script>
</body>
</html>