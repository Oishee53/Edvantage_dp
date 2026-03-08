<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - Lectures</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        .heading-font { font-family: 'Playfair Display', Georgia, serif; }
        i[class^="fa-"], i[class*=" fa-"] { font-family: "Font Awesome 6 Free" !important; font-style: normal; font-weight: 900 !important; }
        body { background-color: #f9fafb; color: #333; letter-spacing: -0.01em; }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem; }

        .course-header { background: white; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .course-title { font-size: 2rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem; letter-spacing: -0.02em; line-height: 1.2; }
        .course-subtitle { color: #6b7280; font-size: 1rem; font-weight: 500; }
        .course-meta { display: flex; gap: 2rem; margin-top: 1.25rem; font-size: 0.9rem; color: #6b7280; }
        .meta-item { display: flex; align-items: center; gap: 0.625rem; font-weight: 500; }

        .tabs-container { background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .tabs { display: flex; gap: 1rem; border-bottom: 2px solid #f3f4f6; margin-bottom: 2rem; }
        .tab { padding: 0.875rem 1.5rem; font-size: 0.95rem; font-weight: 600; color: #6b7280; cursor: pointer; background: transparent; border: none; border-bottom: 2px solid transparent; margin-bottom: -2px; transition: all 0.2s; letter-spacing: -0.01em; }
        .tab.active { color: #0d7377; border-bottom-color: #0d7377; }
        .tab:hover { color: #0d7377; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .module-card { background: #f9fafb; border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.03); border: 1px solid #e5e7eb; transition: all 0.2s ease; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: space-between; }
        .module-card:hover { border-color: #0d7377; background: white; box-shadow: 0 4px 12px rgba(13,115,119,0.12); transform: translateY(-2px); }
        .module-info h3 { font-size: 1rem; font-weight: 600; color: #1f2937; margin-bottom: 0.25rem; letter-spacing: -0.01em; }
        .module-info p { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
        .module-arrow { color: #9ca3af; transition: all 0.2s; }
        .module-card:hover .module-arrow { color: #0d7377; transform: translateX(4px); }

        .session-card { background: #f9fafb; border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 0.75rem; border: 1px solid #e5e7eb; transition: all 0.2s ease; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .session-card:hover { border-color: #0d7377; background: white; box-shadow: 0 4px 12px rgba(13,115,119,0.12); }
        .session-card.is-live { border-color: #ef4444; background: #fff5f5; }
        .session-info h3 { font-size: 1rem; font-weight: 600; color: #1f2937; margin-bottom: 0.3rem; }
        .session-info p { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
        .session-badge { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.25rem 0.75rem; border-radius: 999px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; }
        .badge-live { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-ended { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .badge-scheduled { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }
        .session-btn { padding: 0.45rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; white-space: nowrap; display: inline-block; }
        .btn-join { background: #ef4444; color: white; }
        .btn-join:hover { background: #dc2626; }
        .btn-watch { background: #0d7377; color: white; }
        .btn-watch:hover { background: #0a5c5f; }
        .btn-upcoming { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; }

        .empty-state { text-align: center; padding: 4rem 2rem; }
        .empty-icon { width: 56px; height: 56px; background: #f3f4f6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.25rem; color: #9ca3af; }
        .empty-state h3 { font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.625rem; letter-spacing: -0.02em; }
        .empty-state p { color: #6b7280; font-size: 0.95rem; font-weight: 500; }

        .final-exam-card { background: #f9fafb; border-radius: 10px; padding: 1.75rem; border: 1px solid #e5e7eb; }
        .exam-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb; }
        .exam-title-section { display: flex; align-items: center; gap: 0.875rem; }
        .exam-icon { width: 40px; height: 40px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #0d7377; border: 1px solid #e5e7eb; }
        .exam-title { font-size: 1.125rem; font-weight: 700; color: #1f2937; margin: 0; letter-spacing: -0.01em; }
        .exam-subtitle { font-size: 0.85rem; color: #6b7280; margin-top: 0.2rem; font-weight: 500; }
        .exam-actions-top { display: flex; align-items: center; gap: 0.75rem; }
        .status-badge { padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; border: 1px solid; letter-spacing: -0.01em; }
        .status-not-started { background: #f9fafb; color: #6b7280; border-color: #e5e7eb; }
        .status-pending { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        .status-passed { background: #f0fdf4; color: #166534; border-color: #bbf7d0; }
        .status-failed { background: #fef2f2; color: #991b1b; border-color: #fecaca; }
        .btn-small { padding: 0.5rem 1rem; border-radius: 6px; font-weight: 600; font-size: 0.8rem; text-align: center; text-decoration: none; transition: all 0.2s; border: 2px solid; cursor: pointer; letter-spacing: -0.01em; white-space: nowrap; display: inline-block; }
        .btn-small.btn-primary { background: #0d7377; color: white; border-color: #0d7377; }
        .btn-small.btn-primary:hover { background: #0a5c5f; border-color: #0a5c5f; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(13,115,119,0.25); }
        .btn-small.btn-disabled { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; border-color: #e5e7eb; }
        .notice-box { background: white; border-left: 3px solid #0d7377; padding: 1rem; border-radius: 6px; margin-top: 1rem; border: 1px solid #e5e7eb; }
        .notice-box p { font-size: 0.8rem; color: #4b5563; line-height: 1.5; font-weight: 500; }
        .notice-box strong { color: #0d7377; font-weight: 600; }
        .submitted-info { background: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; text-align: center; border: 1px solid #e5e7eb; }
        .submitted-info p { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
        .submitted-info strong { color: #1f2937; font-size: 0.85rem; font-weight: 600; }

        /* Hybrid live class banner */
        .live-banner { border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .live-banner.is-live-now { background: #fff5f5; border: 1.5px solid #fca5a5; }
        .live-banner.is-upcoming  { background: #eff6ff; border: 1.5px solid #bfdbfe; }
        .live-banner-left { display: flex; align-items: center; gap: 0.875rem; }
        .live-banner-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .live-banner-icon.live  { background: #fee2e2; color: #ef4444; }
        .live-banner-icon.upcoming { background: #dbeafe; color: #2563eb; }
        .live-banner-title { font-size: 0.95rem; font-weight: 700; color: #1f2937; margin-bottom: 0.15rem; }
        .live-banner-meta  { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
        .btn-join-banner { padding: 0.5rem 1.25rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.2s; white-space: nowrap; display: inline-block; }
        .btn-join-banner.live     { background: #ef4444; color: white; }
        .btn-join-banner.live:hover { background: #dc2626; }
        .btn-join-banner.upcoming { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; }

        @media (max-width: 768px) {
            .container { padding: 1.5rem 1rem; }
            .course-header { padding: 1.5rem; }
            .course-title { font-size: 1.5rem; }
            .tabs-container { padding: 1rem; }
            .tabs { gap: 0.5rem; }
            .tab { padding: 0.75rem 1rem; font-size: 0.875rem; }
            .course-meta { flex-direction: column; gap: 0.625rem; }
            .exam-header { flex-wrap: wrap; gap: 0.75rem; }
            .session-card { flex-wrap: wrap; }
        }
    </style>
</head>
<body class="px-20 pt-5">
    @include('layouts.header')

    @php
    $isLiveCourse = $course->course_type === 'live';
    $isHybrid     = !$isLiveCourse; // recorded courses can have hybrid live classes

    // Upcoming / live class for hybrid recorded courses
    $upcomingLiveClass = null;
    if ($isHybrid) {
        $upcomingLiveClass = \App\Models\CourseLiveSession::where('course_id', $course->id)
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->first();
    }
@endphp

    <div class="pt-24">
        <div class="container">

            <!-- Course Header -->
            <div class="course-header">
                <h1 class="course-title heading-font">{{ $course->title }}</h1>
                <p class="course-subtitle">{{ $isLiveCourse ? 'Live Course Sessions' : 'Course Content' }}</p>
                <div class="course-meta">
                    <div class="meta-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>{{ count($modules) }} {{ $isLiveCourse ? 'Sessions' : 'Lectures' }}</span>
                    </div>
                    <div class="meta-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $isLiveCourse ? 'Live + Recorded' : 'Self-paced' }}</span>
                    </div>
                    @if($isLiveCourse)
                        <div class="meta-item">
                            <i class="fas fa-circle" style="color:#ef4444;font-size:0.6rem;"></i>
                            <span>Live Course</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Hybrid Live Class Banner (recorded courses only) ── --}}
            @if($isHybrid && $upcomingLiveClass)
                @php
                    $liveIsNow  = $upcomingLiveClass->status === 'live';
                    $liveDate   = $upcomingLiveClass->date
                        ? \Carbon\Carbon::parse($upcomingLiveClass->date)->format('d M Y')
                        : null;
                    $liveTime   = $upcomingLiveClass->start_time
                        ? \Carbon\Carbon::parse($upcomingLiveClass->start_time)->format('h:i A')
                        : null;
                    $liveDur    = $upcomingLiveClass->duration_minutes;
                @endphp
                <div class="live-banner {{ $liveIsNow ? 'is-live-now' : 'is-upcoming' }}">
                    <div class="live-banner-left">
                        <div class="live-banner-icon {{ $liveIsNow ? 'live' : 'upcoming' }}">
                            <i class="fas {{ $liveIsNow ? 'fa-broadcast-tower' : 'fa-calendar-alt' }}"></i>
                        </div>
                        <div>
                            <div class="live-banner-title">
                                @if($liveIsNow)
                                    <span style="display:inline-flex;align-items:center;gap:0.4rem;">
                                        <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;animation:ping 1s infinite;"></span>
                                        Live Class in Progress
                                    </span>
                                @else
                                    Upcoming Live Class
                                @endif
                            </div>
                            <div class="live-banner-meta">
                                {{ $upcomingLiveClass->title ?? 'Live Session ' . $upcomingLiveClass->session_number }}
                                @if($liveDate) &nbsp;·&nbsp; <i class="fas fa-calendar-alt" style="font-size:0.7rem;"></i> {{ $liveDate }} @endif
                                @if($liveTime) &nbsp;·&nbsp; <i class="fas fa-clock" style="font-size:0.7rem;"></i> {{ $liveTime }} @endif
                                @if($liveDur)  &nbsp;·&nbsp; {{ $liveDur }} mins @endif
                            </div>
                        </div>
                    </div>

                    @if($liveIsNow)
                        <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $upcomingLiveClass->session_number]) }}"
                           class="btn-join-banner live">
                            <i class="fas fa-circle" style="font-size:0.6rem;margin-right:0.3rem;"></i> Join Live
                        </a>
                    @else
                        <span class="btn-join-banner upcoming">
                            <i class="fas fa-lock" style="font-size:0.7rem;margin-right:0.3rem;"></i> Upcoming
                        </span>
                    @endif
                </div>
            @endif

            <!-- Tabs Container -->
            <div class="tabs-container">

                <!-- Tab Buttons -->
                <div class="tabs">
                    <button class="tab active" data-tab="lectures">
                        <i class="fas {{ $isLiveCourse ? 'fa-broadcast-tower' : 'fa-book-open' }}" style="margin-right:0.5rem;"></i>
                        {{ $isLiveCourse ? 'Sessions' : 'Lectures' }}
                    </button>
                
                        <button class="tab" data-tab="live-sessions">
                            <i class="fas fa-broadcast-tower" style="margin-right:0.5rem;"></i>Live Classes
                        </button>
                        <button class="tab" data-tab="final-exam">
                            <i class="fas fa-file-alt" style="margin-right:0.5rem;"></i>Final Exam
                        </button>
                        <button class="tab" data-tab="assignments">
                            <i class="fas fa-tasks" style="margin-right:0.5rem;"></i>Assignments
                        </button>
                    
                </div>

                <!-- ── Lectures / Sessions Tab ── -->
                <div class="tab-content active" id="lectures-content">
                    @if($isLiveCourse)

                        @forelse($modules as $module)
                            @php
                                $status    = $module['status'] ?? 'scheduled';
                                $isLiveNow = $status === 'live';
                                $isEnded   = $status === 'ended';
                            @endphp
                            <div class="session-card {{ $isLiveNow ? 'is-live' : '' }}">
                                <div class="session-info" style="flex:1;">
                                    <h3>{{ $module['title'] ?? 'Session ' . $module['id'] }}</h3>
                                    <p>
                                        @if($module['date'])
                                            <i class="fas fa-calendar-alt" style="margin-right:0.3rem;"></i>
                                            {{ \Carbon\Carbon::parse($module['date'])->format('d M Y') }}
                                            @if($module['start_time']) · {{ \Carbon\Carbon::parse($module['start_time'])->format('h:i A') }} @endif
                                            @if($module['duration']) · {{ $module['duration'] }} mins @endif
                                        @else
                                            <i class="fas fa-calendar-alt" style="margin-right:0.3rem;"></i>Not scheduled yet
                                        @endif
                                    </p>
                                </div>

                                @if(isset($module['pdf']))
                                    <div>
                                        <a href="{{ asset($module['pdf']) }}" target="_blank"
                                           class="text-xs text-indigo-600 hover:underline block">
                                            <i class="fas fa-file-pdf"></i> View PDF
                                        </a>
                                    </div>
                                @endif

                                <div style="display:flex;align-items:center;gap:0.75rem;">
                                    @if($isLiveNow)
                                        <span class="session-badge badge-live">
                                            <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;display:inline-block;animation:ping 1s infinite;"></span>
                                            LIVE NOW
                                        </span>
                                        <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $module['id']]) }}"
                                           class="session-btn btn-join">
                                            <i class="fas fa-circle" style="font-size:0.6rem;margin-right:0.3rem;"></i> Join Live
                                        </a>
                                    @elseif($isEnded)
                                        <span class="session-badge badge-ended">
                                            <i class="fas fa-video" style="font-size:0.65rem;"></i> Recording
                                        </span>
                                        <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $module['id']]) }}"
                                           class="session-btn btn-watch">
                                            <i class="fas fa-play" style="font-size:0.7rem;margin-right:0.3rem;"></i> Watch
                                        </a>
                                    @else
                                        <span class="session-badge badge-scheduled">
                                            <i class="fas fa-clock" style="font-size:0.65rem;"></i> Upcoming
                                        </span>
                                        <span class="session-btn btn-upcoming">
                                            <i class="fas fa-lock" style="font-size:0.7rem;margin-right:0.3rem;"></i> Upcoming
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-broadcast-tower"></i></div>
                                <h3 class="heading-font">No Sessions Yet</h3>
                                <p>Sessions will appear here once scheduled.</p>
                            </div>
                        @endforelse

                    @else

                        @forelse($modules as $moduleNumber)
                            <a href="{{ route('inside.module', ['courseId' => $course->id, 'moduleNumber' => $moduleNumber]) }}"
                               class="module-card">
                                <div class="module-info">
                                    <h3>Lecture {{ $moduleNumber }}</h3>
                                    <p>Click to access lecture content</p>
                                </div>
                                <svg class="module-arrow" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="heading-font">No Lectures Available</h3>
                                <p>This course doesn't have any lectures yet.</p>
                            </div>
                        @endforelse

                    @endif
                </div>{{-- /#lectures-content --}}

                    <!-- ── Live Sessions Tab (hybrid: recorded courses with live classes) ── -->
                    <div class="tab-content" id="live-sessions-content">
                        @if($isHybrid)
                            @php
                                $hybridSessions = \App\Models\CourseLiveSession::where('course_id', $course->id)
                                    ->orderBy('date')
                                    ->orderBy('start_time')
                                    ->get();
                            @endphp

                            @if($hybridSessions->count() > 0)
                                @foreach($hybridSessions as $hs)
                                    @php
                                        $hsLive   = $hs->status === 'live';
                                        $hsEnded  = $hs->status === 'ended';
                                        $hsDate   = $hs->date ? \Carbon\Carbon::parse($hs->date)->format('d M Y') : null;
                                        $hsTime   = $hs->start_time ? \Carbon\Carbon::parse($hs->start_time)->format('h:i A') : null;
                                    @endphp
                                    <div class="session-card {{ $hsLive ? 'is-live' : '' }}">
                                        <div class="session-info" style="flex:1;">
                                            <h3>{{ $hs->title ?? 'Live Session ' . $hs->session_number }}</h3>
                                            <p>
                                                @if($hsDate)
                                                    <i class="fas fa-calendar-alt" style="margin-right:0.3rem;"></i>
                                                    {{ $hsDate }}
                                                    @if($hsTime) &nbsp;·&nbsp; {{ $hsTime }} @endif
                                                    @if($hs->duration_minutes) &nbsp;·&nbsp; {{ $hs->duration_minutes }} mins @endif
                                                @else
                                                    <i class="fas fa-calendar-alt" style="margin-right:0.3rem;"></i>Not scheduled yet
                                                @endif
                                            </p>
                                        </div>

                                        <div style="display:flex;align-items:center;gap:0.75rem;">
                                            @if($hsLive)
                                                <span class="session-badge badge-live">
                                                    <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;display:inline-block;animation:ping 1s infinite;"></span>
                                                    LIVE NOW
                                                </span>
                                                <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $hs->session_number]) }}"
                                                   class="session-btn btn-join">
                                                    <i class="fas fa-circle" style="font-size:0.6rem;margin-right:0.3rem;"></i> Join Live
                                                </a>
                                            @elseif($hsEnded)
                                                <span class="session-badge badge-ended">
                                                    <i class="fas fa-video" style="font-size:0.65rem;"></i> Recording
                                                </span>
                                                <a href="{{ route('student.live_session.watch', ['course' => $course->id, 'session' => $hs->session_number]) }}"
                                                   class="session-btn btn-watch">
                                                    <i class="fas fa-play" style="font-size:0.7rem;margin-right:0.3rem;"></i> Watch
                                                </a>
                                            @else
                                                <span class="session-badge badge-scheduled">
                                                    <i class="fas fa-clock" style="font-size:0.65rem;"></i> Upcoming
                                                </span>
                                                <span class="session-btn btn-upcoming">
                                                    <i class="fas fa-lock" style="font-size:0.7rem;margin-right:0.3rem;"></i> Upcoming
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="fas fa-broadcast-tower"></i></div>
                                    <h3 class="heading-font">No Live Classes Yet</h3>
                                    <p>Live classes will appear here once scheduled by your instructor.</p>
                                </div>
                            @endif
                        @endif
                    </div>{{-- /#live-sessions-content --}}

                    <!-- ── Final Exam Tab ── -->
                    <div class="tab-content" id="final-exam-content">
                        @php
                            $finalExam  = \App\Models\FinalExam::where('course_id', $course->id)->where('status','published')->first();
                            $submission = null;
                            if ($finalExam && auth()->check()) {
                                $submission = \App\Models\FinalExamSubmission::where('final_exam_id', $finalExam->id)
                                    ->where('user_id', auth()->id())->first();
                            }
                        @endphp

                        @if($finalExam)
                            <div class="final-exam-card">
                                <div class="exam-header">
                                    <div class="exam-title-section">
                                        <div class="exam-icon">
                                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="exam-title heading-font">Final Exam</h3>
                                            <p class="exam-subtitle">{{ $finalExam->title }}</p>
                                        </div>
                                    </div>
                                    <div class="exam-actions-top">
                                        @if($submission)
                                            @if(in_array($submission->status, ['not_started','in_progress']))
                                                <span class="status-badge status-not-started">Not Completed</span>
                                            @elseif($submission->status === 'submitted')
                                                <span class="status-badge status-pending">Awaiting Grading</span>
                                            @elseif($submission->status === 'graded')
                                                @if($submission->percentage >= 70)
                                                    <span class="status-badge status-passed">Passed · {{ number_format($submission->percentage,0) }}%</span>
                                                @else
                                                    <span class="status-badge status-failed">Failed · {{ number_format($submission->percentage,0) }}%</span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="status-badge status-not-started">Not Started</span>
                                        @endif

                                        @if(!$submission || $submission->status === 'not_started')
                                            <a href="{{ route('student.final-exam.show', $course->id) }}" class="btn-small btn-primary">Start Exam</a>
                                        @elseif($submission->status === 'in_progress')
                                            <a href="{{ route('student.final-exam.start', $finalExam->id) }}" class="btn-small btn-primary">Continue</a>
                                        @elseif($submission->status === 'submitted')
                                            <button class="btn-small btn-disabled" disabled>Pending</button>
                                        @elseif($submission->status === 'graded')
                                            <a href="{{ route('student.final-exam.result', $submission->id) }}" class="btn-small btn-primary">View Results</a>
                                        @endif
                                    </div>
                                </div>

                                @if($submission && $submission->status === 'submitted')
                                    <div class="submitted-info">
                                        <p>Submitted on <strong>{{ $submission->submitted_at->format('M d, Y - g:i A') }}</strong></p>
                                    </div>
                                @endif

                                @if(!$submission || $submission->status === 'not_started')
                                    <div class="notice-box">
                                        <p><strong>Note:</strong> Complete all lectures before attempting the final exam. Upload photos of handwritten answers. Passing score: 70%.</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="heading-font">No Final Exam Available</h3>
                                <p>The final exam has not been published yet.</p>
                            </div>
                        @endif
                    </div>{{-- /#final-exam-content --}}

                    <!-- ── Assignments Tab ── -->
                    <div class="tab-content" id="assignments-content">
                        @php
                            $assignments = \App\Models\Assignment::where('course_id', $course->id)->latest()->get();
                        @endphp

                        @if($assignments->count() > 0)
                            @foreach($assignments as $assignment)
                                <a href="{{ route('assignment.show', $assignment->id) }}"
                                   style="text-decoration:none;display:block;margin-bottom:1rem;">
                                    <div class="final-exam-card" style="cursor:pointer;transition:all 0.2s;">
                                        <div class="exam-header">
                                            <div class="exam-title-section">
                                                <div class="exam-icon">
                                                    <i class="fas fa-tasks"></i>
                                                </div>
                                                <div>
                                                    <h3 class="exam-title heading-font">{{ $assignment->title }}</h3>
                                                    <p class="exam-subtitle">{{ $assignment->description }}</p>
                                                </div>
                                            </div>
                                            <span class="btn-small btn-primary">View</span>
                                        </div>
                                        <div class="notice-box">
                                            <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($assignment->deadline)->format('M d, Y - g:i A') }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-tasks"></i></div>
                                <h3 class="heading-font">No Assignments Available</h3>
                                <p>This course doesn't have any assignments yet.</p>
                            </div>
                        @endif
                    </div>{{-- /#assignments-content --}}

                {{-- @if(!$isLiveCourse) --}}

            </div>{{-- /.tabs-container --}}
        </div>{{-- /.container --}}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs        = document.querySelectorAll('.tab');
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
        });
    </script>
</body>
</html>