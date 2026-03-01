<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $session->title ?? 'Session ' . $session_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background: #030712; }
        #remote-video {
            width: 100%;
            height: 580px;
            object-fit: cover;
            border-radius: 16px;
            background: #0f172a;
            display: block;
        }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Top bar -->
    <div class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            @if($session->status === 'live')
                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-600 rounded-full text-xs font-bold animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-white"></span> LIVE
                </span>
            @elseif($session->status === 'ended')
                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-teal-700 rounded-full text-xs font-bold">
                    <i class="fas fa-play text-xs"></i> Recording
                </span>
            @else
                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-gray-700 rounded-full text-xs font-bold">
                    <i class="fas fa-clock text-xs"></i> Upcoming
                </span>
            @endif
            <span class="text-gray-300 font-medium text-sm">{{ $session->title ?? 'Session ' . $session_number }}</span>
        </div>
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-sm transition-all">
            <i class="fas fa-arrow-left text-xs"></i> Back
        </a>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-5 space-y-4">

        @if($session->status === 'live')
            {{-- ── LIVE: Connect via PeerJS ── --}}
            <div class="relative">
                <video id="remote-video" autoplay playsinline></video>

                <!-- Connecting overlay -->
                <div id="connecting-overlay"
                     class="absolute inset-0 flex flex-col items-center justify-center bg-gray-950 bg-opacity-90 rounded-2xl">
                    <div class="w-14 h-14 rounded-full border-4 border-teal-500 border-t-transparent animate-spin mb-4"></div>
                    <p id="connect-status" class="text-white font-semibold">Connecting to live stream...</p>
                    <p class="text-gray-400 text-xs mt-1">Please wait</p>
                </div>
            </div>

        @elseif($session->status === 'ended' && $session->recording_url)
            {{-- ── ENDED: Video player ── --}}
            <div class="bg-gray-900 rounded-2xl overflow-hidden border border-gray-800">
                <video controls
                       class="w-full rounded-2xl"
                       style="max-height: 580px;"
                       src="{{ $session->recording_url }}">
                    Your browser does not support the video tag.
                </video>
            </div>

        @elseif($session->status === 'ended' && !$session->recording_url)
            {{-- ── ENDED, recording processing ── --}}
            <div class="flex items-center justify-center h-80 bg-gray-900 rounded-2xl border border-gray-800">
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 bg-amber-900 rounded-2xl flex items-center justify-center mx-auto">
                        <i class="fas fa-hourglass-half text-2xl text-amber-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Recording is being processed</h3>
                    <p class="text-gray-400 text-sm">Usually takes a few minutes. Please check back shortly.</p>
                    <button onclick="window.location.reload()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm transition-all">
                        <i class="fas fa-sync text-xs"></i> Refresh
                    </button>
                </div>
            </div>

        @else
            {{-- ── NOT STARTED YET ── --}}
            <div class="flex items-center justify-center h-80 bg-gray-900 rounded-2xl border border-gray-800">
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 bg-indigo-900 rounded-2xl flex items-center justify-center mx-auto">
                        <i class="fas fa-clock text-2xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Session hasn't started yet</h3>
                    @if($session->date && $session->start_time)
                        <p class="text-gray-400 text-sm">
                            Scheduled for
                            <span class="text-white font-semibold">
                                {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                                at {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Session info -->
        <div class="bg-gray-900 rounded-2xl p-4 border border-gray-800">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-teal-700 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-video text-white text-sm"></i>
                </div>
                <div>
                    <p class="font-semibold text-white text-sm">{{ $session->title ?? 'Session ' . $session_number }}</p>
                    @if($session->date)
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                            @if($session->start_time)
                                · {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                            @endif
                            @if($session->duration_minutes)
                                · {{ $session->duration_minutes }} mins
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @if($session->status === 'live')
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        const HOST_PEER_ID = "{{ $peerId }}";
        const MY_PEER_ID   = "viewer-{{ auth()->id() }}-" + Date.now();

        const peer = new Peer(MY_PEER_ID, {
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

        peer.on('open', () => {
            document.getElementById('connect-status').textContent = 'Joined! Waiting for stream...';

            // Call the host peer
            const call = peer.call(HOST_PEER_ID, new MediaStream());

            call.on('stream', (remoteStream) => {
                const video = document.getElementById('remote-video');
                video.srcObject = remoteStream;
                video.play();

                // Hide connecting overlay
                document.getElementById('connecting-overlay').style.display = 'none';
            });

            call.on('error', (err) => {
                document.getElementById('connect-status').textContent = 'Connection error. Please refresh.';
                console.error('Call error:', err);
            });

            call.on('close', () => {
                document.getElementById('connecting-overlay').style.display = 'flex';
                document.getElementById('connect-status').textContent = 'Stream ended.';
            });
        });

       peer.on('open', () => {
        document.getElementById('connect-status').textContent = 'Joined! Waiting for stream...';

        // ✅ Get a dummy stream so PeerJS negotiation works properly
        navigator.mediaDevices.getUserMedia({ video: false, audio: false })
            .catch(() => new MediaStream()) // silent fallback if denied
            .then((dummyStream) => {
                const call = peer.call(HOST_PEER_ID, dummyStream);

                call.on('stream', (remoteStream) => {
                    const video = document.getElementById('remote-video');
                    video.srcObject = remoteStream;
                    video.play();
                    document.getElementById('connecting-overlay').style.display = 'none';
                });

                call.on('error', (err) => {
                    document.getElementById('connect-status').textContent = 'Connection error. Please refresh.';
                    console.error('Call error:', err);
                });

                call.on('close', () => {
                    document.getElementById('connecting-overlay').style.display = 'flex';
                    document.getElementById('connect-status').textContent = 'Stream ended.';
                });
            });
    });
    </script>
    @endif

</body>
</html>