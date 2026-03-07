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
        .stat-pill { background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); }

        #video-stage {
            position: relative; flex: 1; border-radius: 16px; overflow: hidden;
            background: #0f172a;
        }

        /* Main feed */
        #main-video {
            width: 100%; height: 100%; object-fit: cover;
            display: block; border-radius: 16px;
        }

        /* PiP thumbnail — shows the OTHER real stream */
        #pip-video {
            position: absolute; bottom: 80px; right: 16px;
            width: 200px; height: 120px; object-fit: cover;
            border-radius: 10px; border: 2px solid rgba(255,255,255,0.25);
            cursor: pointer; display: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.6);
            transition: transform 0.15s, border-color 0.15s;
            z-index: 10; background: #0f172a;
        }
        #pip-video:hover { transform: scale(1.04); border-color: #14b8a6; }

        #pip-label {
            position: absolute; bottom: 200px; right: 16px;
            background: rgba(0,0,0,0.7); color: #d1d5db;
            font-size: 0.68rem; font-weight: 600; padding: 3px 9px;
            border-radius: 6px; display: none; z-index: 11;
            pointer-events: none;
        }

        /* Swap hint shown when hovering PiP */
        #pip-hint {
            position: absolute; bottom: 80px; right: 16px;
            width: 200px; height: 120px; border-radius: 10px;
            display: none; align-items: center; justify-content: center;
            z-index: 12; pointer-events: none;
        }
        #pip-video:hover ~ #pip-hint { display: flex; }
        #pip-hint span {
            background: rgba(0,0,0,0.6); color: white; font-size: 0.72rem;
            padding: 4px 10px; border-radius: 6px;
        }

        /* Connecting overlay */
        #connecting-overlay {
            position: absolute; inset: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            background: rgba(3,7,18,0.92); border-radius: 16px; z-index: 20;
        }

        /* Unmute button */
        #unmute-btn {
            position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%);
            z-index: 15; background: rgba(0,0,0,0.8); border: 1px solid #4b5563; color: white;
            padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.82rem;
            font-weight: 600; cursor: pointer; display: none; align-items: center; gap: 0.5rem;
        }

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

        #chat-messages { flex: 1; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.5rem; }
        .chat-msg { background: #1f2937; border-radius: 10px; padding: 0.6rem 0.8rem; font-size: 0.82rem; }
        .chat-msg .sender { font-weight: 700; color: #14b8a6; margin-bottom: 0.2rem; font-size: 0.75rem; }
        .chat-msg.own { background: #134e4a; }
        .chat-msg.instructor { background: #1e3a5f; border-left: 3px solid #3b82f6; }
        .chat-msg.system { background: transparent; color: #6b7280; font-size: 0.75rem; text-align: center; }
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
                <span id="timer-display" class="text-white text-sm font-mono font-bold"></span>
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

    <div style="display:flex; height:calc(100vh - 53px);">

        <!-- Video area -->
        <div style="flex:1; padding:1.25rem; display:flex; flex-direction:column; gap:1rem; overflow:hidden;">
            <div id="video-stage" style="flex:1;">

                <!-- Main feed video element -->
                <video id="main-video" autoplay playsinline muted></video>

                <!-- PiP: the OTHER stream (camera or screen) -->
                <video id="pip-video" autoplay playsinline muted onclick="studentSwap()"></video>
                <div id="pip-label"></div>
                <div id="pip-hint"><span><i class="fas fa-exchange-alt mr-1"></i> Click to swap</span></div>

                <!-- Unmute -->
                <button id="unmute-btn" onclick="unmuteAll()">
                    <i class="fas fa-volume-mute"></i> Click to unmute
                </button>

                <!-- Connecting overlay -->
                <div id="connecting-overlay">
                    <div class="w-14 h-14 rounded-full border-4 border-teal-500 border-t-transparent animate-spin mb-4"></div>
                    <p id="connect-status" class="text-white font-semibold">Connecting to live stream...</p>
                    <p class="text-gray-400 text-xs mt-1">Please wait</p>
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
            <div id="tab-chat" class="tab-pane active">
                <div id="chat-messages"></div>
                <div style="padding:0.75rem; border-top:1px solid #1f2937; display:flex; flex-direction:column; gap:0.5rem;">
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
            <video controls class="w-full rounded-2xl" style="max-height:580px;" src="{{ $session->recording_url }}"></video>
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

        // ── Timer ─────────────────────────────────────────────────────────────
        const DURATION_SECONDS = {{ ($session->duration_minutes ?? 60) * 60 }};
        let secondsLeft  = DURATION_SECONDS;
        let timerStarted = false;
        let timerInterval;

        function startTimer() {
            if (timerStarted) return;
            timerStarted = true;
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                secondsLeft--;
                updateTimerDisplay();
                if (secondsLeft === 300) appendChat({ type:'system', text:'⚠️ 5 minutes remaining' });
                if (secondsLeft === 60)  appendChat({ type:'system', text:'⚠️ 1 minute remaining' });
                if (secondsLeft <= 0)  { clearInterval(timerInterval); appendChat({ type:'system', text:'⏰ Session time is up.' }); }
            }, 1000);
        }

        function updateTimerDisplay() {
            const h = Math.floor(secondsLeft / 3600);
            const m = Math.floor((secondsLeft % 3600) / 60);
            const s = secondsLeft % 60;
            const el = document.getElementById('timer-display');
            if (!el) return;
            el.textContent = h > 0
                ? `${h}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`
                : `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
            el.style.color = secondsLeft <= 300 ? '#ef4444' : secondsLeft <= 600 ? '#f59e0b' : '#ffffff';
        }

        // ── Stream state ──────────────────────────────────────────────────────
        // Two separate MediaStreams received from instructor
        let cameraStream = null;   // feed: 'camera'
        let screenStream = null;   // feed: 'screen'

        // Which feed is currently in main vs pip
        // 'camera' | 'screen'
        let mainFeed = 'camera';

        const mainVideo = document.getElementById('main-video');
        const pipVideo  = document.getElementById('pip-video');
        const pipLabel  = document.getElementById('pip-label');

        function applyLayout() {
            // Only show PiP when both streams exist
            if (!cameraStream || !screenStream) {
                // Just show whatever we have in main
                mainVideo.srcObject = cameraStream || screenStream;
                pipVideo.style.display = 'none';
                pipLabel.style.display = 'none';
                return;
            }

            if (mainFeed === 'screen') {
                mainVideo.srcObject = screenStream;
                pipVideo.srcObject  = cameraStream;
                pipLabel.textContent = '📷 Camera';
            } else {
                mainVideo.srcObject = cameraStream;
                pipVideo.srcObject  = screenStream;
                pipLabel.textContent = '🖥 Screen';
            }

            pipVideo.style.display = 'block';
            pipLabel.style.display = 'block';

            // Re-play both (autoplay may need nudge after srcObject change)
            [mainVideo, pipVideo].forEach(v => { if (v.paused) v.play().catch(()=>{}); });
        }

        // Student clicks PiP to swap main ↔ pip
        function studentSwap() {
            mainFeed = mainFeed === 'screen' ? 'camera' : 'screen';
            applyLayout();
        }

        // ── Other ─────────────────────────────────────────────────────────────
        let dataConn, handRaised = false;
        let overlayHidden = false;

        const ICE = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'turn:openrelay.metered.ca:80',                username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443',               username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' }
            ]
        };

        function switchTab(name, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
        }

        function unmuteAll() {
            mainVideo.muted = false;
            pipVideo.muted  = false;
            document.getElementById('unmute-btn').style.display = 'none';
        }

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

        function toggleHand() {
            if (!dataConn?.open) return;
            handRaised = !handRaised;
            dataConn.send({ type: handRaised ? 'raise_hand' : 'lower_hand', name: MY_NAME });
            const btn = document.getElementById('hand-chat-btn');
            if (handRaised) {
                btn.innerHTML = '✋ Hand Raised — Click to Lower';
                btn.style.cssText += ';background:#92400e;border-color:#d97706;color:#fde68a;';
            } else {
                btn.innerHTML = '✋ Raise Hand';
                btn.style.cssText += ';background:#1f2937;border-color:#374151;color:#d1d5db;';
            }
        }

        function tryHideOverlay() {
            if (overlayHidden) return;
            overlayHidden = true;
            document.getElementById('connecting-overlay').style.display = 'none';
            document.getElementById('unmute-btn').style.display = 'flex';
        }

        // ── PeerJS ───────────────────────────────────────────────────────────
        const peer = new Peer(MY_PEER_ID, {
            host: '0.peerjs.com', port: 443, secure: true, path: '/', config: ICE
        });

        peer.on('open', () => {
            document.getElementById('connect-status').textContent = 'Joined! Waiting for stream...';

            dataConn = peer.connect(HOST_PEER_ID, { metadata: { name: MY_NAME } });
            dataConn.on('open', () => dataConn.send('ready'));

            dataConn.on('data', (data) => {
                if (data.type === 'chat') {
                    appendChat(data);
                } else if (data.type === 'system') {
                    appendChat({ type: 'system', text: data.text });
                } else if (data.type === 'timer_sync') {
                    secondsLeft = data.secondsLeft;
                    updateTimerDisplay();
                    startTimer();
                } else if (data.type === 'screen_share_started') {
                    // Instructor started sharing — adopt their initial layout
                    mainFeed = data.mainFeed || 'screen';
                    appendChat({ type: 'system', text: '🖥️ Instructor started screen sharing' });
                    // screen call will arrive separately via peer.on('call')
                } else if (data.type === 'screen_share_stopped') {
                    screenStream = null;
                    mainFeed = 'camera';
                    applyLayout();
                    appendChat({ type: 'system', text: '📷 Instructor stopped screen sharing' });
                } else if (data.type === 'layout_swap') {
                    // Instructor swapped their own view — mirror it
                    mainFeed = data.mainFeed;
                    applyLayout();
                } else if (data.type === 'stream_ended') {
                    showEndedOverlay();
                } else if (data.type === 'hand_lowered') {
                    handRaised = false;
                    const btn = document.getElementById('hand-chat-btn');
                    btn.innerHTML = '✋ Raise Hand';
                    btn.style.cssText += ';background:#1f2937;border-color:#374151;color:#d1d5db;';
                    appendChat({ type: 'system', text: 'Your hand was lowered by the instructor' });
                }
            });
        });

        // ── Receive calls from instructor ─────────────────────────────────────
        // Instructor sends two separate calls: one with metadata.feed='camera', one with 'screen'
        peer.on('call', (call) => {
            call.answer(); // no stream from student side

            const feed = call.metadata?.feed || 'camera';

            call.on('stream', (stream) => {
                if (feed === 'camera') {
                    cameraStream = stream;
                } else {
                    screenStream = stream;
                }
                applyLayout();

                // Try to play and hide connecting overlay
                mainVideo.play()
                    .then(() => tryHideOverlay())
                    .catch(() => {
                        // Autoplay blocked — show manual start button
                        if (!overlayHidden) {
                            document.getElementById('connecting-overlay').innerHTML = `
                                <div style="text-align:center;">
                                    <p style="color:#9ca3af;margin-bottom:1rem;font-size:0.9rem;">Click to start watching</p>
                                    <button onclick="
                                        document.getElementById('main-video').muted=true;
                                        document.getElementById('main-video').play().then(()=>{
                                            document.getElementById('connecting-overlay').style.display='none';
                                            document.getElementById('unmute-btn').style.display='flex';
                                        });"
                                        style="padding:1rem 2rem;background:#0d9488;color:white;border:none;border-radius:12px;font-size:1rem;font-weight:600;cursor:pointer;">
                                        <i class='fas fa-play' style='margin-right:0.5rem;'></i> Watch Live
                                    </button>
                                </div>`;
                        }
                    });
            });

            call.on('close', () => {
                if (feed === 'camera') {
                    cameraStream = null;
                    showEndedOverlay();
                } else {
                    screenStream = null;
                    mainFeed = 'camera';
                    applyLayout();
                }
            });
        });

        function showEndedOverlay() {
            const overlay = document.getElementById('connecting-overlay');
            overlay.style.display = 'flex';
            overlay.innerHTML = `
                <div style="text-align:center;">
                    <div style="font-size:2.5rem;margin-bottom:1rem;">📴</div>
                    <p style="color:white;font-weight:700;font-size:1.1rem;">Stream has ended</p>
                    <p style="color:#9ca3af;font-size:0.85rem;margin-top:0.5rem;">The recording will be available shortly.</p>
                    <button onclick="window.location.reload()"
                            style="margin-top:1rem;padding:0.6rem 1.5rem;background:#0d9488;color:white;border:none;border-radius:10px;font-size:0.9rem;font-weight:600;cursor:pointer;">
                        Refresh
                    </button>
                </div>`;
        }

        peer.on('error', (err) => {
            if (err.type === 'peer-unavailable') {
                document.getElementById('connect-status').textContent = 'Stream not started yet. Retrying...';
                setTimeout(() => window.location.reload(), 5000);
            } else {
                document.getElementById('connect-status').textContent = 'Connection failed. Refresh to retry.';
                console.error(err);
            }
        });
    </script>
    @endif

</body>
</html>