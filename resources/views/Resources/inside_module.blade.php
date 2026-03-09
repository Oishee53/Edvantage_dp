<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->name }} - Lecture {{ $moduleNumber }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .heading-font { font-family: 'Playfair Display', Georgia, serif; }
        body { background: #f9fafb; letter-spacing: -0.01em; }
        .main-container { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem; }
        .video-section { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .video-placeholder { width: 100%; aspect-ratio: 16/9; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, #0d7377 0%, #14b8a6 100%); color: white; }
        .play-overlay { width: 80px; height: 80px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; margin-bottom: 1rem; }
        .play-overlay:hover { background: rgba(255,255,255,0.3); transform: scale(1.1); }
        .content-area { padding: 2rem; }
        .breadcrumb { display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem; font-weight: 500; }
        .breadcrumb a { color: #0d7377; text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: #0a5c5f; }
        .course-title { font-size: 0.95rem; font-weight: 600; color: #0d7377; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .lecture-title { font-size: 2rem; font-weight: 700; color: #111827; margin-bottom: 0.75rem; letter-spacing: -0.02em; line-height: 1.2; }
        .lecture-meta { display: flex; gap: 1.5rem; font-size: 0.9rem; color: #6b7280; margin-bottom: 2rem; font-weight: 500; }
        .meta-item { display: flex; align-items: center; gap: 0.5rem; }
        .tabs { display: flex; gap: 2rem; border-bottom: 2px solid #f3f4f6; margin-bottom: 2rem; }
        .tab { padding: 0.75rem 0; font-size: 0.95rem; font-weight: 600; color: #6b7280; cursor: pointer; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all 0.2s; }
        .tab.active { color: #0d7377; border-bottom-color: #0d7377; }
        .tab:hover { color: #0d7377; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .resource-card { background: #f9fafb; border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem; border: 1px solid #f3f4f6; transition: all 0.2s; }
        .resource-card:hover { border-color: #0d7377; background: white; }
        .resource-header { display: flex; align-items: center; justify-content: space-between; }
        .resource-info { display: flex; align-items: center; gap: 1rem; }
        .resource-icon { width: 48px; height: 48px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid #e5e7eb; }
        .resource-icon i { color: #0d7377; font-size: 1.25rem; }
        .resource-title { font-size: 1rem; font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; }
        .resource-subtitle { font-size: 0.875rem; color: #6b7280; font-weight: 500; }
        .btn-resource { padding: 0.625rem 1.25rem; background: #0d7377; color: white; border-radius: 8px; font-weight: 600; font-size: 0.875rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; text-decoration: none; }
        .btn-resource:hover { background: #0a5c5f; transform: translateY(-1px); }
        .question-form { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .form-label { display: block; font-size: 0.95rem; font-weight: 600; color: #1f2937; margin-bottom: 0.75rem; }
        .form-input { width: 100%; border: 2px solid #e5e7eb; border-radius: 8px; padding: 0.875rem 1rem; font-size: 0.95rem; transition: all 0.2s; font-weight: 500; }
        .form-input:focus { outline: none; border-color: #0d7377; box-shadow: 0 0 0 3px rgba(13,115,119,0.1); }
        .form-input::placeholder { color: #9ca3af; font-weight: 400; }
        .btn-submit { padding: 0.875rem 1.5rem; background: #0d7377; color: white; border-radius: 8px; font-weight: 600; font-size: 0.95rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer; margin-top: 1rem; }
        .btn-submit:hover { background: #0a5c5f; transform: translateY(-1px); }
        .alert { padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem; font-weight: 500; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-left: 4px solid #22c55e; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; border-left: 4px solid #ef4444; }
        .empty-state { text-align: center; padding: 3rem 2rem; background: #f9fafb; border-radius: 12px; border: 1px solid #f3f4f6; }
        .empty-icon { width: 64px; height: 64px; background: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1rem; border: 1px solid #e5e7eb; }
        .empty-icon i { font-size: 1.75rem; color: #9ca3af; }
        .empty-title { font-size: 1.125rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; }
        .empty-text { color: #6b7280; font-size: 0.95rem; font-weight: 500; }

        /* ============================================================
           REDESIGNED AI NOTEBOOK SIDEBAR
        ============================================================ */
        .notebook-sidebar {
            position: sticky;
            top: 2rem;
            height: calc(100vh - 6rem);
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        /* --- Header --- */
        .nb-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
        }
        .nb-icon-wrap {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #0d7377, #14b8a6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .nb-icon-wrap i { color: white; font-size: 15px; }
        .nb-header-text { flex: 1; }
        .nb-header-text h3 { font-size: 14px; font-weight: 700; color: #111827; margin: 0 0 1px; letter-spacing: -0.01em; }
        .nb-header-text p { font-size: 11px; color: #9ca3af; margin: 0; font-weight: 500; }
        .nb-status-dot {
            width: 7px; height: 7px;
            background: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(34,197,94,0.2);
        }

        /* --- Docs bar --- */
        .nb-docs-bar {
            padding: 8px 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
            flex-shrink: 0;
        }
        .nb-doc-pill {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 100px;
            padding: 3px 9px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #374151;
            font-weight: 500;
        }
        .nb-doc-pill i { color: #0d7377; font-size: 9px; }
        .nb-doc-pill .del {
            cursor: pointer;
            color: #9ca3af;
            font-size: 10px;
            transition: color 0.15s;
            margin-left: 2px;
        }
        .nb-doc-pill .del:hover { color: #ef4444; }
        .nb-doc-pill.processing { opacity: 0.55; }

        /* --- Messages area --- */
        .nb-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            scroll-behavior: smooth;
        }
        .nb-messages::-webkit-scrollbar { width: 3px; }
        .nb-messages::-webkit-scrollbar-track { background: transparent; }
        .nb-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }

        /* --- Welcome state --- */
        .nb-welcome {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 12px 8px;
        }
        .nb-welcome-glyph {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #f0fdfa, #ccfbf1);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            border: 1px solid #99f6e4;
        }
        .nb-welcome-glyph i { color: #0d9488; font-size: 20px; }
        .nb-welcome h4 { font-size: 14px; font-weight: 700; color: #111827; margin: 0 0 6px; letter-spacing: -0.01em; }
        .nb-welcome p { font-size: 12px; color: #6b7280; line-height: 1.6; margin: 0 0 18px; font-weight: 400; }
        .nb-suggestions { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; }
        .nb-pill {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 6px 11px;
            font-size: 11px;
            cursor: pointer;
            transition: all 0.15s;
            color: #374151;
            font-weight: 500;
            letter-spacing: -0.01em;
        }
        .nb-pill:hover { border-color: #0d9488; color: #0d9488; background: #f0fdfa; }

        /* --- Message rows --- */
        .nb-msg-group { display: flex; flex-direction: column; gap: 2px; }
        .nb-msg-row { display: flex; gap: 10px; }
        .nb-msg-row.user { flex-direction: row-reverse; }
        @keyframes nbFadeUp { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        .nb-msg-row { animation: nbFadeUp 0.2s ease; }

        .nb-msg-avatar {
            width: 26px; height: 26px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .nb-msg-avatar.user { background: #0d7377; color: white; font-size: 11px; }
        .nb-msg-avatar.ai { background: #111827; color: white; }
        .nb-msg-avatar.ai i { font-size: 10px; }

        .nb-bubble {
            padding: 10px 13px;
            border-radius: 12px;
            font-size: 13px;
            line-height: 1.65;
            max-width: calc(100% - 40px);
            word-break: break-word;
        }
        .nb-bubble.user {
            background: #0d7377;
            color: white;
            border-bottom-right-radius: 3px;
            font-weight: 400;
        }
        .nb-bubble.ai {
            background: #f9fafb;
            border: 1px solid #e9ecef;
            color: #1f2937;
            border-bottom-left-radius: 3px;
        }
        .nb-bubble.ai strong { color: #0d7377; font-weight: 600; }
        .nb-bubble.ai ul, .nb-bubble.ai ol { margin: 6px 0 6px 16px; }
        .nb-bubble.ai li { margin-bottom: 3px; }

        /* --- Sources --- */
        .nb-sources-toggle {
            font-size: 10.5px;
            color: #0d9488;
            cursor: pointer;
            margin-top: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
            letter-spacing: -0.01em;
        }
        .nb-sources-toggle:hover { color: #0f766e; }
        .nb-sources-panel {
            margin-top: 6px;
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 8px;
            padding: 9px 11px;
            font-size: 11px;
            color: #374151;
            line-height: 1.55;
        }

        /* --- Typing indicator --- */
        .nb-typing {
            display: flex;
            gap: 4px;
            padding: 11px 14px;
            background: #f9fafb;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            border-bottom-left-radius: 3px;
            width: fit-content;
            animation: nbFadeUp 0.2s ease;
        }
        .nb-dot { width: 5px; height: 5px; background: #9ca3af; border-radius: 50%; animation: nbBounce 1.3s infinite; }
        .nb-dot:nth-child(2) { animation-delay: 0.18s; }
        .nb-dot:nth-child(3) { animation-delay: 0.36s; }
        @keyframes nbBounce { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-5px); } }

        /* --- Input bar --- */
        .nb-input-bar {
            padding: 12px 16px;
            border-top: 1px solid #f3f4f6;
            flex-shrink: 0;
            background: #fff;
        }
        .nb-input-row { display: flex; align-items: flex-end; gap: 8px; }
        .nb-upload-trigger {
            width: 34px; height: 34px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s;
            flex-shrink: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .nb-upload-trigger:hover { background: #f0fdfa; border-color: #0d9488; color: #0d9488; }
        .nb-input-wrap {
            flex: 1;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 11px;
            padding: 8px 10px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .nb-input-wrap:focus-within {
            border-color: #0d7377;
            box-shadow: 0 0 0 3px rgba(13,115,119,0.08);
            background: #fff;
        }
        .nb-textarea {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1f2937;
            resize: none;
            line-height: 1.55;
            max-height: 96px;
            overflow-y: auto;
            font-weight: 400;
        }
        .nb-textarea::placeholder { color: #b0b7c3; }
        .nb-send {
            width: 30px; height: 30px;
            background: #0d7377;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            transition: background 0.15s, transform 0.1s;
            flex-shrink: 0;
        }
        .nb-send:hover { background: #0a5c5f; }
        .nb-send:active { transform: scale(0.93); }
        .nb-send:disabled { background: #d1d5db; cursor: not-allowed; transform: none; }
        .nb-hint { text-align: center; font-size: 10px; color: #b0b7c3; margin-top: 7px; font-weight: 400; }

        /* --- Upload Modal --- */
        .nb-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
        .nb-modal {
            background: white;
            border-radius: 16px;
            padding: 26px;
            width: 400px;
            max-width: 95vw;
            box-shadow: 0 24px 64px rgba(0,0,0,0.15);
            border: 1px solid #e5e7eb;
        }
        .nb-modal-header { display: flex; align-items: center; gap: 12px; margin-bottom: 22px; }
        .nb-modal-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #f0fdfa, #ccfbf1);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid #99f6e4;
        }
        .nb-modal-icon i { color: #0d7377; font-size: 16px; }
        .nb-modal-header h3 { font-size: 15px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.01em; }
        .nb-modal-header p { font-size: 12px; color: #9ca3af; margin: 0; }
        .nb-modal-close {
            margin-left: auto;
            width: 28px; height: 28px;
            border-radius: 7px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #6b7280;
            font-size: 13px;
            transition: all 0.15s;
        }
        .nb-modal-close:hover { background: #fef2f2; border-color: #fecaca; color: #ef4444; }
        .nb-field-label { font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 6px; display: block; letter-spacing: -0.01em; }
        .nb-field-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 9px;
            padding: 9px 12px;
            font-size: 13px;
            outline: none;
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            font-weight: 400;
        }
        .nb-field-input:focus { border-color: #0d7377; box-shadow: 0 0 0 3px rgba(13,115,119,0.08); }
        .nb-field-input::placeholder { color: #b0b7c3; }
        .nb-progress-wrap { margin-bottom: 16px; }
        .nb-progress-label { display: flex; justify-content: space-between; font-size: 11px; color: #6b7280; margin-bottom: 5px; font-weight: 500; }
        .nb-progress-bar { height: 4px; background: #f3f4f6; border-radius: 100px; overflow: hidden; }
        .nb-progress-fill { height: 100%; background: linear-gradient(90deg, #0d7377, #14b8a6); border-radius: 100px; transition: width 0.4s ease; }
        .nb-modal-info {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 9px;
            padding: 10px 12px;
            margin-bottom: 18px;
            font-size: 11.5px;
            color: #0f766e;
            display: flex;
            gap: 8px;
            align-items: flex-start;
            font-weight: 500;
        }
        .nb-modal-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 9px;
            padding: 10px 12px;
            margin-bottom: 16px;
            font-size: 12px;
            color: #991b1b;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }
        .nb-modal-actions { display: flex; gap: 9px; }
        .nb-btn-cancel {
            flex: 1;
            padding: 10px;
            border: 1.5px solid #e5e7eb;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            cursor: pointer;
            background: white;
            transition: all 0.15s;
        }
        .nb-btn-cancel:hover { border-color: #d1d5db; background: #f9fafb; }
        .nb-btn-upload {
            flex: 1;
            padding: 10px;
            background: #0d7377;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .nb-btn-upload:hover { background: #0a5c5f; }
        .nb-btn-upload:disabled { opacity: 0.5; cursor: not-allowed; }

        @media (max-width: 1024px) {
            .main-container { grid-template-columns: 1fr; }
            .notebook-sidebar { position: static; height: 580px; }
        }
    </style>
</head>
<body class="min-h-screen px-20 pt-5">
    @include('layouts.header')

    <div class="pt-24">
        <div class="main-container">

            <!-- LEFT CONTENT -->
            <div>
                <div class="video-section mb-6">
                    @auth
                        @if($resource->videos)
                            <mux-player id="mux-player" playback-id="{{ $resource->videos }}" stream-type="on-demand" controls class="w-full aspect-video"></mux-player>
                        @else
                            <div class="video-placeholder">
                                <div class="play-overlay"><i class="fas fa-play" style="font-size:2rem;margin-left:4px;"></i></div>
                                <p style="font-size:1rem;opacity:0.9;font-weight:500;">No video available</p>
                            </div>
                        @endif
                    @else
                        <div class="video-placeholder">
                            <div style="width:64px;height:64px;background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                <i class="fas fa-lock" style="font-size:1.5rem;"></i>
                            </div>
                            <p style="font-size:1rem;opacity:0.9;font-weight:500;">Please log in to view content</p>
                        </div>
                    @endauth
                </div>

                <div class="content-area">
                    <div class="breadcrumb">
                        <a href="/my-courses">My Courses</a>
                        <span>/</span>
                        <a href="{{ route('user.course.modules', $course->id) }}">{{ $course->name }}</a>
                        <span>/</span>
                        <span>Lecture {{ $moduleNumber }}</span>
                    </div>

                    @if(session('error'))<div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i>{{ session('error') }}</div>@endif
                    @if(session('success'))<div class="alert alert-success"><i class="fas fa-check-circle"></i>{{ session('success') }}</div>@endif

                    <div class="course-title">{{ $course->title }}</div>
                    <h1 class="lecture-title heading-font">{{ $course->name }}</h1>
                    <div class="lecture-meta">
                        <div class="meta-item"><i class="fas fa-book-open" style="color:#0d7377;"></i><span>Lecture {{ $moduleNumber }}</span></div>
                        <div class="meta-item"><i class="fas fa-clock" style="color:#0d7377;"></i><span>Self-paced</span></div>
                    </div>

                    <div class="tabs">
                        <div class="tab active" data-tab="resources">Resources</div>
                        <div class="tab" data-tab="discussion">Discussion</div>
                        <div class="tab" data-tab="quiz">Quiz</div>
                        <div class="tab" data-tab="ask-question">Ask Question</div>
                    </div>

                    <div class="tab-content active" id="resources-content">
                        @auth
                            @if($resource->pdf)
                                <div class="resource-card">
                                    <div class="resource-header">
                                        <div class="resource-info">
                                            <div class="resource-icon"><i class="fas fa-file-pdf"></i></div>
                                            <div>
                                                <div class="resource-title">PDF Document</div>
                                                <div class="resource-subtitle">Download or view lecture materials</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('secure.pdf.view', ['id' => $resource->id]) }}" target="_blank" class="btn-resource">
                                            <i class="fas fa-external-link-alt"></i> View PDF
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-file-pdf"></i></div>
                                    <div class="empty-title heading-font">No PDF Available</div>
                                    <div class="empty-text">There are no PDF resources for this lecture yet.</div>
                                </div>
                            @endif
                        @else
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-lock"></i></div>
                                <div class="empty-title heading-font">Login Required</div>
                            </div>
                        @endauth
                    </div>

                    <div class="tab-content" id="discussion-content">
                        @if($forum)
                            <x-discussion-forum :forum="$forum" :course="$course" />
                        @else
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-comments"></i></div>
                                <div class="empty-title heading-font">No Discussion Available</div>
                            </div>
                        @endif
                    </div>

                    <div class="tab-content" id="quiz-content">
                        @auth
                            @if($quiz)
                                <div class="resource-card">
                                    <div class="resource-header">
                                        <div class="resource-info">
                                            <div class="resource-icon"><i class="fas fa-question-circle"></i></div>
                                            <div>
                                                <div class="resource-title">Lecture Quiz</div>
                                                <div class="resource-subtitle">Test your knowledge</div>
                                            </div>
                                        </div>
                                        <a href="{{ route('user.quiz.start', ['course' => $course->id, 'module' => $moduleNumber]) }}" class="btn-resource">
                                            <i class="fas fa-play"></i> Take Quiz
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-question-circle"></i></div>
                                    <div class="empty-title heading-font">No Quiz Available</div>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <div class="tab-content" id="ask-question-content">
                        <div class="question-form">
                            <form action="{{ route('questions.store') }}" method="POST">
                                @csrf
                                <label for="question" class="form-label">
                                    <i class="fas fa-comment-dots" style="color:#0d7377;margin-right:0.5rem;"></i>
                                    Ask a Question
                                </label>
                                <input type="text" id="question" name="question" class="form-input" placeholder="Type your question here..." required>
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <input type="hidden" name="module_number" value="{{ $moduleNumber }}">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane"></i> Post Question
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR — AI NOTEBOOK (REDESIGNED) -->
            @auth
            <div x-data="notebookPanel()" x-init="init()" class="notebook-sidebar">

                <!-- Header -->
                <div class="nb-header">
                    <div class="nb-icon-wrap">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="nb-header-text">
                        <h3>AI Study Assistant</h3>
                        <p>Powered by Gemini</p>
                    </div>
                    <div class="nb-status-dot" title="Online"></div>
                </div>

                <!-- Hidden file input -->
                <input type="file" x-ref="fileInput" accept=".pdf,.txt,.docx" style="display:none;" @change="handleFileSelect($event)">

                <!-- Doc pills — only visible when documents exist -->
                <template x-if="documents.length > 0">
                    <div class="nb-docs-bar">
                        <template x-for="doc in documents" :key="doc.id">
                            <div class="nb-doc-pill" :class="{ processing: doc.status !== 'ready' }">
                                <i :class="doc.file_type === 'pdf' ? 'fas fa-file-pdf' : 'fas fa-file-alt'"></i>
                                <span x-text="doc.title.length > 18 ? doc.title.substring(0,18)+'…' : doc.title"></span>
                                <span class="del" @click.stop="deleteDoc(doc.id)"><i class="fas fa-times"></i></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Messages -->
                <div class="nb-messages" x-ref="messages">
                    <template x-if="conversations.length === 0 && !isTyping">
                        <div class="nb-welcome">
                            <div class="nb-welcome-glyph">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4>Ask About This Lecture</h4>
                            <p>Get instant answers, summaries, and study guides. Upload your notes to ground answers in your own materials.</p>
                            <div class="nb-suggestions">
                                <div class="nb-pill" @click="ask('Summarize the key concepts from this lecture')">Key concepts</div>
                                <div class="nb-pill" @click="ask('What should I focus on for the exam?')">Exam focus</div>
                                <div class="nb-pill" @click="ask('Create a quick study guide')">Study guide</div>
                                <div class="nb-pill" @click="ask('Explain the most difficult topic in simple terms')">Hard topics</div>
                            </div>
                        </div>
                    </template>

                    <template x-for="(msg, i) in conversations" :key="i">
                        <div>
                            <!-- User message -->
                            <div class="nb-msg-row user" style="margin-bottom:10px;">
                                <div class="nb-msg-avatar user">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                <div class="nb-bubble user" x-text="msg.question"></div>
                            </div>
                            <!-- AI message -->
                            <div class="nb-msg-row ai">
                                <div class="nb-msg-avatar ai"><i class="fas fa-robot"></i></div>
                                <div style="max-width:calc(100% - 36px);">
                                    <div class="nb-bubble ai" x-html="fmt(msg.answer)"></div>
                                    <template x-if="msg.sources && msg.sources.length">
                                        <div>
                                            <div class="nb-sources-toggle" @click="msg.showSrc = !msg.showSrc">
                                                <i :class="msg.showSrc ? 'fas fa-chevron-down' : 'fas fa-chevron-right'" style="font-size:9px;"></i>
                                                <span x-text="msg.sources.length + ' source' + (msg.sources.length > 1 ? 's' : '')"></span>
                                            </div>
                                            <div class="nb-sources-panel" x-show="msg.showSrc" x-transition>
                                                <template x-for="(s, si) in msg.sources" :key="si">
                                                    <div style="margin-bottom:4px;">
                                                        <strong style="color:#0f766e;">Source <span x-text="si+1"></span>:</strong>
                                                        <span x-text="s.content"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="isTyping">
                        <div class="nb-msg-row ai">
                            <div class="nb-msg-avatar ai"><i class="fas fa-robot"></i></div>
                            <div class="nb-typing">
                                <div class="nb-dot"></div><div class="nb-dot"></div><div class="nb-dot"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Input bar -->
                <div class="nb-input-bar">
                    <div class="nb-input-row">
                        <!-- Plus / upload button — bottom left -->
                        <button class="nb-upload-trigger" @click="$refs.fileInput.click()" title="Upload document">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="nb-input-wrap">
                            <textarea class="nb-textarea" x-model="question"
                                placeholder="Ask anything about this lecture..."
                                rows="1"
                                @keydown.enter.prevent="!$event.shiftKey && sendQuestion()"
                                @input="autoResize($event)"
                                :disabled="isTyping"></textarea>
                            <button class="nb-send" @click="sendQuestion()" :disabled="!question.trim() || isTyping">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                    <p class="nb-hint">Enter to send &middot; Shift+Enter for new line</p>
                </div>

                <!-- Upload Modal -->
                <div class="nb-modal-overlay" x-show="showModal" x-transition
                     @click.self="closeModal()" @keydown.escape.window="showModal && closeModal()">
                    <div class="nb-modal" @click.stop>

                        <div class="nb-modal-header">
                            <div class="nb-modal-icon">
                                <i class="fas fa-file-upload"></i>
                            </div>
                            <div>
                                <h3>Upload Document</h3>
                                <p x-text="selectedFile ? selectedFile.name : ''"></p>
                            </div>
                            <button class="nb-modal-close" @click="closeModal()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div style="margin-bottom:14px;">
                            <label class="nb-field-label">Document title</label>
                            <input type="text" x-model="uploadTitle" class="nb-field-input"
                                placeholder="e.g. Week 3 Lecture Notes">
                        </div>

                        <div class="nb-progress-wrap" x-show="uploading">
                            <div class="nb-progress-label">
                                <span x-text="uploadStatus"></span>
                                <span x-text="uploadPct + '%'"></span>
                            </div>
                            <div class="nb-progress-bar">
                                <div class="nb-progress-fill" :style="'width:'+uploadPct+'%'"></div>
                            </div>
                        </div>

                        <div class="nb-modal-error" x-show="uploadError">
                            <i class="fas fa-exclamation-circle" style="margin-top:1px;flex-shrink:0;"></i>
                            <span x-text="uploadError"></span>
                        </div>

                        <div class="nb-modal-info">
                            <i class="fas fa-info-circle" style="margin-top:1px;flex-shrink:0;"></i>
                            <span>Supports PDF, TXT, DOCX &middot; Max 20 MB &middot; Processing takes 10–30s</span>
                        </div>

                        <div class="nb-modal-actions">
                            <button class="nb-btn-cancel" @click="closeModal()">Cancel</button>
                            <button class="nb-btn-upload" @click="doUpload()"
                                :disabled="!uploadTitle.trim() || uploading">
                                <i class="fas fa-upload"></i>
                                <span x-text="uploading ? 'Processing...' : 'Upload & Process'"></span>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
            @else
            <div class="notebook-sidebar" style="align-items:center;justify-content:center;text-align:center;padding:32px;">
                <div style="width:44px;height:44px;background:linear-gradient(135deg,#f0fdfa,#ccfbf1);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;border:1px solid #99f6e4;">
                    <i class="fas fa-lock" style="color:#0d7377;font-size:16px;"></i>
                </div>
                <h4 style="font-weight:700;color:#111827;margin:0 0 6px;font-size:14px;letter-spacing:-0.01em;">AI Study Assistant</h4>
                <p style="font-size:12px;color:#9ca3af;margin:0 0 18px;line-height:1.6;">Log in to access your personal AI study notebook.</p>
                <a href="/login" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#0d7377;color:white;border-radius:9px;font-weight:600;font-size:13px;text-decoration:none;transition:background 0.15s;">
                    <i class="fas fa-sign-in-alt"></i> Log In
                </a>
            </div>
            @endauth

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@mux/mux-player"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    const target = document.getElementById(this.getAttribute('data-tab') + '-content');
                    if (target) target.classList.add('active');
                });
            });

            // Video progress tracking
            const player = document.getElementById('mux-player');
            if (player) {
                let lastSaved = 0;
                player.addEventListener('timeupdate', async function () {
                    const pct = (player.currentTime / player.duration) * 100;
                    if (pct - lastSaved >= 10) {
                        lastSaved = pct;
                        try {
                            await fetch('{{ route("video.progress.save") }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ course_id: {{ $course->id }}, resource_id: {{ $resource->id }}, progress_percent: pct })
                            });
                        } catch (e) {}
                    }
                });
                player.addEventListener('ended', async function () {
                    await fetch('{{ route("video.progress.save") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ course_id: {{ $course->id }}, resource_id: {{ $resource->id }}, progress_percent: 100 })
                    });
                });
            }
        });

        function notebookPanel() {
            return {
                question:      '',
                conversations: @json($nbConversations ?? []),
                documents:     @json($nbDocuments ?? []),
                isTyping:      false,
                showModal:     false,
                selectedFile:  null,
                uploadTitle:   '',
                uploading:     false,
                uploadPct:     0,
                uploadStatus:  'Uploading...',
                uploadError:   '',
                csrf:          document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                courseId:      {{ $course->id }},

                init() { this.scrollBottom(); },

                autoResize(e) {
                    e.target.style.height = 'auto';
                    e.target.style.height = Math.min(e.target.scrollHeight, 96) + 'px';
                },

                scrollBottom() {
                    this.$nextTick(() => {
                        const el = this.$refs.messages;
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                },

                ask(text) {
                    this.question = text;
                    this.$nextTick(() => this.sendQuestion());
                },

                async sendQuestion() {
                    const q = this.question.trim();
                    if (!q || this.isTyping) return;
                    this.question = '';
                    this.isTyping = true;
                    this.conversations.push({ question: q, answer: null, sources: [], showSrc: false });
                    this.scrollBottom();
                    try {
                        const res  = await fetch(`/courses/${this.courseId}/notebook/ask`, {
                            method:  'POST',
                            headers: { 'X-CSRF-TOKEN': this.csrf, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                            body:    JSON.stringify({ question: q }),
                        });
                        const data = await res.json();
                        const last = this.conversations[this.conversations.length - 1];
                        last.answer  = data.success ? data.answer : 'Error: ' + (data.message || 'Something went wrong.');
                        last.sources = data.success ? (data.sources || []) : [];
                    } catch (e) {
                        this.conversations[this.conversations.length - 1].answer = 'Network error. Please try again.';
                    } finally {
                        this.isTyping = false;
                        this.scrollBottom();
                    }
                },

                fmt(text) {
                    if (!text) return '<span style="color:#9ca3af;font-style:italic;font-size:12px;">Generating answer...</span>';
                    return text
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em>$1</em>')
                        .replace(/^- (.*)/gm, '<li style="margin-left:14px;list-style:disc;">$1</li>')
                        .replace(/^(\d+)\. (.*)/gm, '<li style="margin-left:14px;list-style:decimal;">$2</li>')
                        .replace(/\n\n/g, '<br><br>')
                        .replace(/\n/g, '<br>');
                },

                handleFileSelect(e) {
                    const f = e.target.files[0];
                    if (f) this.openModal(f);
                },

                openModal(file) {
                    this.selectedFile  = file;
                    this.uploadTitle   = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
                    this.uploading     = false;
                    this.uploadPct     = 0;
                    this.uploadError   = '';
                    this.uploadStatus  = 'Uploading...';
                    this.showModal     = true;
                },

                closeModal() {
                    this.showModal    = false;
                    this.uploading    = false;
                    this.uploadPct    = 0;
                    this.uploadStatus = 'Uploading...';
                    this.uploadError  = '';
                    this.selectedFile = null;
                    this.uploadTitle  = '';
                    try { if (this.$refs.fileInput) this.$refs.fileInput.value = ''; } catch (e) {}
                },

                async doUpload() {
                    if (!this.selectedFile || !this.uploadTitle.trim() || this.uploading) return;
                    this.uploading    = true;
                    this.uploadError  = '';
                    this.uploadPct    = 20;
                    this.uploadStatus = 'Uploading file...';

                    const fd = new FormData();
                    fd.append('document', this.selectedFile);
                    fd.append('title', this.uploadTitle);

                    const controller = new AbortController();
                    const timeout    = setTimeout(() => controller.abort(), 90000);

                    try {
                        this.uploadPct    = 45;
                        this.uploadStatus = 'Processing...';

                        const res  = await fetch(`/courses/${this.courseId}/notebook/upload`, {
                            method:  'POST',
                            headers: { 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                            body:    fd,
                            signal:  controller.signal,
                        });
                        clearTimeout(timeout);

                        const text = await res.text();
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            throw new Error('Server error (HTTP ' + res.status + '). Check Laravel logs.');
                        }

                        if (data.success) {
                            this.uploadPct    = 100;
                            this.uploadStatus = 'Done!';
                            this.documents.push(data.document);
                            setTimeout(() => this.closeModal(), 900);
                        } else {
                            let msg = data.message || '';
                            if (data.errors) {
                                const firstKey = Object.keys(data.errors)[0];
                                msg = data.errors[firstKey][0] || msg;
                            }
                            this.uploadError = msg || 'Upload failed (HTTP ' + res.status + '). Check Laravel logs.';
                            this.uploading   = false;
                            this.uploadPct   = 0;
                        }
                    } catch (e) {
                        clearTimeout(timeout);
                        this.uploadError  = e.name === 'AbortError'
                            ? 'Timed out after 90 seconds. Try a smaller file.'
                            : e.message;
                        this.uploading    = false;
                        this.uploadPct    = 0;
                        this.uploadStatus = 'Uploading...';
                    }
                },

                async deleteDoc(id) {
                    if (!confirm('Delete this document?')) return;
                    try {
                        await fetch(`/courses/${this.courseId}/notebook/documents/${id}`, {
                            method:  'DELETE',
                            headers: { 'X-CSRF-TOKEN': this.csrf, 'Accept': 'application/json' },
                        });
                        this.documents = this.documents.filter(d => d.id !== id);
                    } catch (e) {
                        console.error('Delete failed:', e);
                    }
                },
            };
        }
    </script>
</body>
</html>