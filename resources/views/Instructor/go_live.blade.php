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
        .stat-pill { background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); }

        #video-stage {
            position: relative; flex: 1; border-radius: 16px; overflow: hidden;
            background: #0f172a;
        }

        #main-video {
            width: 100%; height: 100%; object-fit: cover;
            display: block; border-radius: 16px;
        }

        /* PiP thumbnail */
        #pip-video {
            position: absolute; bottom: 80px; right: 16px;
            width: 200px; height: 120px; object-fit: cover;
            border-radius: 10px; border: 2px solid rgba(255,255,255,0.25);
            cursor: pointer; display: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.6);
            transition: transform 0.15s, border-color 0.15s;
            z-index: 10;
            background: #0f172a;
        }
        #pip-video:hover { transform: scale(1.04); border-color: #14b8a6; }

        #pip-label {
            position: absolute; bottom: 200px; right: 16px;
            background: rgba(0,0,0,0.7); color: #d1d5db;
            font-size: 0.68rem; font-weight: 600; padding: 3px 9px;
            border-radius: 6px; display: none; z-index: 11;
            pointer-events: none; letter-spacing: 0.02em;
        }

        #pip-hint {
            position: absolute; bottom: 80px; right: 16px;
            width: 200px; height: 120px;
            border-radius: 10px; z-index: 12;
            display: none; align-items: center; justify-content: center;
            pointer-events: none;
            background: rgba(0,0,0,0.0);
        }
        #pip-video:hover ~ #pip-hint { display: flex; }
        #pip-hint span {
            background: rgba(0,0,0,0.6); color: white; font-size: 0.72rem;
            padding: 4px 10px; border-radius: 6px;
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
        .chat-msg.system { background: transparent; color: #6b7280; font-size: 0.75rem; text-align: center; }

        .hand-item { display: flex; align-items: center; justify-content: space-between;
            padding: 0.75rem 1rem; border-bottom: 1px solid #1f2937; font-size: 0.85rem; }
        .lower-btn { font-size: 0.75rem; padding: 0.3rem 0.7rem; background: #374151;
            color: #d1d5db; border: none; border-radius: 6px; cursor: pointer; }
        .lower-btn:hover { background: #ef4444; color: white; }

        #toast { position: fixed; top: 70px; right: 1rem; z-index: 999;
            background: #1f2937; border: 1px solid #374151; border-radius: 12px;
            padding: 0.75rem 1rem; font-size: 0.85rem; color: white;
            display: none; align-items: center; gap: 0.5rem; box-shadow: 0 8px 24px rgba(0,0,0,0.4); }
    </style>
</head>
<body class="min-h-screen text-white">

    <!-- Top bar -->
    <div class="bg-gray-900 border-b border-gray-800 px-6 py-3 flex items-center justify-between" style="height:53px;">
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5 px-2.5 py-1 bg-red-600 rounded-full text-xs font-bold animate-pulse">
                <span class="w-2 h-2 rounded-full bg-white"></span> LIVE
            </span>
            <span id="timer-display" class="text-white text-sm font-mono font-bold"></span>
            <span class="text-gray-300 font-medium text-sm">{{ $session->title ?? 'Session ' . $session_number }}</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-gray-400 text-sm"><i class="fas fa-users mr-1"></i><span id="viewer-num">0</span> watching</span>
            <span id="rec-indicator" class="hidden items-center gap-1.5 px-2.5 py-1 bg-red-900 border border-red-700 rounded-full text-xs font-semibold text-red-300">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping inline-block"></span> REC
            </span>
        </div>
    </div>

    <div id="toast">
        <span>✋</span><span id="toast-text"></span>
        <button onclick="document.getElementById('toast').style.display='none'"
                style="margin-left:0.5rem;background:none;border:none;color:#9ca3af;cursor:pointer;">✕</button>
    </div>

    <div style="display:flex; height:calc(100vh - 53px);">

        <!-- Video area -->
        <div style="flex:1; padding:1.25rem; display:flex; flex-direction:column; gap:1rem; overflow:hidden;">
            <div id="video-stage" style="flex:1;">

                <video id="main-video" autoplay muted playsinline></video>

                <!-- PiP: only shown when screen sharing is active -->
                <video id="pip-video" autoplay muted playsinline onclick="swapFeeds()"></video>
                <div id="pip-label"></div>
                <div id="pip-hint"><span><i class="fas fa-exchange-alt mr-1"></i> Click to swap</span></div>

                <!-- Controls overlay -->
                <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-3" style="z-index:20;">
                    <button onclick="toggleMute()" class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all">
                        <i id="mute-icon" class="fas fa-microphone text-sm"></i>
                    </button>
                    <button onclick="toggleVideo()" class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all">
                        <i id="video-icon" class="fas fa-video text-sm"></i>
                    </button>
                    <button onclick="toggleScreenShare()" id="screen-btn" class="stat-pill w-11 h-11 rounded-full flex items-center justify-center border border-gray-600 hover:bg-gray-700 transition-all" title="Share Screen">
                        <i id="screen-icon" class="fas fa-desktop text-sm"></i>
                    </button>
                    <button id="end-stream-btn"
                            class="flex items-center gap-2 px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-bold text-sm transition-all">
                        <i class="fas fa-stop-circle"></i> End Stream
                    </button>
                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-3 flex items-center justify-between border border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-teal-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-white text-xs"></i>
                    </div>
                    <div>
                        <p id="status-text" class="text-white font-semibold text-sm">Starting stream...</p>
                        <p class="text-gray-400 text-xs">Recording automatically</p>
                    </div>
                </div>
                <p class="text-teal-400 font-mono text-xs">{{ $peerId }}</p>
            </div>
        </div>

        <!-- Sidebar -->
        <div id="sidebar">
            <div style="display:flex; border-bottom:1px solid #1f2937;">
                <button class="tab-btn active" onclick="switchTab('chat', this)">
                    <i class="fas fa-comments mr-1"></i> Chat
                </button>
                <button class="tab-btn" onclick="switchTab('hands', this)" id="hands-tab-btn">
                    <i class="fas fa-hand-paper mr-1"></i> Hands
                    <span id="hand-count-badge" class="hidden ml-1 px-1.5 py-0.5 bg-amber-500 text-black text-xs rounded-full font-bold">0</span>
                </button>
            </div>

            <div id="tab-chat" class="tab-pane active">
                <div id="chat-messages"></div>
                <div style="padding:0.75rem; border-top:1px solid #1f2937; display:flex; gap:0.5rem;">
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

            <div id="tab-hands" class="tab-pane" style="flex-direction:column;">
                <div id="hands-list" style="flex:1; overflow-y:auto;">
                    <p id="no-hands" style="text-align:center; color:#6b7280; padding:2rem; font-size:0.85rem;">No raised hands</p>
                </div>
            </div>
        </div>
    </div>

    <form id="end-stream-form" method="POST"
          action="{{ route('instructor.live_session.end_stream', ['course' => $course_id, 'session' => $session_number]) }}"
          class="hidden">@csrf</form>

    <script src="https://unpkg.com/peerjs@1.5.2/dist/peerjs.min.js"></script>
    <script>
        const PEER_ID    = "{{ $peerId }}";
        const UPLOAD_URL = "{{ route('live_session.upload_recording', ['course' => $course_id, 'session' => $session_number]) }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const MY_NAME    = "{{ auth()->user()->name }}";

        let localStream, screenStream, peer, mediaRecorder;
        let recordedChunks = [];

        // Per-student: { camera: PeerCall, screen: PeerCall }
        let peerCalls = {};
        // Data connections keyed by student peerId
        let dataConns = {};
        let raisedHands = {};

        let isMuted = false, isVideoOff = false, isSharingScreen = false, isEnding = false;

        // ── PiP layout (instructor preview) ──────────────────────────────────
        // mainFeed: 'camera' | 'screen'
        let mainFeed = 'camera';
        const mainVideo = document.getElementById('main-video');
        const pipVideo  = document.getElementById('pip-video');
        const pipLabel  = document.getElementById('pip-label');
        const pipHint   = document.getElementById('pip-hint');

        function showPip() {
            pipVideo.style.display = 'block';
            pipLabel.style.display = 'block';
            refreshPipLabel();
        }
        function hidePip() {
            pipVideo.style.display = 'none';
            pipLabel.style.display = 'none';
        }
        function refreshPipLabel() {
            pipLabel.textContent = mainFeed === 'screen' ? '📷 Camera' : '🖥 Screen';
        }

        // Instructor clicks PiP to swap which feed is shown large
        function swapFeeds() {
            if (!isSharingScreen) return;
            if (mainFeed === 'screen') {
                mainVideo.srcObject = localStream;
                pipVideo.srcObject  = screenStream;
                mainFeed = 'camera';
            } else {
                mainVideo.srcObject = screenStream;
                pipVideo.srcObject  = localStream;
                mainFeed = 'screen';
            }
            refreshPipLabel();
            // Tell every student which feed is now "main" so they can mirror
            broadcast({ type: 'layout_swap', mainFeed });
        }

        // ── Timer ─────────────────────────────────────────────────────────────
        const DURATION_SECONDS = {{ ($session->duration_minutes ?? 60) * 60 }};
        let secondsLeft   = DURATION_SECONDS;
        let timerInterval = null;

        function startTimer() {
            updateTimerDisplay();
            timerInterval = setInterval(() => {
                secondsLeft--;
                updateTimerDisplay();
                if (secondsLeft === 300) { appendChat({ type:'system', text:'⚠️ 5 minutes remaining' }); broadcast({ type:'system', text:'⚠️ 5 minutes remaining' }); }
                if (secondsLeft === 60)  { appendChat({ type:'system', text:'⚠️ 1 minute remaining'  }); broadcast({ type:'system', text:'⚠️ 1 minute remaining'  }); }
                if (secondsLeft <= 0)   { clearInterval(timerInterval); autoEndStream(); }
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

        // ── ICE ───────────────────────────────────────────────────────────────
        const ICE = {
            iceServers: [
                { urls: 'stun:stun.l.google.com:19302' },
                { urls: 'stun:stun1.l.google.com:19302' },
                { urls: 'turn:openrelay.metered.ca:80',                username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443',               username: 'openrelayproject', credential: 'openrelayproject' },
                { urls: 'turn:openrelay.metered.ca:443?transport=tcp', username: 'openrelayproject', credential: 'openrelayproject' }
            ]
        };

        // ── Tabs / Chat / Hands ───────────────────────────────────────────────
        function switchTab(name, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
        }

        function sendChat() {
            const input = document.getElementById('chat-input');
            const text  = input.value.trim();
            if (!text) return;
            input.value = '';
            const msg = { type: 'chat', sender: MY_NAME, text, isInstructor: true };
            appendChat(msg, true);
            broadcast(msg);
        }

        function appendChat(msg, own = false) {
            const div = document.getElementById('chat-messages');
            const el  = document.createElement('div');
            if (msg.type === 'system') {
                el.className = 'chat-msg system';
                el.textContent = msg.text;
            } else {
                el.className = 'chat-msg' + (own ? ' own' : '');
                el.innerHTML = `<div class="sender">${msg.isInstructor ? '👨‍🏫 ' : ''}${msg.sender}</div>${msg.text}`;
            }
            div.appendChild(el);
            div.scrollTop = div.scrollHeight;
        }

        function addRaisedHand(pid, name) {
            if (raisedHands[pid]) return;
            raisedHands[pid] = name;
            updateHandsUI();
            showToast(`✋ ${name} raised their hand`);
        }

        function lowerHand(pid) {
            if (!raisedHands[pid]) return;
            delete raisedHands[pid];
            updateHandsUI();
            if (dataConns[pid]?.open) dataConns[pid].send({ type: 'hand_lowered' });
        }

        function updateHandsUI() {
            const list  = document.getElementById('hands-list');
            const badge = document.getElementById('hand-count-badge');
            const count = Object.keys(raisedHands).length;
            badge.textContent = count;
            count > 0 ? badge.classList.remove('hidden') : badge.classList.add('hidden');
            list.querySelectorAll('.hand-item').forEach(el => el.remove());
            Object.entries(raisedHands).forEach(([pid, name]) => {
                const item = document.createElement('div');
                item.className = 'hand-item';
                item.innerHTML = `<span>✋ ${name}</span><button class="lower-btn" onclick="lowerHand('${pid}')">Lower</button>`;
                list.appendChild(item);
            });
            document.getElementById('no-hands').style.display = count === 0 ? 'block' : 'none';
        }

        function showToast(msg) {
            document.getElementById('toast-text').textContent = msg;
            const t = document.getElementById('toast');
            t.style.display = 'flex';
            setTimeout(() => t.style.display = 'none', 4000);
        }

        function broadcast(data, excludePid = null) {
            Object.entries(dataConns).forEach(([pid, conn]) => {
                if (pid !== excludePid && conn.open) conn.send(data);
            });
        }

        // ── Stream start ──────────────────────────────────────────────────────
        async function startStream() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({ video: { width:1280, height:720 }, audio: true });
                mainVideo.srcObject = localStream;
                document.getElementById('status-text').textContent = 'You are live!';
                startRecording();
                initPeer();
            } catch (err) {
                document.getElementById('status-text').textContent = 'Camera/mic access denied.';
                console.error(err);
            }
        }

        function startRecording() {
            const mime = MediaRecorder.isTypeSupported('video/webm;codecs=vp9') ? 'video/webm;codecs=vp9' : 'video/webm';
            mediaRecorder = new MediaRecorder(localStream, { mimeType: mime });
            mediaRecorder.ondataavailable = e => { if (e.data.size > 0) recordedChunks.push(e.data); };
            mediaRecorder.start(1000);
            document.getElementById('rec-indicator').classList.replace('hidden', 'flex');
        }

        // ── PeerJS ────────────────────────────────────────────────────────────
        function initPeer() {
            peer = new Peer(PEER_ID, { host:'0.peerjs.com', port:443, secure:true, path:'/', config:ICE });

            peer.on('open', () => {
                document.getElementById('status-text').textContent = 'You are live! Students can now join.';
            });

            peer.on('connection', (conn) => {
                const pid = conn.peer;
                dataConns[pid] = conn;

                conn.on('open', () => {
                    // Send timer sync
                    conn.send({ type: 'timer_sync', secondsLeft });

                    // Always send camera stream first
                    const camStream = new MediaStream([...localStream.getVideoTracks(), ...localStream.getAudioTracks()]);
                    const camCall   = peer.call(pid, camStream, { metadata: { feed: 'camera' } });

                    peerCalls[pid] = { camera: camCall, screen: null };
                    document.getElementById('viewer-num').textContent = Object.keys(peerCalls).length;
                    appendChat({ type: 'system', text: `${conn.metadata?.name || 'A student'} joined` });

                    // If screen share is already running, send screen call immediately too
                    if (isSharingScreen && screenStream) {
                        const scrStream = new MediaStream([...screenStream.getVideoTracks()]);
                        const scrCall   = peer.call(pid, scrStream, { metadata: { feed: 'screen' } });
                        peerCalls[pid].screen = scrCall;
                        // Tell student which feed is currently main
                        conn.send({ type: 'layout_swap', mainFeed });
                    }

                    camCall.on('close', () => {
                        delete peerCalls[pid];
                        delete dataConns[pid];
                        delete raisedHands[pid];
                        updateHandsUI();
                        document.getElementById('viewer-num').textContent = Object.keys(peerCalls).length;
                    });
                });

                conn.on('data', (data) => {
                    if (data.type === 'chat') {
                        appendChat(data);
                        broadcast(data, pid);
                    } else if (data.type === 'raise_hand') {
                        addRaisedHand(pid, data.name);
                    } else if (data.type === 'lower_hand') {
                        delete raisedHands[pid];
                        updateHandsUI();
                    }
                });

                conn.on('close', () => {
                    delete dataConns[pid];
                    delete raisedHands[pid];
                    updateHandsUI();
                });
            });

            peer.on('error', console.error);
        }

        // ── Controls ──────────────────────────────────────────────────────────
        function toggleMute() {
            isMuted = !isMuted;
            localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
            document.getElementById('mute-icon').className = isMuted
                ? 'fas fa-microphone-slash text-red-400 text-sm'
                : 'fas fa-microphone text-sm';
        }

        function toggleVideo() {
            isVideoOff = !isVideoOff;
            localStream.getVideoTracks().forEach(t => t.enabled = !isVideoOff);
            document.getElementById('video-icon').className = isVideoOff
                ? 'fas fa-video-slash text-red-400 text-sm'
                : 'fas fa-video text-sm';
        }

        async function toggleScreenShare() {
            if (!isSharingScreen) {
                try {
                    screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: false });
                    isSharingScreen = true;

                    // Instructor preview: screen → main, camera → pip
                    mainFeed = 'screen';
                    mainVideo.srcObject = screenStream;
                    pipVideo.srcObject  = localStream;
                    showPip();

                    document.getElementById('screen-icon').className = 'fas fa-desktop text-sm text-teal-400';

                    // Send a separate screen call to every connected student
                    Object.entries(peerCalls).forEach(([pid, calls]) => {
                        if (!calls.screen) {
                            const scrStream = new MediaStream([...screenStream.getVideoTracks()]);
                            const scrCall   = peer.call(pid, scrStream, { metadata: { feed: 'screen' } });
                            peerCalls[pid].screen = scrCall;
                        }
                    });

                    // Tell all students screen share started and current layout
                    broadcast({ type: 'screen_share_started', mainFeed });

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
            screenStream = null;
            isSharingScreen = false;

            // Close the screen call for every student
            Object.values(peerCalls).forEach(calls => {
                if (calls.screen) { calls.screen.close(); calls.screen = null; }
            });

            // Restore instructor preview to camera only
            mainVideo.srcObject = localStream;
            mainFeed = 'camera';
            hidePip();

            document.getElementById('screen-icon').className = 'fas fa-desktop text-sm';
            broadcast({ type: 'screen_share_stopped' });
        }

        // ── End stream ────────────────────────────────────────────────────────
        document.getElementById('end-stream-btn').addEventListener('click', async () => {
            if (isEnding) return;
            if (!confirm('End the live stream? Recording will be uploaded automatically.')) return;
            await doEndStream();
        });

        async function autoEndStream() { if (!isEnding) await doEndStream(); }

        async function doEndStream() {
            isEnding = true;
            if (timerInterval) clearInterval(timerInterval);

            const btn = document.getElementById('end-stream-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            broadcast({ type: 'stream_ended' });

            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                await new Promise(r => { mediaRecorder.onstop = r; mediaRecorder.stop(); });
            }
            if (localStream)  localStream.getTracks().forEach(t => t.stop());
            if (screenStream) screenStream.getTracks().forEach(t => t.stop());

            Object.values(peerCalls).forEach(calls => {
                if (calls.camera) calls.camera.close();
                if (calls.screen) calls.screen.close();
            });
            if (peer) peer.destroy();

            if (recordedChunks.length > 0) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';
                try {
                    const blob = new Blob(recordedChunks, { type: 'video/webm' });
                    const fd   = new FormData();
                    fd.append('recording', blob, 'recording.webm');
                    fd.append('_token', CSRF_TOKEN);
                    const res    = await fetch(UPLOAD_URL, { method: 'POST', body: fd });
                    const result = await res.json();
                    if (result.success) console.log('Recording saved:', result.url);
                } catch (err) {
                    console.error('Upload error:', err);
                }
            }

            document.getElementById('end-stream-form').submit();
        }

        // ── Boot ──────────────────────────────────────────────────────────────
        startStream().then(() => startTimer());
    </script>
</body>
</html>