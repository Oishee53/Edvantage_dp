<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $exam->title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #FFFFFF;
            --bg-secondary: #F8F9FA;
            --text: #1A1A1A;
            --text-secondary: #6B7280;
            --border: #E5E7EB;
            --teal: #14B8A6;
            --teal-dark: #0D9488;
            --teal-light: #5EEAD4;
            --black: #1A1A1A;
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding-bottom: 80px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* ===== COMPACT HEADER ===== */
        .exam-header {
            background: var(--bg);
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 90;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .exam-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text);
            flex: 1;
        }

        .header-stats {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .timer {
            font-weight: 700;
            color: var(--teal);
            font-size: 1.125rem;
            font-variant-numeric: tabular-nums;
        }

        .timer.warning { color: #F59E0B; }
        .timer.danger { color: #EF4444; }

        /* ===== FLOATING VIDEO FEEDS ===== */
        .video-feeds {
            position: fixed;
            top: 80px;
            right: 1rem;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .video-feed {
            width: 200px;
            background: var(--black);
            border-radius: var(--radius);
            overflow: hidden;
            border: 2px solid var(--border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .video-feed-header {
            background: var(--black);
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
        }

        .video-feed-label {
            color: white;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .rec-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #EF4444;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .rec-dot.inactive {
            background: #6B7280;
            animation: none;
        }

        .video-feed video {
            width: 100%;
            height: 112px;
            display: block;
            object-fit: cover;
        }

        /* ===== QUESTIONS ===== */
        .question {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .question-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .question-number {
            font-weight: 600;
            color: var(--text);
            font-size: 0.9375rem;
        }

        .question-marks {
            background: var(--teal);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .question-text {
            font-size: 0.9375rem;
            color: var(--text);
            margin-bottom: 1rem;
            line-height: 1.7;
        }

        .marking-criteria {
            background: var(--bg-secondary);
            border-left: 3px solid var(--teal);
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .marking-criteria strong {
            display: block;
            margin-bottom: 0.375rem;
            color: var(--text);
        }

        .marking-criteria p {
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== UPLOAD ===== */
        .upload-section {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
        }

        .upload-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.75rem;
            display: block;
        }

        .upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            background: var(--bg-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .upload-area:hover {
            border-color: var(--teal);
            background: var(--bg);
        }

        .upload-area.dragover {
            border-color: var(--teal);
            background: #F0FDFA;
            border-style: solid;
        }

        .upload-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }

        .upload-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }

        .upload-button {
            background: var(--teal);
            color: white;
            border: none;
            padding: 0.5rem 1.25rem;
            border-radius: var(--radius);
            cursor: pointer;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .upload-button:hover {
            background: var(--teal-dark);
        }

        .file-input {
            display: none;
        }

        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .image-preview {
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .image-preview img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
            cursor: pointer;
        }

        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .delete-btn:hover {
            background: #EF4444;
            transform: scale(1.1);
        }

        .status {
            margin-top: 0.75rem;
            padding: 0.5rem;
            border-radius: var(--radius);
            text-align: center;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .status-uploaded {
            background: #ECFDF5;
            color: #065F46;
        }

        .status-not-uploaded {
            background: #FEF2F2;
            color: #991B1B;
        }

        .status-uploading {
            background: #FFFBEB;
            color: #92400E;
        }

        .error-alert {
            background: #FEF2F2;
            color: #991B1B;
            padding: 0.75rem;
            border-radius: var(--radius);
            margin-top: 0.75rem;
            font-size: 0.8125rem;
            display: none;
        }

        /* ===== SUBMIT BAR ===== */
        .submit-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--bg);
            border-top: 1px solid var(--border);
            padding: 1rem;
            z-index: 90;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }

        .submit-content {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .progress {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .progress strong {
            color: var(--text);
            font-weight: 600;
        }

        .submit-button {
            background: var(--teal);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: var(--radius);
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .submit-button:hover:not(:disabled) {
            background: var(--teal-dark);
        }

        .submit-button:disabled {
            background: #D1D5DB;
            cursor: not-allowed;
        }

        .loading {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-left: 0.5rem;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== MONITORING NOTICE ===== */
        .monitoring-notice {
            background: var(--bg-secondary);
            border-left: 3px solid var(--black);
            padding: 0.875rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        .monitoring-notice strong {
            color: var(--text);
            display: block;
            margin-bottom: 0.25rem;
        }

        /* ===== IMAGE OVERLAY ===== */
        .image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 2rem;
        }

        .image-overlay img {
            max-width: 100%;
            max-height: 100%;
            border-radius: var(--radius);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                padding-bottom: 90px;
            }

            .container {
                padding: 0.75rem;
            }

            .header-content {
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .header-stats {
                gap: 1rem;
                font-size: 0.8125rem;
            }

            .video-feeds {
                top: 60px;
                right: 0.5rem;
            }

            .video-feed {
                width: 140px;
            }

            .video-feed video {
                height: 80px;
            }

            .question {
                padding: 1rem;
            }

            .preview-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                gap: 0.5rem;
            }

            .image-preview img {
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Compact Header -->
    <div class="exam-header">
        <div class="header-content">
            <div class="exam-title">{{ $exam->title }}</div>
            <div class="header-stats">
                <span>{{ $exam->course->title }}</span>
                <span>•</span>
                <span>{{ $exam->questions()->count() }} questions</span>
                <span>•</span>
                <span class="timer" id="timer">{{ $exam->duration_minutes }}:00</span>
            </div>
        </div>
    </div>

    <!-- Floating Video Feeds -->
    <div class="video-feeds">
        <div class="video-feed">
            <div class="video-feed-header">
                <div class="video-feed-label">
                    <div class="rec-dot" id="webcamDot"></div>
                    <span id="webcamStatus">Camera</span>
                </div>
            </div>
            <video id="webcamPreview" autoplay muted playsinline></video>
        </div>
        
        <div class="video-feed">
            <div class="video-feed-header">
                <div class="video-feed-label">
                    <div class="rec-dot" id="screenDot"></div>
                    <span id="screenStatus">Screen</span>
                </div>
            </div>
            <video id="screenPreview" autoplay muted playsinline></video>
        </div>
    </div>

    <div class="container">
        <!-- Monitoring Notice -->
        <div class="monitoring-notice">
            <strong>Exam Proctoring Active</strong>
            Your webcam and screen are being recorded. Do not close or minimize this window.
        </div>

        <!-- Questions -->
        @foreach($exam->questions as $question)
            @php
                $answer = $submission->answers->where('question_id', $question->id)->first();
                $existingImages = $answer && $answer->answer_images ? json_decode($answer->answer_images, true) : [];
            @endphp

            <div class="question" id="question-{{ $question->id }}">
                <div class="question-header">
                    <span class="question-number">Question {{ $question->question_number }}</span>
                    <span class="question-marks">{{ $question->marks }} marks</span>
                </div>

                <div class="question-text">{{ $question->question_text }}</div>

                @if($question->marking_criteria)
                    <div class="marking-criteria">
                        <strong>Marking Criteria</strong>
                        <p>{{ $question->marking_criteria }}</p>
                    </div>
                @endif

                <div class="upload-section">
                    <label class="upload-label">Upload Answer (1-5 images)</label>
                    
                    <div class="upload-area" 
                         id="upload-area-{{ $question->id }}"
                         onclick="document.getElementById('file-input-{{ $question->id }}').click()">
                        <div class="upload-icon">📎</div>
                        <div class="upload-text">
                            Click or drag images here<br>
                            <small>JPG, PNG • Max 5MB each</small>
                        </div>
                        <button type="button" class="upload-button">Browse</button>
                    </div>

                    <input type="file" 
                           id="file-input-{{ $question->id }}"
                           class="file-input"
                           accept="image/jpeg,image/png,image/jpg"
                           multiple
                           onchange="handleFileSelect({{ $question->id }}, this.files)">

                    <div class="preview-grid" id="preview-{{ $question->id }}">
                        @foreach($existingImages as $imageUrl)
                            <div class="image-preview">
                                <img src="{{ $imageUrl }}" alt="Answer" onclick="enlargeImage('{{ $imageUrl }}')">
                                <button class="delete-btn" onclick="deleteImage({{ $question->id }}, '{{ $imageUrl }}', event)">×</button>
                            </div>
                        @endforeach
                    </div>

                    <div class="status" id="status-{{ $question->id }}">
                        @if(count($existingImages) > 0)
                            <span class="status-uploaded">✓ {{ count($existingImages) }} image(s) uploaded</span>
                        @else
                            <span class="status-not-uploaded">Not uploaded</span>
                        @endif
                    </div>

                    <div id="error-{{ $question->id }}" class="error-alert"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Submit Bar -->
    <div class="submit-bar">
        <div class="submit-content">
            <div class="progress">
                <strong><span id="answered-count">0</span>/{{ $exam->questions()->count() }}</strong> answered
            </div>

            <form action="{{ route('student.final-exam.submit', $submission->id) }}" 
                  method="POST" 
                  id="submit-form"
                  enctype="multipart/form-data"
                  onsubmit="return confirmSubmit()">
                @csrf
                <input type="file" name="webcam_video" id="webcamVideoInput" hidden>
                <input type="file" name="screen_recording" id="screenRecordingInput" hidden>
                <button type="submit" class="submit-button" id="submit-btn" disabled>
                    Submit Exam
                </button>
            </form>
        </div>
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
            
            timerDisplay.classList.remove('warning', 'danger');
            if (duration <= 300) timerDisplay.classList.add('danger');
            else if (duration <= 600) timerDisplay.classList.add('warning');
            
            duration--;
            
            if (duration < 0) {
                alert('Time up! Auto-submitting...');
                document.getElementById('submit-form').submit();
            }
        }

        setInterval(updateTimer, 1000);

        function showError(questionId, message) {
            const errorDiv = document.getElementById(`error-${questionId}`);
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => errorDiv.style.display = 'none', 5000);
        }

        async function handleFileSelect(questionId, files) {
            if (files.length === 0) return;
            
            const currentImages = uploadedImages[questionId] || [];
            if (currentImages.length + files.length > 5) {
                showError(questionId, 'Maximum 5 images per question');
                return;
            }

            for (let file of files) {
                if (file.size > 5 * 1024 * 1024) {
                    showError(questionId, `${file.name} exceeds 5MB`);
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
                    showError(questionId, 'Upload failed');
                    updateStatus(questionId, 'not-uploaded');
                }
            }

            updateProgress();
        }

        function displayImages(questionId, images) {
            const previewArea = document.getElementById(`preview-${questionId}`);
            previewArea.innerHTML = '';

            images.forEach((url) => {
                const div = document.createElement('div');
                div.className = 'image-preview';
                div.innerHTML = `
                    <img src="${url}" alt="Answer" onclick="enlargeImage('${url}')">
                    <button class="delete-btn" onclick="deleteImage(${questionId}, '${url}', event)">×</button>
                `;
                previewArea.appendChild(div);
            });
        }

        function enlargeImage(url) {
            const overlay = document.createElement('div');
            overlay.className = 'image-overlay';
            const img = document.createElement('img');
            img.src = url;
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
                    showError(questionId, 'Delete failed');
                }
            } catch (error) {
                showError(questionId, 'Delete failed');
            }
        }

        function updateStatus(questionId, status) {
            const statusDiv = document.getElementById(`status-${questionId}`);
            
            if (status === 'uploading') {
                statusDiv.innerHTML = '<span class="status-uploading">Uploading...<span class="loading"></span></span>';
            } else if (status === 'uploaded') {
                const count = uploadedImages[questionId].length;
                statusDiv.innerHTML = `<span class="status-uploaded">✓ ${count} image(s) uploaded</span>`;
            } else {
                statusDiv.innerHTML = '<span class="status-not-uploaded">Not uploaded</span>';
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
            return confirm('Submit exam? You cannot change answers after submission.');
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

        // ===== RECORDING =====
        let webcamRecorder, screenRecorder;
        let webcamChunks = [], screenChunks = [];
        let webcamStream, screenStream;

        async function startWebcamRecording() {
            try {
                webcamStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
                document.getElementById('webcamPreview').srcObject = webcamStream;
                
                webcamRecorder = new MediaRecorder(webcamStream, { mimeType: 'video/webm;codecs=vp8,opus' });
                webcamRecorder.ondataavailable = e => { if (e.data.size > 0) webcamChunks.push(e.data); };
                webcamRecorder.start();

                document.getElementById('webcamDot').classList.remove('inactive');
            } catch (error) {
                document.getElementById('webcamDot').classList.add('inactive');
                document.getElementById('webcamStatus').textContent = 'Failed';
                alert('Webcam access required');
            }
        }

        async function startScreenRecording() {
            try {
                screenStream = await navigator.mediaDevices.getDisplayMedia({ video: { mediaSource: 'screen' }, audio: false });
                document.getElementById('screenPreview').srcObject = screenStream;

                screenRecorder = new MediaRecorder(screenStream, { mimeType: 'video/webm;codecs=vp8' });
                screenRecorder.ondataavailable = e => { if (e.data.size > 0) screenChunks.push(e.data); };
                screenRecorder.start();

                document.getElementById('screenDot').classList.remove('inactive');

                screenStream.getVideoTracks()[0].onended = () => {
                    alert('Screen sharing stopped! Please restart.');
                    startScreenRecording();
                };
            } catch (error) {
                document.getElementById('screenDot').classList.add('inactive');
                document.getElementById('screenStatus').textContent = 'Failed';
                alert('Screen recording required');
            }
        }

        function stopWebcamRecording() {
            return new Promise(resolve => {
                if (!webcamRecorder || webcamRecorder.state === 'inactive') {
                    resolve();
                    return;
                }

                webcamRecorder.onstop = () => {
                    const blob = new Blob(webcamChunks, { type: 'video/webm' });
                    const file = new File([blob], 'webcam.webm', { type: 'video/webm' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('webcamVideoInput').files = dataTransfer.files;
                    webcamStream.getTracks().forEach(track => track.stop());
                    document.getElementById('webcamDot').classList.add('inactive');
                    resolve();
                };
                
                webcamRecorder.stop();
            });
        }

        function stopScreenRecording() {
            return new Promise(resolve => {
                if (!screenRecorder || screenRecorder.state === 'inactive') {
                    resolve();
                    return;
                }

                screenRecorder.onstop = () => {
                    const blob = new Blob(screenChunks, { type: 'video/webm' });
                    const file = new File([blob], 'screen.webm', { type: 'video/webm' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('screenRecordingInput').files = dataTransfer.files;
                    screenStream.getTracks().forEach(track => track.stop());
                    document.getElementById('screenDot').classList.add('inactive');
                    resolve();
                };
                
                screenRecorder.stop();
            });
        }

        window.onload = async function() {
            await startWebcamRecording();
            await startScreenRecording();
        };

        document.getElementById('submit-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting... <span class="loading"></span>';

            try {
                await Promise.all([stopWebcamRecording(), stopScreenRecording()]);
                await new Promise(resolve => setTimeout(resolve, 500));
                this.submit();
            } catch (error) {
                alert('Error preparing recordings');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Exam';
            }
        });
    </script>
</body>
</html>