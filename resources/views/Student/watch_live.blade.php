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
            width: 100%; height: 100%; object-fit: cover;
            border-radius: 16px; background: #0f172a; display: block;
        }
        .stat-pill { background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); }

        /* Sidebar */
        #sidebar {
            width: 320px; min-width: 320px; background: #111827;
            border-left: 1px solid #1f2937; display: flex; flex-direction: column;
            height: calc(100vh - 53px);
        }
        .tab-btn { flex: 1; padding: 0.75rem; font-size: 0.8rem; font-weight: 600;
            color: #6b7280; background: transparent; border: none; border-bottom: 2px solid transparent;
            cursor: pointer; transition: all 0.2s; }
        .tab-btn.active { color: #14b8a6; border-bottom-color: #14b8a6; }
        .tab-pane { display: none; flex: 1; overflow-y: auto; flex-direction: column; }
        .tab-pane.active { display: flex; }

        /* Chat */
        #chat-messages { flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .chat-msg { background: #1f2937; border-radius: 10px; padding: 0.6rem 0.8rem; font-size: 0.82rem; }
        .chat-msg .sender { font-weight: 700; color: #14b8a6; margin-bottom: 0.2rem; font-size: 0.75rem; }
        .chat-msg.own { background: #134e4a; }
        .chat-msg.instructor { background: #1e3a5f; border-left: 3px solid #3b82f6; }
        .chat-msg.system { background: transparent; color: #6b7280; font-size: 0.75rem; text-align: center; }

        /* Connecting overlay */
        #connecting-overlay {
            position: absolute; inset: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            background: rgba(3,7,18,0.92); border-radius: 16px; z-index: 10;
        }

        /* Unmute btn */
        #unmute-btn {
            position: absolute; bottom: 70px; right: 16px; z-index: 20;
            background: rgba(0,0,0,0.75); border: 1px solid #4b5563; color: white;
            padding: 0.45rem 0.9rem; border-radius: 8px; font-size: 0.78rem;
            font-weight: 600; cursor: pointer; display: none; gap: 0.4rem; align-items: center;
        }

        /* Raise hand btn active state */
        #hand-btn.raised { background: #d97706 !important; border-color: #d97706 !important; }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Top bar -->
    <div class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between" style="height:53px;">
        <div class="flex items-center gap-3">
            @if($session->status === 'live')
                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-600 rounded-full text-xs font-bold animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-white"></span> LIVE
                </span>
            @elseif($session->status === 'ended')
                <span class="flex items-center gap-1.5 px-2.5 py-1 bg-teal-700 rounded-full text-xs font-bold">
                    <i class="fas fa-play text-xs"></i> Recording
                </span>
            @endif
            <span class="text-gray-300 font-medium text-sm">{{ $session->title ?? 'Session ' . $session_number }}</span>
        </div>
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-sm transition-all">
            <i class="fas fa-arrow-left text-xs"></i> Back
        </a>
    </div>

    @if($session->status === 'live')

    <!-- Main layout -->
    <div style="display:flex; height:calc(100vh - 53px);">

        <!-- Video area -->
        <div style="flex:1; padding:1.25rem; display:flex; flex-direction:column; gap:1rem; overflow:hidden;">

            <div class="relative" style="flex:1;">
                <video id="remote-video" autoplay playsinline muted></video>

                <!-- Unmute button -->
                <button id="unmute-btn" onclick="unmuteVideo()">
                    <i class="fas fa-volume-mute"></i> Click to unmute
                </button>

                <!-- Connecting overlay -->
                <div id="connecting-overlay">
                    <div class="w-14 h-14 rounded-full border-4 border-teal-500 border-t-transparent animate-spin mb-4"></div>
                    <p id="connect-status" class="text-white font-semibold">Connecting to live stream...</p>
                    <p class="text-gray-400 text-xs mt-1">Please wait</p>
                </div>

                <!-- Student controls overlay -->
                <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-3" id="student-controls" style="display:none!important;">
                    <button onclick="toggleMic()" id="mic-btn"
                            class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all" title="Mute/Unmute mic">
                        <i id="mic-icon" class="fas fa-microphone text-sm"></i>
                    </button>
                    <button onclick="toggleScreenShare()" id="screen-btn"
                            class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all" title="Share Screen">
                        <i id="screen-icon" class="fas fa-desktop text-sm"></i>
                    </button>
                    <button onclick="toggleHand()" id="hand-btn"
                            class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all" title="Raise Hand">
                        <i class="fas fa-hand-paper text-sm"></i>
                    </button>
                </div>
            </div>

            <!-- Session info -->
            <div class="bg-gray-900 rounded-xl p-3 flex items-center gap-3 border border-gray-800">
                <div class="w-8 h-8 bg-teal-700 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-video text-white text-xs"></i>
                </div>
                <div>
                    <p class="font-semibold text-white text-sm">{{ $session->title ?? 'Session ' . $session_number }}</p>
                    @if($session->date)
                        <p class="text-gray-400 text-xs">
                            {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                            @if($session->start_time) · {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }} @endif
                            @if($session->duration_minutes) · {{ $session->duration_minutes }} mins @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div id="sidebar">
            <div style="display:flex; border-bottom:1px solid #1f2937;">
                <button class="tab-btn active" onclick="switchTab('chat', this)">
                    <i class="fas fa-comments mr-1"></i> Chat
                </button>
            </div>

            <!-- Chat pane -->
            <div id="tab-chat" class="tab-pane active">
                <div id="chat-messages"></div>
                <div style="padding:0.75rem; border-top:1px solid #1f2937; display:flex; flex-direction:column; gap:0.5rem;">
                    <!-- Raise hand button in chat area -->
                    <button onclick="toggleHand()" id="hand-chat-btn"
                            style="width:100%; padding:0.5rem; background:#1f2937; border:1px solid #374151;
                                   border-radius:8px; color:#d1d5db; font-size:0.82rem; font-weight:600; cursor:pointer;">
                        ✋ Raise Hand
                    </button>
                    <div style="display:flex; gap:0.5rem;">
                        <input id="chat-input" type="text" placeholder="Send a message..."
                               style="flex:1; background:#1f2937; border:1px solid #374151; border-radius:8px;
                                      padding:0.5rem 0.75rem; color:white; font-size:0.85rem; outline:none;"
                               onkeydown="if(event.key==='Enter') sendChat()">
                        <button onclick="sendChat()"
                                style="padding:0.5rem 0.9rem; background:#0d9488; border:none; border-radius:8px;
                                       color:white; font-size:0.85rem; cursor:pointer;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif($session->status === 'ended' && $session->recording_url)
    <div class="max-w-5xl mx-auto px-4 py-5">
        <div class="bg-gray-900 rounded-2xl overflow-hidden border border-gray-800">
            <video controls class="w-full rounded-2xl" style="max-height:580px;" src="{{ $session->recording_url }}">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    @elseif($session->status === 'ended')
    <div class="max-w-5xl mx-auto px-4 py-5">
        <div class="flex items-center justify-center h-80 bg-gray-900 rounded-2xl border border-gray-800">
            <div class="text-center space-y-3">
                <div class="w-16 h-16 bg-amber-900 rounded-2xl flex items-center justify-center mx-auto">
                    <i class="fas fa-hourglass-half text-2xl text-amber-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Recording is being processed</h3>
                <p class="text-gray-400 text-sm">Usually takes a few minutes. Please check back shortly.</p>
                <button onclick="window.location.reload()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm">
                    <i class="fas fa-sync text-xs"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    @else
    <div class="max-w-5xl mx-auto px-4 py-5">
        <div class="flex items-center justify-center h-80 bg-gray-900 rounded-2xl border border-gray-800">
            <div class="text-center space-y-3">
                <div class="w-16 h-16 bg-indigo-900 rounded-2xl flex items-center justify-center mx-auto">
                    <i class="fas fa-clock text-2xl text-indigo-400"></i>
                </div>
                <h3 class="text-lg font-bold text-white">Session hasn't started yet</h3>
                @if($session->date && $session->start_time)
                    <p class="text-gray-400 text-sm">Scheduled for
                        <span class="text-white font-semibold">
                            {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                            at {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                        </span>
                    </p>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($session->status === 'live')
    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        const HOST_PEER_ID = "{{ $peerId }}";
        const MY_PEER_ID   = "viewer-{{ auth()->id() }}-" + Date.now();
        const MY_NAME      = "{{ auth()->user()->name }}";

        let dataConn, localMicStream, screenStream;
        let isMicOn = false, isSharingScreen = false, handRaised = false;

        const ICE = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'turn:openrelay.metered.ca:80', username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443', username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' }
            ]
        };

        // ── Tab switching ────────────────────────────────────────────────────
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
        }

        // ── Unmute video ─────────────────────────────────────────────────────
        function unmuteVideo() {
            document.getElementById('remote-video').muted = false;
            document.getElementById('unmute-btn').style.display = 'none';
        }

        // ── Chat ─────────────────────────────────────────────────────────────
        function sendChat() {
            const input = document.getElementById('chat-input');
            const text  = input.value.trim();
            if (!text || !dataConn?.open) return;
            input.value = '';
            const msg = { type: 'chat', sender: MY_NAME, text, isInstructor: false };
            dataConn.send(msg);
            appendChat(msg, true);
        }

        function appendChat(msg, own = false) {
            const div = document.getElementById('chat-messages');
            const el  = document.createElement('div');
            if (msg.type === 'system') {
                el.className = 'chat-msg system';
                el.textContent = msg.text;
            } else {
                el.className = 'chat-msg' + (own ? ' own' : '') + (msg.isInstructor ? ' instructor' : '');
                el.innerHTML = `<div class="sender">${msg.isInstructor ? '👨‍🏫 ' : ''}${msg.sender}</div>${msg.text}`;
            }
            div.appendChild(el);
            div.scrollTop = div.scrollHeight;
        }

        // ── Raise hand ───────────────────────────────────────────────────────
        function toggleHand() {
            if (!dataConn?.open) return;
            handRaised = !handRaised;

            dataConn.send({ type: handRaised ? 'raise_hand' : 'lower_hand', name: MY_NAME });

            const btn     = document.getElementById('hand-chat-btn');
            const btnIcon = document.getElementById('hand-btn');

            if (handRaised) {
                btn.innerHTML   = '✋ Hand Raised — Click to Lower';
                btn.style.background = '#92400e';
                btn.style.borderColor = '#d97706';
                btn.style.color = '#fde68a';
                if (btnIcon) btnIcon.classList.add('raised');
            } else {
                btn.innerHTML   = '✋ Raise Hand';
                btn.style.background = '#1f2937';
                btn.style.borderColor = '#374151';
                btn.style.color = '#d1d5db';
                if (btnIcon) btnIcon.classList.remove('raised');
            }
        }

        // ── Mic toggle ───────────────────────────────────────────────────────
        async function toggleMic() {
            if (!isMicOn) {
                try {
                    localMicStream = await navigator.mediaDevices.getUserMedia({ audio: true });
                    isMicOn = true;
                    document.getElementById('mic-icon').className = 'fas fa-microphone text-sm text-teal-400';
                } catch (err) {
                    console.error('Mic error:', err);
                }
            } else {
                if (localMicStream) localMicStream.getTracks().forEach(t => t.stop());
                isMicOn = false;
                document.getElementById('mic-icon').className = 'fas fa-microphone-slash text-sm text-red-400';
            }
        }

        // ── Screen share ─────────────────────────────────────────────────────
        async function toggleScreenShare() {
            if (!isSharingScreen) {
                try {
                    screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });
                    isSharingScreen = true;
                    document.getElementById('screen-icon').className = 'fas fa-desktop text-sm text-teal-400';
                    screenStream.getVideoTracks()[0].onended = () => stopScreenShare();
                } catch (err) {
                    console.error('Screen share error:', err);
                }
            } else {
                stopScreenShare();
            }
        }

        function stopScreenShare() {
            if (screenStream) screenStream.getTracks().forEach(t => t.stop());
            isSharingScreen = false;
            document.getElementById('screen-icon').className = 'fas fa-desktop text-sm';
        }

        // ── PeerJS ───────────────────────────────────────────────────────────
        const peer = new Peer(MY_PEER_ID, {
            host: '0.peerjs.com', port: 443, secure: true, path: '/', config: ICE
        });

        peer.on('open', () => {
            document.getElementById('connect-status').textContent = 'Joined! Waiting for stream...';

            // Open data connection to host (signals we want the stream)
            dataConn = peer.connect(HOST_PEER_ID, { metadata: { name: MY_NAME } });

            dataConn.on('open', () => {
                console.log('Data connection open');
                dataConn.send('ready');
            });

            dataConn.on('data', (data) => {
                if (data.type === 'chat') {
                    appendChat(data);
                } else if (data.type === 'system') {
                    appendChat({ type: 'system', text: data.text });
                } else if (data.type === 'hand_lowered') {
                    // Instructor lowered our hand
                    handRaised = false;
                    const btn = document.getElementById('hand-chat-btn');
                    btn.innerHTML   = '✋ Raise Hand';
                    btn.style.background = '#1f2937';
                    btn.style.borderColor = '#374151';
                    btn.style.color = '#d1d5db';
                    appendChat({ type: 'system', text: 'Your hand was lowered by the instructor' });
                }
            });

            dataConn.on('error', (err) => {
                console.error('Data conn error:', err);
            });
        });

        // Host calls us with the video stream
        peer.on('call', (call) => {
            call.answer(); // no stream from student side

            call.on('stream', (remoteStream) => {
                const video = document.getElementById('remote-video');
                const newStream = new MediaStream();
                remoteStream.getTracks().forEach(t => newStream.addTrack(t));
                video.srcObject = newStream;
                video.muted = true;

                video.play()
                    .then(() => {
                        document.getElementById('connecting-overlay').style.display = 'none';
                        document.getElementById('unmute-btn').style.display = 'flex';
                    })
                    .catch(() => {
                        document.getElementById('connecting-overlay').innerHTML = `
                            <div style="text-align:center;">
                                <p style="color:#9ca3af;margin-bottom:1rem;font-size:0.9rem;">Click to start watching</p>
                                <button onclick="
                                    const v=document.getElementById('remote-video');
                                    v.muted=true;
                                    v.play().then(()=>{
                                        this.closest('#connecting-overlay').style.display='none';
                                        document.getElementById('unmute-btn').style.display='flex';
                                    });"
                                    style="padding:1rem 2rem;background:#0d9488;color:white;border:none;border-radius:12px;font-size:1rem;font-weight:600;cursor:pointer;">
                                    <i class='fas fa-play' style='margin-right:0.5rem;'></i> Watch Live
                                </button>
                            </div>`;
                    });
            });

            call.on('close', () => {
                const overlay = document.getElementById('connecting-overlay');
                overlay.style.display = 'flex';
                overlay.innerHTML = `
                    <div style="text-align:center;">
                        <div style="font-size:2.5rem;margin-bottom:1rem;">📴</div>
                        <p style="color:white;font-weight:700;font-size:1.1rem;">Stream has ended</p>
                        <p style="color:#9ca3af;font-size:0.85rem;margin-top:0.5rem;">The recording will be available shortly. Refresh the page to check.</p>
                        <button onclick="window.location.reload()"
                                style="margin-top:1rem;padding:0.6rem 1.5rem;background:#0d9488;color:white;border:none;border-radius:10px;font-size:0.9rem;font-weight:600;cursor:pointer;">
                            Refresh
                        </button>
                    </div>`;
            });
        });

        peer.on('error', (err) => {
            if (err.type === 'peer-unavailable') {
                document.getElementById('connect-status').textContent = 'Stream not started yet. Retrying...';
                setTimeout(() => window.location.reload(), 5000);
            } else {
                document.getElementById('connect-status').textContent = 'Connection failed. Refresh to retry.';
                console.error('Peer error:', err);
            }
        });
    </script>
    @endif

</body>
</html>