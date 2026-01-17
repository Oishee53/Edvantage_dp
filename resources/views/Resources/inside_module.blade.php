<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecture Resources - {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-5xl">
        {{-- Header --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <h1 class="text-2xl font-semibold text-gray-900 mb-3">{{ $course->name }}</h1>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-book-open mr-3 text-gray-400"></i>
                <span class="text-base">Lecture {{ $moduleNumber }}</span>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @auth
                {{-- Video Section --}}
                @if($resource->videos)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-play text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">Video Content</h2>
                                        <p class="text-sm text-gray-500">Watch the lecture video</p>
                                    </div>
                                </div>
                                <button 
                                    onclick="toggleVideo()" 
                                    id="videoToggleBtn"
                                    class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-eye" id="videoToggleIcon"></i>
                                    <span id="videoToggleText">View Video</span>
                                </button>
                            </div>
                        </div>

                        <div id="videoPlayer" class="p-6 hidden">
                            <div class="relative bg-black rounded-lg overflow-hidden">
                                <mux-player 
                                    id="mux-player"
                                    playback-id="{{ $resource->videos }}"
                                    stream-type="on-demand"
                                    controls
                                    class="w-full aspect-video">
                                </mux-player>
                            </div>
                            <div class="mt-4 text-sm text-gray-500 flex items-center bg-gray-50 p-3 rounded-lg">
                                <i class="fas fa-info-circle mr-2"></i>
                                Your progress is automatically saved as you watch
                            </div>
                        </div>
                    </div>
                @endif

                {{-- PDF Section --}}
                @if($resource->pdf)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="border-b border-gray-200 p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-file-pdf text-gray-600"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-semibold text-gray-900">PDF Document</h2>
                                        <p class="text-sm text-gray-500">Download or view the lecture PDF</p>
                                    </div>
                                </div>
                                <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>View PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                {{-- Guest message --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Authentication Required</h3>
                    <p class="text-gray-600">Please log in to access the video content and resources.</p>
                </div>
            @endauth

            {{-- Quiz Section --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="border-b border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-question-circle text-gray-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Lecture Quiz</h2>
                                <p class="text-sm text-gray-500">Test your knowledge</p>
                            </div>
                        </div>
                        @if($quiz)
                            <a href="{{ route('user.quiz.start', ['course' => $course->id, 'module' => $moduleNumber]) }}"
                               class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Discussion Forum Not Available</h3>
                    <p class="text-gray-600">The discussion forum for this lecture is not yet set up.</p>
                </div>
            @endif

            {{-- Ask Questions Form --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <form action="{{ route('questions.store') }}" method="POST">
                    @csrf
                    <label for="question" class="block text-gray-700 font-medium mb-2">Ask a Question</label>
                    <input type="text" id="question" name="question"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-gray-900 focus:outline-none">

                    {{-- Hidden fields --}}
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="module_number" value="{{ $moduleNumber }}">

                    <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg">
                        Post
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
