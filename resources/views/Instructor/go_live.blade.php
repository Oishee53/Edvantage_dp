<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Go Live - {{ $session->title ?? 'Session ' . $session_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #030712; }
        #local-video {
            width: 100%;
            height: 580px;
            object-fit: cover;
            border-radius: 16px;
            background: #0f172a;
            display: block;
        }
        .stat-pill {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Top bar -->
    <div class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-600 rounded-full text-xs font-bold animate-pulse">
                <span class="w-2 h-2 rounded-full bg-white"></span> LIVE
            </span>
            <span class="text-gray-300 font-medium text-sm">{{ $session->title ?? 'Session ' . $session_number }}</span>
        </div>
        <div class="flex items-center gap-3">
            <span id="viewer-count" class="text-gray-400 text-sm">
                <i class="fas fa-users mr-1"></i> <span id="viewer-num">0</span> watching
            </span>
            <span id="rec-indicator" class="hidden items-center gap-1.5 px-2.5 py-1 bg-red-900 border border-red-700 rounded-full text-xs font-semibold text-red-300">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping inline-block"></span> REC
            </span>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-5 space-y-4">

        <!-- Video -->
        <div class="relative">
            <video id="local-video" autoplay muted playsinline></video>

            <!-- Overlay controls -->
            <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-3">
                <button id="btn-mute" onclick="toggleMute()"
                        class="stat-pill w-12 h-12 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-all border border-gray-600">
                    <i id="mute-icon" class="fas fa-microphone"></i>
                </button>
                <button id="btn-video" onclick="toggleVideo()"
                        class="stat-pill w-12 h-12 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-all border border-gray-600">
                    <i id="video-icon" class="fas fa-video"></i>
                </button>
                <button id="end-stream-btn"
                        class="flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-full font-bold text-sm transition-all">
                    <i class="fas fa-stop-circle"></i> End Stream
                </button>
            </div>
        </div>

        <!-- Status bar -->
        <div class="bg-gray-900 rounded-2xl p-4 flex items-center justify-between border border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-700 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chalkboard-teacher text-white text-sm"></i>
                </div>
                <div>
                    <p id="status-text" class="text-white font-semibold text-sm">Starting stream...</p>
                    <p class="text-gray-400 text-xs">Recording automatically · Students can join live</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-xs">Session</p>
                <p class="text-teal-400 font-mono text-sm">{{ $peerId }}</p>
            </div>
        </div>

    </div>

    <!-- Hidden end-stream form -->
    <form id="end-stream-form" method="POST"
          action="{{ route('instructor.live_session.end_stream', ['course' => $course_id, 'session' => $session_number]) }}"
          class="hidden">
        @csrf
    </form>

    <!-- PeerJS -->
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        const PEER_ID       = "{{ $peerId }}";
        const UPLOAD_URL    = "{{ route('live_session.upload_recording', ['course' => $course_id, 'session' => $session_number]) }}";
        const CSRF_TOKEN    = "{{ csrf_token() }}";

        let localStream;
        let peer;
        let mediaRecorder;
        let recordedChunks  = [];
        let connectedPeers  = {};
        let isMuted         = false;
        let isVideoOff      = false;
        let isEnding        = false;

        // ── 1. Get camera + mic ──────────────────────────────────────────────
        async function startStream() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: { width: 1280, height: 720 },
                    audio: true,
                });

                document.getElementById('local-video').srcObject = localStream;
                document.getElementById('status-text').textContent = 'You are live!';

                startRecording();
                initPeer();

            } catch (err) {
                document.getElementById('status-text').textContent = 'Camera/mic access denied.';
                console.error('getUserMedia error:', err);
            }
        }

        // ── 2. Start MediaRecorder ───────────────────────────────────────────
        function startRecording() {
            const mimeType = MediaRecorder.isTypeSupported('video/webm;codecs=vp9')
                ? 'video/webm;codecs=vp9'
                : 'video/webm';

            mediaRecorder = new MediaRecorder(localStream, { mimeType });

            mediaRecorder.ondataavailable = e => {
                if (e.data.size > 0) recordedChunks.push(e.data);
            };

            mediaRecorder.start(1000);
            document.getElementById('rec-indicator').classList.remove('hidden');
            document.getElementById('rec-indicator').classList.add('flex');
        }

        // ── 3. Init PeerJS (instructor is the host peer) ─────────────────────
        function initPeer() {
            peer = new Peer(PEER_ID, {
                host: '0.peerjs.com',
                port: 443,
                secure: true,
                path: '/',
                config: {
                    iceServers: [
                        { urls: 'stun:stun.l.google.com:19302' },
                        { urls: 'stun:stun1.l.google.com:19302' },
                    ]
                }
            });

            peer.on('open', (id) => {
                console.log('Peer opened as host:', id);
                document.getElementById('status-text').textContent = 'You are live! Students can now join.';
            });

            // When a student calls in, answer with our stream
            peer.on('call', (call) => {
                call.answer(localStream);
                connectedPeers[call.peer] = call;
                updateViewerCount();

                call.on('close', () => {
                    delete connectedPeers[call.peer];
                    updateViewerCount();
                });

                call.on('error', () => {
                    delete connectedPeers[call.peer];
                    updateViewerCount();
                });
            });

            peer.on('error', (err) => {
                console.error('Peer error:', err);
                if (err.type === 'unavailable-id') {
                    document.getElementById('status-text').textContent = 'Stream ID conflict. Please refresh.';
                }
            });
        }

        function updateViewerCount() {
            document.getElementById('viewer-num').textContent = Object.keys(connectedPeers).length;
        }

        // ── 4. Toggle controls ───────────────────────────────────────────────
        function toggleMute() {
            isMuted = !isMuted;
            localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
            document.getElementById('mute-icon').className = isMuted
                ? 'fas fa-microphone-slash text-red-400'
                : 'fas fa-microphone';
        }

        function toggleVideo() {
            isVideoOff = !isVideoOff;
            localStream.getVideoTracks().forEach(t => t.enabled = !isVideoOff);
            document.getElementById('video-icon').className = isVideoOff
                ? 'fas fa-video-slash text-red-400'
                : 'fas fa-video';
        }

        // ── 5. End stream ────────────────────────────────────────────────────
        document.getElementById('end-stream-btn').addEventListener('click', async () => {
            if (isEnding) return;
            if (!confirm('End the live stream? Recording will be uploaded automatically.')) return;

            isEnding = true;
            const btn = document.getElementById('end-stream-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            // Stop recording
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                await new Promise(resolve => {
                    mediaRecorder.onstop = resolve;
                    mediaRecorder.stop();
                });
            }

            // Stop local stream
            if (localStream) localStream.getTracks().forEach(t => t.stop());

            // Close all peer connections
            Object.values(connectedPeers).forEach(call => call.close());
            if (peer) peer.destroy();

            // Upload recording to Cloudinary
            if (recordedChunks.length > 0) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';
                try {
                    const blob     = new Blob(recordedChunks, { type: 'video/webm' });
                    const formData = new FormData();
                    formData.append('recording', blob, 'recording.webm');
                    formData.append('_token', CSRF_TOKEN);

                    const res    = await fetch(UPLOAD_URL, { method: 'POST', body: formData });
                    const result = await res.json();

                    if (result.success) {
                        console.log('Recording saved:', result.url);
                    } else {
                        console.error('Upload failed:', result.error);
                    }
                } catch (err) {
                    console.error('Upload error:', err);
                }
            }

            // End stream on server
            document.getElementById('end-stream-form').submit();
        });

        // Start everything
        startStream();
    </script>

</body>
</html>