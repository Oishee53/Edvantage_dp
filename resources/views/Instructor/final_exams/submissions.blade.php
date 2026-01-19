<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            padding-bottom: 120px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Compact Header */
        .exam-header {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .exam-header h1 {
            color: #0E1B33;
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .exam-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .info-item {
            background: #f3f4f6;
            padding: 0.5rem;
            border-radius: 4px;
            text-align: center;
        }

        .info-label {
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 700;
            color: #0E1B33;
            font-size: 0.95rem;
        }

        .timer {
            font-size: 1.25rem;
            font-weight: 700;
            color: #059669;
        }

        .timer.warning {
            color: #f59e0b;
        }

        .timer.danger {
            color: #dc2626;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        /* Question Cards */
        .question-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .question-number {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0E1B33;
        }

        .question-marks {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .question-text {
            font-size: 1rem;
            line-height: 1.6;
            color: #374151;
            margin-bottom: 1rem;
        }

        .marking-criteria {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .marking-criteria strong {
            color: #065f46;
        }

        /* Upload Section */
        .upload-section {
            margin-top: 1.5rem;
        }

        .upload-section h4 {
            color: #0E1B33;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            background: #f8fafc;
            transition: all 0.3s;
            cursor: pointer;
        }

        .upload-area:hover {
            border-color: #0E1B33;
            background: #f1f5f9;
        }

        .upload-area.dragover {
            border-color: #0E1B33;
            background: #e0e7ff;
        }

        .upload-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .upload-instructions {
            color: #6b7280;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }

        .file-input {
            display: none;
        }

        .upload-button {
            background: #0E1B33;
            color: white;
            border: none;
            padding: 0.625rem 1.5rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.875rem;
        }

        .upload-button:hover {
            background: #1a2645;
            transform: translateY(-2px);
        }

        .preview-area {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-preview {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .image-preview img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            cursor: pointer;
        }

        .image-preview .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #dc2626;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .image-preview .delete-btn:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .status-indicator {
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
            text-align: center;
            font-size: 0.875rem;
        }

        .status-uploaded {
            background: #d1fae5;
            color: #065f46;
        }

        .status-not-uploaded {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-uploading {
            background: #fef3c7;
            color: #92400e;
        }

        /* Fixed Submit Section */
        .submit-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 -4px 6px rgba(0,0,0,0.1);
            z-index: 99;
        }

        .progress-summary {
            margin-bottom: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .submit-button {
            background: #059669;
            color: white;
            border: none;
            padding: 0.875rem 2.5rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-button:hover:not(:disabled) {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .submit-button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0E1B33;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-alert {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 4px;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            body {
                padding-bottom: 140px;
            }

            .exam-info {
                grid-template-columns: repeat(2, 1fr);
            }

            .question-card {
                padding: 1rem;
            }

            .preview-area {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Compact Header -->
        <div class="exam-header">
            <h1>{{ $exam->title }}</h1>
            
            <div class="exam-info">
                <div class="info-item">
                    <div class="info-label">Course</div>
                    <div class="info-value">{{ Str::limit($exam->course->title, 15) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Marks</div>
                    <div class="info-value">{{ $exam->total_marks }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Questions</div>
                    <div class="info-value">{{ $exam->questions()->count() }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Time Left</div>
                    <div class="timer" id="timer">{{ $exam->duration_minutes }}:00</div>
                </div>
            </div>
        </div>

        <!-- Questions -->
        @foreach($exam->questions as $question)
            @php
                $answer = $submission->answers->where('question_id', $question->id)->first();
                $existingImages = $answer && $answer->answer_images ? json_decode($answer->answer_images, true) : [];
            @endphp

            <div class="question-card" id="question-{{ $question->id }}">
                <div class="question-header">
                    <span class="question-number">Q{{ $question->question_number }}</span>
                    <span class="question-marks">{{ $question->marks }} marks</span>
                </div>

                <div class="question-text">
                    {{ $question->question_text }}
                </div>

                @if($question->marking_criteria)
                    <div class="marking-criteria">
                        <strong>Marking Criteria:</strong>
                        <p style="margin: 0.25rem 0 0 0;">{{ $question->marking_criteria }}</p>
                    </div>
                @endif

                <div class="upload-section">
                    <h4>📤 Upload Answer Images (1-5 images)</h4>
                    
                    <div class="upload-area" 
                         id="upload-area-{{ $question->id }}"
                         onclick="document.getElementById('file-input-{{ $question->id }}').click()">
                        <div class="upload-icon">📸</div>
                        <div class="upload-instructions">
                            Click or drag & drop<br>
                            <small>JPEG, PNG · Max 5MB each</small>
                        </div>
                        <button type="button" class="upload-button">
                            Choose Files
                        </button>
                    </div>

                    <input type="file" 
                           id="file-input-{{ $question->id }}"
                           class="file-input"
                           accept="image/jpeg,image/png,image/jpg"
                           multiple
                           onchange="handleFileSelect({{ $question->id }}, this.files)">

                    <div class="preview-area" id="preview-{{ $question->id }}">
                        @foreach($existingImages as $imageUrl)
                            <div class="image-preview">
                                <img src="{{ $imageUrl }}" alt="Answer" onclick="enlargeImage('{{ $imageUrl }}')">
                                <button class="delete-btn" onclick="deleteImage({{ $question->id }}, '{{ $imageUrl }}', event)">×</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="status-indicator" id="status-{{ $question->id }}">
                        @if(count($existingImages) > 0)
                            <span class="status-uploaded">✅ {{ count($existingImages) }} image(s) uploaded</span>
                        @else
                            <span class="status-not-uploaded">❌ Not uploaded</span>
                        @endif
                    </div>

                    <div id="error-{{ $question->id }}" style="display: none;" class="error-alert"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Fixed Submit Section -->
    <div class="submit-section">
        <div class="progress-summary">
            Answered: <strong><span id="answered-count">0</span>/{{ $exam->questions()->count() }}</strong>
        </div>

        <form action="{{ route('student.final-exam.submit', $submission->id) }}" 
              method="POST" 
              id="submit-form"
              onsubmit="return confirmSubmit()">
            @csrf
            <button type="submit" class="submit-button" id="submit-btn" disabled>
                Submit Exam
            </button>
        </form>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const submissionId = {{ $submission->id }};
        const totalQuestions = {{ $exam->questions()->count() }};
        let answeredQuestions = new Set();
        
        const uploadedImages = {
            @foreach($exam->questions as $question)
                @php
                    $answer = $submission->answers->where('question_id', $question->id)->first();
                    $existingImages = $answer && $answer->answer_images ? json_decode($answer->answer_images, true) : [];
                @endphp
                {{ $question->id }}: {!! json_encode($existingImages) !!},
            @endforeach
        };

        // Initialize answered questions
        @foreach($exam->questions as $question)
            @php
                $answer = $submission->answers->where('question_id', $question->id)->first();
                $existingImages = $answer && $answer->answer_images ? json_decode($answer->answer_images, true) : [];
            @endphp
            @if(count($existingImages) > 0)
                answeredQuestions.add({{ $question->id }});
            @endif
        @endforeach

        // Timer
        let duration = {{ $exam->duration_minutes }} * 60;
        const timerDisplay = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(duration / 60);
            const seconds = duration % 60;
            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (duration <= 300) timerDisplay.classList.add('danger');
            else if (duration <= 600) timerDisplay.classList.add('warning');
            
            duration--;
            
            if (duration < 0) {
                alert('Time is up! Auto-submitting...');
                document.getElementById('submit-form').submit();
            }
        }

        setInterval(updateTimer, 1000);

        function showError(questionId, message) {
            const errorDiv = document.getElementById(`error-${questionId}`);
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        // Upload handling
        async function handleFileSelect(questionId, files) {
            if (files.length === 0) return;
            
            const currentImages = uploadedImages[questionId] || [];
            if (currentImages.length + files.length > 5) {
                showError(questionId, 'Maximum 5 images per question');
                return;
            }

            for (let file of files) {
                if (file.size > 5 * 1024 * 1024) {
                    showError(questionId, `${file.name} is too large (max 5MB)`);
                    return;
                }
            }

            updateStatus(questionId, 'uploading');

            for (let file of files) {
                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await fetch(
                        `{{ url('/') }}/final-exam-submissions/${submissionId}/questions/${questionId}/upload-answer`,
                        {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            body: formData
                        }
                    );

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        uploadedImages[questionId] = data.images;
                        displayImages(questionId, data.images);
                        answeredQuestions.add(questionId);
                        updateStatus(questionId, 'uploaded');
                    } else {
                        showError(questionId, data.error || 'Upload failed');
                        updateStatus(questionId, 'not-uploaded');
                    }
                } catch (error) {
                    console.error('Upload error:', error);
                    showError(questionId, `Upload failed: ${error.message}`);
                    updateStatus(questionId, 'not-uploaded');
                }
            }

            updateProgress();
        }

        function displayImages(questionId, images) {
            const previewArea = document.getElementById(`preview-${questionId}`);
            previewArea.innerHTML = '';

            images.forEach((url, i) => {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = `
                    <img src="${url}" alt="Answer ${i+1}" onclick="enlargeImage('${url}')">
                    <button class="delete-btn" onclick="deleteImage(${questionId}, '${url}', event)">×</button>
                `;
                previewArea.appendChild(div);
            });
        }

        function enlargeImage(url) {
            const overlay = document.createElement('div');
            overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.9);z-index:9999;display:flex;align-items:center;justify-content:center;cursor:pointer;';
            const img = document.createElement('img');
            img.src = url;
            img.style.cssText = 'max-width:90%;max-height:90%;border-radius:8px;';
            overlay.appendChild(img);
            overlay.onclick = () => document.body.removeChild(overlay);
            document.body.appendChild(overlay);
        }

        async function deleteImage(questionId, url, event) {
            event.stopPropagation();
            if (!confirm('Delete this image?')) return;

            try {
                const response = await fetch(
                    `{{ url('/') }}/final-exam-submissions/${submissionId}/questions/${questionId}/delete-image`,
                    {
                        method: 'DELETE',
                        headers: { 
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ image_url: url })
                    }
                );

                const data = await response.json();

                if (data.success) {
                    uploadedImages[questionId] = data.images;
                    
                    if (data.images.length > 0) {
                        displayImages(questionId, data.images);
                        updateStatus(questionId, 'uploaded');
                    } else {
                        document.getElementById(`preview-${questionId}`).innerHTML = '';
                        answeredQuestions.delete(questionId);
                        updateStatus(questionId, 'not-uploaded');
                    }
                    updateProgress();
                } else {
                    showError(questionId, data.error || 'Delete failed');
                }
            } catch (error) {
                console.error('Delete error:', error);
                showError(questionId, 'Delete failed');
            }
        }

        function updateStatus(questionId, status) {
            const statusDiv = document.getElementById(`status-${questionId}`);
            
            if (status === 'uploading') {
                statusDiv.innerHTML = '<span class="status-uploading">⏳ Uploading...<span class="loading"></span></span>';
            } else if (status === 'uploaded') {
                const count = uploadedImages[questionId].length;
                statusDiv.innerHTML = `<span class="status-uploaded">✅ ${count} image(s) uploaded</span>`;
            } else {
                statusDiv.innerHTML = '<span class="status-not-uploaded">❌ Not uploaded</span>';
            }
        }

        function updateProgress() {
            document.getElementById('answered-count').textContent = answeredQuestions.size;
            document.getElementById('submit-btn').disabled = (answeredQuestions.size < totalQuestions);
        }

        function confirmSubmit() {
            if (answeredQuestions.size < totalQuestions) {
                alert(`Please answer all questions (${answeredQuestions.size}/${totalQuestions})`);
                return false;
            }
            return confirm('⚠️ Submit exam? You cannot change answers after submission.');
        }

        // Drag & drop
        document.querySelectorAll('.upload-area').forEach(area => {
            const questionId = area.id.split('-')[2];
            area.addEventListener('dragover', (e) => { e.preventDefault(); area.classList.add('dragover'); });
            area.addEventListener('dragleave', () => area.classList.remove('dragover'));
            area.addEventListener('drop', (e) => {
                e.preventDefault();
                area.classList.remove('dragover');
                handleFileSelect(questionId, e.dataTransfer.files);
            });
        });

        window.addEventListener('beforeunload', (e) => { e.preventDefault(); e.returnValue = ''; });

        updateProgress();

        // Debug: Log the upload URL
        console.log('Upload URL will be:', `{{ url('/') }}/final-exam-submissions/${submissionId}/questions/[QUESTION_ID]/upload-answer`);
    </script>
</body>
</html>