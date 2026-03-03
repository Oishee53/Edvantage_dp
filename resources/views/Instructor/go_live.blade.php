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
            width: 100%; height: 520px; object-fit: cover;
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
        .chat-msg.system { background: transparent; color: #6b7280; font-size: 0.75rem; text-align: center; }

        /* Raised hands */
        .hand-item { display: flex; align-items: center; justify-content: space-between;
            padding: 0.75rem 1rem; border-bottom: 1px solid #1f2937; font-size: 0.85rem; }
        .lower-btn { font-size: 0.75rem; padding: 0.3rem 0.7rem; background: #374151;
            color: #d1d5db; border: none; border-radius: 6px; cursor: pointer; }
        .lower-btn:hover { background: #ef4444; color: white; }

        /* Notification toast */
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
            <span class="text-gray-300 font-medium text-sm">{{ $session->title ?? 'Session ' . $session_number }}</span>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-gray-400 text-sm"><i class="fas fa-users mr-1"></i><span id="viewer-num">0</span> watching</span>
            <span id="rec-indicator" class="hidden items-center gap-1.5 px-2.5 py-1 bg-red-900 border border-red-700 rounded-full text-xs font-semibold text-red-300">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-ping inline-block"></span> REC
            </span>
        </div>
    </div>

    <!-- Toast notification -->
    <div id="toast">
        <span>✋</span><span id="toast-text"></span>
        <button onclick="document.getElementById('toast').style.display='none'"
                style="margin-left:0.5rem;background:none;border:none;color:#9ca3af;cursor:pointer;">✕</button>
    </div>

    <!-- Main layout -->
    <div style="display:flex; height:calc(100vh - 53px);">

        <!-- Video area -->
        <div style="flex:1; padding:1.25rem; display:flex; flex-direction:column; gap:1rem; overflow:hidden;">

            <div class="relative" style="flex:1;">
                <video id="local-video" autoplay muted playsinline style="height:100%;"></video>

                <!-- Controls overlay -->
                <div class="absolute bottom-4 left-0 right-0 flex items-center justify-center gap-3">
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
            <!-- Sidebar tabs -->
            <div style="display:flex; border-bottom:1px solid #1f2937;">
                <button class="tab-btn active" onclick="switchTab('chat', this)">
                    <i class="fas fa-comments mr-1"></i> Chat
                </button>
                <button class="tab-btn" onclick="switchTab('hands', this)" id="hands-tab-btn">
                    <i class="fas fa-hand-paper mr-1"></i> Hands <span id="hand-count-badge" class="hidden ml-1 px-1.5 py-0.5 bg-amber-500 text-black text-xs rounded-full font-bold">0</span>
                </button>
            </div>

            <!-- Chat pane -->
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

            <!-- Raised hands pane -->
            <div id="tab-hands" class="tab-pane" style="flex-direction:column;">
                <div id="hands-list" style="flex:1; overflow-y:auto;">
                    <p id="no-hands" style="text-align:center; color:#6b7280; padding:2rem; font-size:0.85rem;">No raised hands</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden end-stream form -->
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
        let recordedChunks = [], connectedPeers = {}, dataConns = {};
        let raisedHands = {}; // peerId -> name
        let isMuted = false, isVideoOff = false, isSharingScreen = false, isEnding = false;

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

        // ── Chat ─────────────────────────────────────────────────────────────
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

        // ── Raised hands ─────────────────────────────────────────────────────
        function addRaisedHand(peerId, name) {
            if (raisedHands[peerId]) return;
            raisedHands[peerId] = name;
            updateHandsUI();
            showToast(`✋ ${name} raised their hand`);
        }

        function lowerHand(peerId) {
            if (!raisedHands[peerId]) return;
            const name = raisedHands[peerId];
            delete raisedHands[peerId];
            updateHandsUI();
            // Tell the student their hand was lowered
            if (dataConns[peerId]) {
                dataConns[peerId].send({ type: 'hand_lowered' });
            }
        }

        function updateHandsUI() {
            const list  = document.getElementById('hands-list');
            const noHands = document.getElementById('no-hands');
            const badge = document.getElementById('hand-count-badge');
            const count = Object.keys(raisedHands).length;

            badge.textContent = count;
            if (count > 0) { badge.classList.remove('hidden'); } else { badge.classList.add('hidden'); }

            list.querySelectorAll('.hand-item').forEach(el => el.remove());

            Object.entries(raisedHands).forEach(([pid, name]) => {
                const item = document.createElement('div');
                item.className = 'hand-item';
                item.innerHTML = `
                    <span>✋ ${name}</span>
                    <button class="lower-btn" onclick="lowerHand('${pid}')">Lower</button>
                `;
                list.appendChild(item);
            });

            if (count === 0) {
                noHands.style.display = 'block';
            } else {
                noHands.style.display = 'none';
            }
        }

        // ── Toast ─────────────────────────────────────────────────────────────
        function showToast(msg) {
            const toast = document.getElementById('toast');
            document.getElementById('toast-text').textContent = msg;
            toast.style.display = 'flex';
            setTimeout(() => toast.style.display = 'none', 4000);
        }

        // ── Broadcast to all data connections ────────────────────────────────
        function broadcast(data, excludePeer = null) {
            Object.entries(dataConns).forEach(([pid, conn]) => {
                if (pid !== excludePeer && conn.open) conn.send(data);
            });
        }

        // ── Start stream ─────────────────────────────────────────────────────
        async function startStream() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    video: { width: 1280, height: 720 }, audio: true,
                });
                document.getElementById('local-video').srcObject = localStream;
                document.getElementById('status-text').textContent = 'You are live!';
                startRecording();
                initPeer();
            } catch (err) {
                document.getElementById('status-text').textContent = 'Camera/mic access denied.';
                console.error(err);
            }
        }

        // ── Recording ────────────────────────────────────────────────────────
        function startRecording() {
            const mimeType = MediaRecorder.isTypeSupported('video/webm;codecs=vp9') ? 'video/webm;codecs=vp9' : 'video/webm';
            mediaRecorder = new MediaRecorder(localStream, { mimeType });
            mediaRecorder.ondataavailable = e => { if (e.data.size > 0) recordedChunks.push(e.data); };
            mediaRecorder.start(1000);
            document.getElementById('rec-indicator').classList.replace('hidden', 'flex');
        }

        // ── PeerJS ───────────────────────────────────────────────────────────
        function initPeer() {
            peer = new Peer(PEER_ID, { host: '0.peerjs.com', port: 443, secure: true, path: '/', config: ICE });

            peer.on('open', () => {
                document.getElementById('status-text').textContent = 'You are live! Students can now join.';
            });

            // Student opens DATA connection to signal they want the stream
            peer.on('connection', (conn) => {
                const studentPeer = conn.peer;
                dataConns[studentPeer] = conn;

                conn.on('open', () => {
                    // Call student with video stream
                    const streamToSend = new MediaStream([
                        ...localStream.getVideoTracks(),
                        ...localStream.getAudioTracks(),
                    ]);
                    const call = peer.call(studentPeer, streamToSend);
                    connectedPeers[studentPeer] = call;
                    document.getElementById('viewer-num').textContent = Object.keys(connectedPeers).length;

                    appendChat({ type: 'system', text: `${conn.metadata?.name || 'A student'} joined` });

                    call.on('close', () => {
                        delete connectedPeers[studentPeer];
                        delete dataConns[studentPeer];
                        delete raisedHands[studentPeer];
                        updateHandsUI();
                        document.getElementById('viewer-num').textContent = Object.keys(connectedPeers).length;
                    });
                });

                conn.on('data', (data) => {
                    if (data.type === 'chat') {
                        appendChat(data);
                        broadcast(data, studentPeer); // relay to other students
                    } else if (data.type === 'raise_hand') {
                        addRaisedHand(studentPeer, data.name);
                    } else if (data.type === 'lower_hand') {
                        delete raisedHands[studentPeer];
                        updateHandsUI();
                    }
                });

                conn.on('close', () => {
                    delete dataConns[studentPeer];
                    delete raisedHands[studentPeer];
                    updateHandsUI();
                });
            });

            peer.on('error', console.error);
        }

        // ── Controls ─────────────────────────────────────────────────────────
        function toggleMute() {
            isMuted = !isMuted;
            localStream.getAudioTracks().forEach(t => t.enabled = !isMuted);
            document.getElementById('mute-icon').className = isMuted ? 'fas fa-microphone-slash text-red-400 text-sm' : 'fas fa-microphone text-sm';
        }

        function toggleVideo() {
            isVideoOff = !isVideoOff;
            localStream.getVideoTracks().forEach(t => t.enabled = !isVideoOff);
            document.getElementById('video-icon').className = isVideoOff ? 'fas fa-video-slash text-red-400 text-sm' : 'fas fa-video text-sm';
        }

        async function toggleScreenShare() {
            if (!isSharingScreen) {
                try {
                    screenStream = await navigator.mediaDevices.getDisplayMedia({ video: true, audio: true });
                    const screenTrack = screenStream.getVideoTracks()[0];

                    // Replace video track in all peer connections
                    Object.values(connectedPeers).forEach(call => {
                        const sender = call.peerConnection?.getSenders().find(s => s.track?.kind === 'video');
                        if (sender) sender.replaceTrack(screenTrack);
                    });

                    document.getElementById('local-video').srcObject = screenStream;
                    document.getElementById('screen-icon').className = 'fas fa-desktop text-sm text-teal-400';
                    isSharingScreen = true;

                    screenTrack.onended = () => stopScreenShare();
                } catch (err) {
                    console.error('Screen share error:', err);
                }
            } else {
                stopScreenShare();
            }
        }

        function stopScreenShare() {
            if (screenStream) screenStream.getTracks().forEach(t => t.stop());
            const camTrack = localStream.getVideoTracks()[0];

            Object.values(connectedPeers).forEach(call => {
                const sender = call.peerConnection?.getSenders().find(s => s.track?.kind === 'video');
                if (sender) sender.replaceTrack(camTrack);
            });

            document.getElementById('local-video').srcObject = localStream;
            document.getElementById('screen-icon').className = 'fas fa-desktop text-sm';
            isSharingScreen = false;
        }

        // ── End stream ───────────────────────────────────────────────────────
        document.getElementById('end-stream-btn').addEventListener('click', async () => {
            if (isEnding) return;
            if (!confirm('End the live stream? Recording will be uploaded automatically.')) return;

            isEnding = true;
            const btn = document.getElementById('end-stream-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

            broadcast({ type: 'system', text: 'Stream has ended' });

            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                await new Promise(resolve => { mediaRecorder.onstop = resolve; mediaRecorder.stop(); });
            }
            if (localStream) localStream.getTracks().forEach(t => t.stop());
            Object.values(connectedPeers).forEach(call => call.close());
            if (peer) peer.destroy();

            if (recordedChunks.length > 0) {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';
                try {
                    const blob = new Blob(recordedChunks, { type: 'video/webm' });
                    const formData = new FormData();
                    formData.append('recording', blob, 'recording.webm');
                    formData.append('_token', CSRF_TOKEN);
                    const res = await fetch(UPLOAD_URL, { method: 'POST', body: formData });
                    const result = await res.json();
                    if (result.success) console.log('Recording saved:', result.url);
                } catch (err) {
                    console.error('Upload error:', err);
                }
            }

            document.getElementById('end-stream-form').submit();
        });

        startStream();
    </script>
</body>
</html>