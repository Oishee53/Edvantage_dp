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
        .main-container { display: grid; grid-template-columns: 1fr 380px; gap: 2rem; max-width: 1400px; margin: 0 auto; padding: 2rem 1.5rem; }
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

        /* NOTEBOOK SIDEBAR */
        .notebook-sidebar { position: sticky; top: 2rem; height: calc(100vh - 6rem); display: flex; flex-direction: column; background: white; border-radius: 16px; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); overflow: hidden; }
        .nb-header { background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); padding: 16px 18px; flex-shrink: 0; }
        .nb-header-top { display: flex; align-items: center; justify-content: space-between; }
        .nb-title { display: flex; align-items: center; gap: 10px; }
        .nb-avatar { width: 34px; height: 34px; background: rgba(255,255,255,0.2); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 15px; color: white; }
        .nb-title h3 { color: white; font-weight: 700; font-size: 15px; margin: 0; }
        .nb-title p { color: rgba(255,255,255,0.7); font-size: 11px; margin: 0; }
        .nb-upload-btn { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 8px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s; }
        .nb-upload-btn:hover { background: rgba(255,255,255,0.28); }
        .nb-docs-bar { background: linear-gradient(135deg, #0f766e, #0d9488); padding: 8px 14px; display: flex; flex-wrap: wrap; gap: 5px; flex-shrink: 0; border-top: 1px solid rgba(255,255,255,0.15); }
        .nb-doc-pill { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); border-radius: 100px; padding: 3px 8px; display: flex; align-items: center; gap: 5px; font-size: 11px; color: white; font-weight: 500; }
        .nb-doc-pill .del { cursor: pointer; opacity: 0.6; transition: opacity 0.15s; font-size: 10px; }
        .nb-doc-pill .del:hover { opacity: 1; }
        .nb-doc-pill.processing { opacity: 0.6; }
        .nb-messages { flex: 1; overflow-y: auto; padding: 14px 16px; display: flex; flex-direction: column; gap: 12px; scroll-behavior: smooth; }
        .nb-welcome { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 20px; color: #9ca3af; }
        .nb-welcome-icon { width: 52px; height: 52px; background: linear-gradient(135deg, #ccfbf1, #99f6e4); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 12px; box-shadow: 0 4px 16px rgba(13,148,136,0.15); }
        .nb-welcome h4 { font-size: 15px; font-weight: 700; color: #1f2937; margin: 0 0 6px; }
        .nb-welcome p { font-size: 12px; line-height: 1.5; margin: 0; }
        .nb-suggestions { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; margin-top: 14px; }
        .nb-pill { background: white; border: 1px solid #e5e7eb; border-radius: 100px; padding: 5px 11px; font-size: 11px; cursor: pointer; transition: all 0.15s; color: #374151; font-weight: 500; }
        .nb-pill:hover { border-color: #0d9488; color: #0d9488; background: #f0fdfa; }
        .nb-msg-row { display: flex; gap: 8px; animation: nbSlide 0.25s ease; }
        @keyframes nbSlide { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .nb-msg-row.user { flex-direction: row-reverse; }
        .nb-msg-avatar { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0; }
        .nb-msg-avatar.user { background: #0d9488; color: white; }
        .nb-msg-avatar.ai { background: #1a1a2e; color: white; font-size: 10px; }
        .nb-bubble { padding: 9px 12px; border-radius: 12px; font-size: 13px; line-height: 1.6; max-width: calc(100% - 40px); }
        .nb-bubble.user { background: #0d9488; color: white; border-bottom-right-radius: 3px; }
        .nb-bubble.ai { background: #f9fafb; border: 1px solid #e5e7eb; color: #1f2937; border-bottom-left-radius: 3px; }
        .nb-bubble.ai strong { color: #0f766e; }
        .nb-bubble.ai ul, .nb-bubble.ai ol { margin: 5px 0 5px 16px; }
        .nb-bubble.ai li { margin-bottom: 2px; }
        .nb-sources-toggle { font-size: 10px; color: #0d9488; cursor: pointer; margin-top: 5px; display: inline-flex; align-items: center; gap: 3px; font-weight: 600; }
        .nb-sources-panel { margin-top: 5px; background: #f0fdfa; border: 1px solid #99f6e4; border-radius: 8px; padding: 8px 10px; font-size: 11px; color: #4b5563; line-height: 1.5; }
        .nb-typing { display: flex; gap: 4px; padding: 10px 14px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; border-bottom-left-radius: 3px; width: fit-content; }
        .nb-dot { width: 6px; height: 6px; background: #9ca3af; border-radius: 50%; animation: nbBounce 1.2s infinite; }
        .nb-dot:nth-child(2) { animation-delay: 0.2s; }
        .nb-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes nbBounce { 0%, 60%, 100% { transform: translateY(0); } 30% { transform: translateY(-5px); } }
        .nb-input-bar { padding: 12px 14px; border-top: 1px solid #f3f4f6; flex-shrink: 0; background: white; }
        .nb-input-wrap { display: flex; align-items: flex-end; gap: 8px; background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 12px; padding: 8px 10px; transition: border-color 0.2s; }
        .nb-input-wrap:focus-within { border-color: #0d9488; }
        .nb-textarea { flex: 1; border: none; background: transparent; outline: none; font-family: 'Inter', sans-serif; font-size: 13px; color: #1f2937; resize: none; line-height: 1.5; max-height: 100px; overflow-y: auto; }
        .nb-textarea::placeholder { color: #9ca3af; }
        .nb-send { width: 32px; height: 32px; background: #0d9488; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 12px; transition: background 0.15s; flex-shrink: 0; }
        .nb-send:hover { background: #0f766e; }
        .nb-send:disabled { background: #d1d5db; cursor: not-allowed; }
        .nb-hint { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 6px; }
        .nb-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 9999; }
        .nb-modal { background: white; border-radius: 18px; padding: 24px; width: 420px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
        .nb-messages::-webkit-scrollbar { width: 4px; }
        .nb-messages::-webkit-scrollbar-track { background: transparent; }
        .nb-messages::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
        @media (max-width: 1024px) { .main-container { grid-template-columns: 1fr; } .notebook-sidebar { position: static; height: 600px; } }
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

            <!-- RIGHT SIDEBAR — AI NOTEBOOK -->
            @auth
            <div x-data="notebookPanel()" x-init="init()" class="notebook-sidebar">

                <!-- Header: just title + upload button, nothing else -->
                <div class="nb-header">
                    <div class="nb-header-top">
                        <div class="nb-title">
                            <div class="nb-avatar">🤖</div>
                            <div>
                                <h3>AI Study Assistant</h3>
                                <p>Powered by Gemini · Free</p>
                            </div>
                        </div>
                        {{-- Hidden file input --}}
                        <input type="file" x-ref="fileInput" accept=".pdf,.txt,.docx" style="display:none;" @change="handleFileSelect($event)">
                        <button class="nb-upload-btn" @click="$refs.fileInput.click()">
                            <i class="fas fa-file-upload"></i> Upload
                        </button>
                    </div>
                </div>

                <!-- Doc pills — only visible when documents exist -->
                <template x-if="documents.length > 0">
                    <div class="nb-docs-bar">
                        <template x-for="doc in documents" :key="doc.id">
                            <div class="nb-doc-pill" :class="{ processing: doc.status !== 'ready' }">
                                <i :class="doc.file_type === 'pdf' ? 'fas fa-file-pdf' : 'fas fa-file-alt'" style="font-size:9px;"></i>
                                <span x-text="doc.title.length > 16 ? doc.title.substring(0,16)+'…' : doc.title"></span>
                                <span class="del" @click.stop="deleteDoc(doc.id)">✕</span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Messages -->
                <div class="nb-messages" x-ref="messages">
                    <template x-if="conversations.length === 0 && !isTyping">
                        <div class="nb-welcome">
                            <div class="nb-welcome-icon">📚</div>
                            <h4>Ask About This Lecture</h4>
                            <p>Type a question below. Upload your notes first for answers grounded in your own materials.</p>
                            <div class="nb-suggestions">
                                <div class="nb-pill" @click="ask('Summarize the key concepts')">💡 Key concepts</div>
                                <div class="nb-pill" @click="ask('What should I focus on for the exam?')">🎯 Exam focus</div>
                                <div class="nb-pill" @click="ask('Create a quick study guide')">📝 Study guide</div>
                                <div class="nb-pill" @click="ask('Explain the most difficult topic')">🧠 Hard topics</div>
                            </div>
                        </div>
                    </template>

                    <template x-for="(msg, i) in conversations" :key="i">
                        <div>
                            <div class="nb-msg-row user" style="margin-bottom:8px;">
                                <div class="nb-msg-avatar user">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                <div class="nb-bubble user" x-text="msg.question"></div>
                            </div>
                            <div class="nb-msg-row ai">
                                <div class="nb-msg-avatar ai"><i class="fas fa-robot"></i></div>
                                <div>
                                    <div class="nb-bubble ai" x-html="fmt(msg.answer)"></div>
                                    <template x-if="msg.sources && msg.sources.length">
                                        <div>
                                            <div class="nb-sources-toggle" @click="msg.showSrc = !msg.showSrc">
                                                <i :class="msg.showSrc ? 'fas fa-chevron-down' : 'fas fa-chevron-right'"></i>
                                                <span x-text="msg.sources.length + ' source(s)'"></span>
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
                    <div class="nb-input-wrap">
                        <textarea class="nb-textarea" x-model="question" placeholder="Ask about this lecture..." rows="1"
                            @keydown.enter.prevent="!$event.shiftKey && sendQuestion()"
                            @input="autoResize($event)" :disabled="isTyping"></textarea>
                        <button class="nb-send" @click="sendQuestion()" :disabled="!question.trim() || isTyping">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                    <p class="nb-hint">Enter to send · Shift+Enter for new line</p>
                </div>

                <!-- Upload Modal inside x-data context -->
                <div class="nb-modal-overlay" x-show="showModal" x-transition
                     @click.self="closeModal()" @keydown.escape.window="showModal && closeModal()">
                <div class="nb-modal" @click.stop>

                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                        <div style="width:42px;height:42px;background:#f0fdfa;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;">📤</div>
                        <div style="flex:1;">
                            <h3 style="margin:0;font-weight:700;color:#1f2937;font-size:16px;">Upload Document</h3>
                            <p style="margin:0;font-size:12px;color:#6b7280;" x-text="selectedFile ? selectedFile.name : ''"></p>
                        </div>
                        <button @click="closeModal()"
                            style="width:30px;height:30px;border-radius:50%;border:1px solid #e5e7eb;background:white;cursor:pointer;font-size:16px;color:#6b7280;display:flex;align-items:center;justify-content:center;flex-shrink:0;">✕</button>
                    </div>

                    <div style="margin-bottom:14px;">
                        <label style="display:block;font-size:13px;font-weight:600;color:#1f2937;margin-bottom:6px;">Document Title</label>
                        <input type="text" x-model="uploadTitle"
                            style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:10px 12px;font-size:13px;outline:none;font-family:inherit;box-sizing:border-box;"
                            placeholder="e.g. Week 3 Lecture Notes"
                            @focus="$event.target.style.borderColor='#0d9488'"
                            @blur="$event.target.style.borderColor='#e5e7eb'">
                    </div>

                    <!-- Progress bar -->
                    <div x-show="uploading" style="margin-bottom:14px;">
                        <div style="display:flex;justify-content:space-between;font-size:11px;color:#6b7280;margin-bottom:4px;">
                            <span x-text="uploadStatus"></span>
                            <span x-text="uploadPct + '%'"></span>
                        </div>
                        <div style="height:6px;background:#f3f4f6;border-radius:100px;overflow:hidden;">
                            <div style="height:100%;background:#0d9488;border-radius:100px;transition:width 0.4s;" :style="'width:'+uploadPct+'%'"></div>
                        </div>
                    </div>

                    <!-- Inline error -->
                    <div x-show="uploadError" style="margin-bottom:14px;background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:10px 12px;font-size:12px;color:#991b1b;display:flex;gap:8px;">
                        <i class="fas fa-exclamation-triangle" style="margin-top:1px;flex-shrink:0;"></i>
                        <span x-text="uploadError"></span>
                    </div>

                    <div style="background:#f0fdfa;border:1px solid #ccfbf1;border-radius:10px;padding:10px 12px;margin-bottom:16px;font-size:12px;color:#0f766e;display:flex;gap:8px;">
                        <i class="fas fa-info-circle" style="margin-top:1px;"></i>
                        <span>PDF, TXT, DOCX · max 20MB · Processing takes 10–30s</span>
                    </div>

                    <div style="display:flex;gap:10px;">
                        <button @click="closeModal()"
                            style="flex:1;padding:10px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:13px;font-weight:600;color:#4b5563;cursor:pointer;background:white;">Cancel</button>
                        <button @click="doUpload()" :disabled="!uploadTitle.trim() || uploading"
                            :style="(!uploadTitle.trim()||uploading)?'opacity:0.55;cursor:not-allowed;':''"
                            style="flex:1;padding:10px;background:#0d9488;color:white;border:none;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;">
                            <i class="fas fa-upload" style="margin-right:5px;"></i>
                            <span x-text="uploading ? 'Processing...' : 'Upload & Process'"></span>
                        </button>
                    </div>
                </div>
                </div>{{-- end modal overlay --}}

            </div>{{-- end x-data notebook sidebar --}}

            @else
            <div class="notebook-sidebar" style="align-items:center;justify-content:center;text-align:center;padding:30px;">
                <div style="width:52px;height:52px;background:#f0fdfa;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 14px;">🔒</div>
                <h4 style="font-weight:700;color:#1f2937;margin:0 0 8px;">AI Study Assistant</h4>
                <p style="font-size:13px;color:#6b7280;margin:0 0 16px;">Log in to access your personal AI notebook.</p>
                <a href="/login" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#0d9488;color:white;border-radius:9px;font-weight:600;font-size:13px;text-decoration:none;">
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
                    e.target.style.height = Math.min(e.target.scrollHeight, 100) + 'px';
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
                        last.answer  = data.success ? data.answer : '⚠️ ' + (data.message || 'Something went wrong.');
                        last.sources = data.success ? (data.sources || []) : [];
                    } catch (e) {
                        this.conversations[this.conversations.length - 1].answer = '⚠️ Network error. Please try again.';
                    } finally {
                        this.isTyping = false;
                        this.scrollBottom();
                    }
                },

                fmt(text) {
                    if (!text) return '<span style="color:#9ca3af;font-style:italic;">Generating answer...</span>';
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
                            // Handle Laravel validation errors (errors object) and plain message
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