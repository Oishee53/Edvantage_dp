<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Exam - {{ $submission->exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f2f9',
                            100: '#e3e6f3',
                            600: '#1a2d52',
                            700: '#0E1B33',
                            800: '#0a1426',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
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

        /* Proctoring Recordings Section */
        .recordings-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .recording-box {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 1rem;
        }

        .video-container {
            margin-top: 0.75rem;
            margin-bottom: 0.5rem;
            background: #000;
            border-radius: 4px;
            overflow: hidden;
        }

        .recording-video {
            width: 100%;
            height: auto;
            min-height: 300px;
            display: block;
        }

        .recording-info {
            font-size: 0.75rem;
            color: var(--text-tertiary);
            font-style: italic;
            padding: 0.5rem;
            background: var(--bg-primary);
            border-radius: 3px;
        }

        .proctoring-notes {
            margin-top: 1rem;
            padding: 1rem;
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
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

            .recordings-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
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

            .recordings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        
        {{-- Import Sidebar Component --}}
        @include('layouts.sidebar')

        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            {{-- Import Header Component --}}
            <x-instructor-header 
                :title="'Grade Submission - ' . $submission->exam->title"
            />

            <div class="container mx-auto px-6 py-6 max-w-5xl">

                <!-- Exam Info Card -->
                <div class="question-card">
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 rounded-lg p-4 border border-gray-200 text-center">
                                <div class="text-2xl font-bold text-gray-700">{{ $submission->exam->questions()->count() }}</div>
                                <div class="text-xs text-gray-600 font-semibold uppercase tracking-wide mt-1">Questions</div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 border border-gray-200 text-center">
                                <div class="text-2xl font-bold text-gray-700">{{ $submission->exam->total_marks }}</div>
                                <div class="text-xs text-gray-600 font-semibold uppercase tracking-wide mt-1">Total Marks</div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 border border-gray-200 text-center">
                                <div class="text-lg font-bold text-gray-700">{{ $submission->submitted_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-600 font-semibold uppercase tracking-wide mt-1">Submitted</div>
                                <div class="text-xs text-gray-600 mt-1">{{ $submission->submitted_at->format('g:i A') }}</div>
                            </div>
                            <div class="bg-blue-50 rounded-lg p-4 border border-gray-200 text-center">
                                <div class="text-2xl font-bold text-gray-700" id="total-score">0</div>
                                <div class="text-xs text-gray-600 font-semibold uppercase tracking-wide mt-1">Current Score</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Proctoring Recordings Section -->
                @if($submission->webcam_playback_id || $submission->screen_recording_playback_id)
                    <div class="question-card">
                        <div class="question-header">
                            <div style="flex: 1;">
                                <h3 class="question-title">🎥 Proctoring Recordings</h3>
                                <p class="question-text">Review the student's webcam and screen recordings during the exam</p>
                            </div>
                        </div>

                        <div class="question-body">
                            <div class="recordings-grid">
                                @if($submission->webcam_playback_id)
                                    <div class="recording-box">
                                        <div class="section-label">📹 Webcam Recording</div>
                                        <div class="video-container">
                                            <video controls controlsList="nodownload" class="recording-video">
                                                <source src="https://stream.mux.com/{{ $submission->webcam_playback_id }}.m3u8" type="application/x-mpegURL">
                                                Your browser doesn't support HLS playback.
                                            </video>
                                        </div>
                                        <div class="recording-info">
                                            <small>Watch for: Face visibility, eye movement, suspicious behavior</small>
                                        </div>
                                    </div>
                                @endif

                                @if($submission->screen_recording_playback_id)
                                    <div class="recording-box">
                                        <div class="section-label">🖥️ Screen Recording</div>
                                        <div class="video-container">
                                            <video controls controlsList="nodownload" class="recording-video">
                                                <source src="https://stream.mux.com/{{ $submission->screen_recording_playback_id }}.m3u8" type="application/x-mpegURL">
                                                Your browser doesn't support HLS playback.
                                            </video>
                                        </div>
                                        <div class="recording-info">
                                            <small>Watch for: Tab switching, external resources, screen sharing</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="proctoring-notes">
                                <div class="section-label">⚠️ Proctoring Notes</div>
                                <div class="form-group">
                                    <textarea name="proctoring_notes" 
                                              class="form-input"
                                              style="min-height: 80px;"
                                              placeholder="Note any suspicious activity or violations observed in the recordings...">{{ $submission->proctoring_notes ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Grading Form -->
                <form action="{{ route('instructor.final-exams.save-grades', $submission->id) }}" method="POST" id="grading-form">
                    @csrf

                    <!-- Questions -->
                    @foreach($submission->answers as $answer)
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-3">
                                            <h3 class="text-lg font-bold text-teal-900">Question {{ $answer->question->question_number }}</h3>
                                        </div>
                                        <p class="text-teal-700 leading-relaxed">{{ $answer->question->question_text }}</p>
                                        
                                        @if($answer->question->marking_criteria)
                                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-3">
                                                <p class="text-xs font-bold text-blue-900 mb-1">MARKING CRITERIA</p>
                                                <p class="text-sm text-teal-700">{{ $answer->question->marking_criteria }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-3 py-1 bg-amber-100 text-amber-700 rounded-lg font-bold text-sm whitespace-nowrap">
                                        {{ $answer->question->marks }} marks
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h4 class="text-sm font-bold text-teal-900 mb-3">Student's Answer</h4>
                                
                                @php
                                    $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
                                @endphp

                                @if(count($images) > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        @foreach($images as $imageUrl)
                                            <div class="relative group cursor-pointer rounded-lg overflow-hidden border-2 border-gray-200 hover:border-teal-600 transition-all" onclick="enlargeImage('{{ $imageUrl }}')">
                                                <img src="{{ $imageUrl }}" alt="Answer" class="w-full h-56 object-cover">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                                    <span class="text-white font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-search-plus text-2xl"></i>
                                                    </span>
                                                </div>
                                                <div class="absolute top-2 right-2 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-semibold">
                                                    Click to enlarge
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-600">No images uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div class="px-6 pb-6 pt-4 bg-gray-50 border-t border-gray-200">
                                <h4 class="text-sm font-bold text-teal-900 mb-3">Grading</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-teal-900 mb-2">
                                            Marks (out of {{ $answer->question->marks }})
                                        </label>
                                        <input type="number" 
                                               name="marks[{{ $answer->id }}]" 
                                               min="0" 
                                               max="{{ $answer->question->marks }}" 
                                               step="0.5"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-600 focus:ring-4 focus:ring-teal-100 transition-all outline-none font-bold text-lg"
                                               placeholder="0"
                                               value="{{ $answer->marks_obtained ?? '' }}"
                                               required
                                               onchange="calculateTotal()">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-teal-900 mb-2">
                                            Comment/Feedback (Optional)
                                        </label>
                                        <textarea name="comments[{{ $answer->id }}]" 
                                                  rows="3"
                                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-600 focus:ring-4 focus:ring-teal-100 transition-all outline-none font-medium resize-none"
                                                  placeholder="Write your feedback...">{{ $answer->instructor_comment ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Summary -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-bold text-teal-900">Overall Feedback & Summary</h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-teal-900 mb-2">
                                    Overall Feedback
                                </label>
                                <textarea name="overall_feedback" 
                                          rows="4"
                                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-600 focus:ring-4 focus:ring-teal-100 transition-all outline-none font-medium resize-none"
                                          placeholder="Write overall feedback for the student...">{{ $submission->instructor_feedback ?? '' }}</textarea>
                            </div>

                            <div class="bg-blue-50 rounded-xl p-6 border border-blue-200 mb-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Total Score</div>
                                        <div class="text-3xl font-bold text-teal-900" id="total-score-display">0</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Out of</div>
                                        <div class="text-3xl font-bold text-teal-900">{{ $submission->exam->total_marks }}</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Percentage</div>
                                        <div class="text-3xl font-bold text-teal-900" id="percentage">0%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Result</div>
                                        <div id="result-badge" class="mt-1">
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">Not Graded</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-xl font-semibold hover:bg-teal-700 transition-all">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $submission->status === 'graded' ? 'Update Grading' : 'Submit Grading' }} & Notify Student</span>
                                </button>
                                <a href="{{ route('instructor.final-exams.submissions', $submission->exam->id) }}" 
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-white text-teal-700 border-2 border-teal-700 rounded-xl font-semibold hover:bg-teal-700 hover:text-white transition-all">
                                    <i class="fas fa-times"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </main>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="modal" onclick="closeModal()">
        <button class="modal-close" onclick="closeModal()">×</button>
        <img id="modal-image" src="" onclick="event.stopPropagation()">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        // Initialize HLS for video playback
        document.addEventListener('DOMContentLoaded', function() {
            const videos = document.querySelectorAll('.recording-video');
            
            videos.forEach(video => {
                const source = video.querySelector('source');
                if (source && Hls.isSupported()) {
                    const hls = new Hls();
                    hls.loadSource(source.src);
                    hls.attachMedia(video);
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    // Native HLS support (Safari)
                    video.src = source.src;
                }
            });

            // Calculate total on page load
            calculateTotal();
        });

        function calculateTotal() {
            let total = 0;
            const totalMarks = {{ $submission->exam->total_marks }};
            
            document.querySelectorAll('input[name^="marks"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('total-score').textContent = total.toFixed(1);
            document.getElementById('total-score-display').textContent = total.toFixed(1);
            
            const percentage = (total / totalMarks * 100).toFixed(1);
            document.getElementById('percentage').textContent = percentage + '%';

            const resultBadge = document.getElementById('result-badge');
            if (percentage >= 70) {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold"><i class="fas fa-check-circle mr-1"></i>PASS</span>';
            } else if (percentage > 0) {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold"><i class="fas fa-times-circle mr-1"></i>FAIL</span>';
            } else {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">Not Graded</span>';
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
                if (input.value === '' || input.value === null) allFilled = false;
            });

            if (!allFilled) {
                e.preventDefault();
                alert('Please enter marks for all questions before submitting!');
                return false;
            }

            return confirm('Are you sure you want to submit this grading? The student will be notified.');
        });
    </script>
</body>
</html>