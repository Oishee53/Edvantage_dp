<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Resources - {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #f8fafc;
        }
        
        .resource-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .resource-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-color: #14b8a6;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .icon-box {
            width: 48px;
            height: 48px;
            background: #f0fdfa;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .icon-box i {
            color: #14b8a6;
            font-size: 1.25rem;
        }
        
        .btn-teal {
            background: #14b8a6;
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }
        
        .btn-teal:hover {
            background: #0d9488;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(20, 184, 166, 0.3);
        }
        
        .btn-navy {
            background: #0E1B33;
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }
        
        .btn-navy:hover {
            background: #334155;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 27, 51, 0.3);
        }
        
        .video-container {
            background: #000;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .info-box {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 8px;
            padding: 0.875rem 1rem;
            color: #0f766e;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            border-left: 4px solid #22c55e;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }
        
        .page-header {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 2rem;
        }
        
        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #0E1B33;
            margin-bottom: 0.75rem;
        }
        
        .lecture-info {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.95rem;
        }
        
        .question-form {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
        }
        
        .form-input {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #14b8a6;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: #f9fafb;
            border-radius: 8px;
        }
        
        .empty-state i {
            font-size: 2.5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #64748b;
        }
    </style>
</head>
<body class="min-h-screen px-20 pt-5">
    @include('layouts.header')

    <div class="container mx-auto px-6 py-8 max-w-5xl pt-24">
        {{-- Header --}}
        <div class="page-header mb-8">
            <h1 class="page-title">{{ $course->name }}</h1>
            <div class="lecture-info">
                <i class="fas fa-book-open"></i>
                <span>Lecture {{ $moduleNumber }}</span>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('error'))
            <div class="alert-error px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-exclamation-triangle mr-3"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @auth
                {{-- Video Section --}}
                @if($resource->videos)
                    <div class="resource-card">
                        <div class="card-header">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="icon-box">
                                        <i class="fas fa-play"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Video Content</h2>
                                        <p class="text-sm text-gray-500">Watch the lecture video</p>
                                    </div>
                                </div>
                                <button 
                                    onclick="toggleVideo()" 
                                    id="videoToggleBtn"
                                    class="btn-teal">
                                    <i class="fas fa-eye" id="videoToggleIcon"></i>
                                    <span id="videoToggleText">View Video</span>
                                </button>
                            </div>
                        </div>

                        <div id="videoPlayer" class="p-6 hidden">
                            <div class="video-container">
                                <mux-player 
                                    id="mux-player"
                                    playback-id="{{ $resource->videos }}"
                                    stream-type="on-demand"
                                    controls
                                    class="w-full aspect-video">
                                </mux-player>
                            </div>
                            <div class="info-box mt-4">
                                <i class="fas fa-info-circle"></i>
                                <span>Your progress is automatically saved as you watch</span>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- PDF Section --}}
                @if($resource->pdf)
                    <div class="resource-card">
                        <div class="card-header">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="icon-box">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">PDF Document</h2>
                                        <p class="text-sm text-gray-500">Download or view the lecture PDF</p>
                                    </div>
                                </div>
                                <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="btn-teal">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>View PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                {{-- Guest message --}}
                <div class="resource-card">
                    <div class="empty-state">
                        <i class="fas fa-lock"></i>
                        <h3>Authentication Required</h3>
                        <p>Please log in to access the video content and resources.</p>
                    </div>
                </div>
            @endauth

            {{-- Quiz Section --}}
            <div class="resource-card">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="icon-box">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Lecture Quiz</h2>
                                <p class="text-sm text-gray-500">Test your knowledge</p>
                            </div>
                        </div>
                        @if($quiz)
                            <a href="{{ route('user.quiz.start', ['course' => $course->id, 'module' => $moduleNumber]) }}"
                               class="btn-teal">
                                <i class="fas fa-play"></i>
                                <span>Take Quiz</span>
                            </a>
                        @endif
                    </div>
                </div>
                
                @if(!$quiz)
                    <div class="p-6 text-gray-500 text-center bg-gray-50">
                        <i class="fas fa-info-circle mr-2"></i>
                        No quiz available for this lecture.
                    </div>
                @endif
            </div>

            {{-- Discussion Forum Section --}}
            @if($forum)
                <x-discussion-forum :forum="$forum" :course="$course" />
            @else
                <div class="resource-card">
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h3>Discussion Forum Not Available</h3>
                        <p>The discussion forum for this lecture is not yet set up.</p>
                    </div>
                </div>
            @endif

            {{-- Ask Questions Form --}}
            <div class="question-form">
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <label for="question" class="block text-gray-700 font-semibold mb-3">
                        Ask a Question to your instructor
                    </label>
                    <input type="text" id="question" name="question"
                           class="form-input mb-4"
                           placeholder="Type your question here...">

                    {{-- Hidden fields --}}
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="module_number" value="{{ $moduleNumber }}">

                    <button type="submit" class="btn-teal">
                        <i class="fas fa-paper-plane"></i>
                        <span>Post</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>
    <script>
        function toggleVideo() {
            const playerWrapper = document.getElementById('videoPlayer');
            const toggleBtn = document.getElementById('videoToggleBtn');
            const toggleIcon = document.getElementById('videoToggleIcon');
            const toggleText = document.getElementById('videoToggleText');
            
            const isHidden = playerWrapper.classList.contains('hidden');
            
            if (isHidden) {
                playerWrapper.classList.remove('hidden');
                toggleIcon.className = 'fas fa-eye-slash';
                toggleText.textContent = 'Hide Video';
            } else {
                playerWrapper.classList.add('hidden');
                toggleIcon.className = 'fas fa-eye';
                toggleText.textContent = 'View Video';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const player = document.getElementById('mux-player');
            if (!player) return;

            let lastSavedProgress = 0;

            player.addEventListener('timeupdate', async function () {
                const progressPercent = (player.currentTime / player.duration) * 100;

                if (progressPercent - lastSavedProgress >= 10) {
                    lastSavedProgress = progressPercent;

                    try {
                        await fetch('{{ route("video.progress.save") }}', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                course_id: {{ $course->id }},
                                resource_id: {{ $resource->id }},
                                progress_percent: progressPercent
                            })
                        });
                    } catch (error) {
                        console.error('Failed to save progress:', error);
                    }
                }
            });

            player.addEventListener('ended', async function () {
                await fetch('{{ route("video.progress.save") }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        course_id: {{ $course->id }},
                        resource_id: {{ $resource->id }},
                        progress_percent: 100
                    })
                });
            });
        });
    </script>
</body>
</html>