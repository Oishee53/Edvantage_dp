<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - EDVANTAGE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }
        
        .course-card {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .course-card:hover {
            transform: translateY(-2px);
        }
        
        .course-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.1) 100%);
        }
        
        .progress-ring {
            transition: stroke-dashoffset 0.5s ease;
        }
    </style>
</head>
<body class="bg-gray-50 px-20 pt-5">
    @include('layouts.header')

    <main class="pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Calendar Section -->
        <div class="mt-16">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                <i class="fas fa-calendar-alt text-teal-600 mr-2"></i>My Schedule
            </h2>

            <div class="flex flex-col lg:flex-row gap-6 items-start">

                <!-- Calendar -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 w-full lg:w-auto lg:flex-shrink-0" style="min-width:340px;">
                    <!-- Legend -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>
                            <span class="text-xs text-gray-500">Live Class</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-3 h-3 rounded-full bg-orange-400 inline-block"></span>
                            <span class="text-xs text-gray-500">Deadline</span>
                        </div>
                    </div>

                    <!-- Month/Year Header -->
                    <div class="flex items-center justify-between mb-4">
                        <button onclick="prevMonth()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                            <i class="fas fa-chevron-left text-gray-500 text-xs"></i>
                        </button>
                        <h3 id="cal-title" class="text-sm font-semibold text-gray-800"></h3>
                        <button onclick="nextMonth()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition">
                            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                        </button>
                    </div>

                    <!-- Day Headers -->
                    <div class="grid grid-cols-7 mb-2">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $d)
                        <div class="text-center text-xs font-medium text-gray-400 py-1">{{ $d }}</div>
                        @endforeach
                    </div>

                    <!-- Calendar Grid -->
                    <div id="cal-grid" class="grid grid-cols-7 gap-y-1"></div>

                    <!-- Tooltip -->
                    <div id="cal-tooltip"
                         class="hidden absolute z-50 bg-white border border-gray-200 rounded-xl shadow-xl p-3 w-64 text-xs"
                         style="pointer-events:none;">
                    </div>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex-1 w-full">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-teal-500"></i> Upcoming Events
                        <span class="text-xs text-gray-400 font-normal">(next 7 days)</span>
                    </h4>
                    <div id="upcoming-list" class="space-y-3"></div>
                </div>

            </div>
        </div>
            
            <!-- Recent Activity Section (Only courses with progress > 0) -->
            @php
                $recentCourses = collect($enrolledCourses)->filter(function($course) use ($courseProgress) {
                    $progress = $courseProgress[$course->id] ?? ['completion_percentage' => 0];
                    return $progress['completion_percentage'] > 0;
                });
            @endphp

            @if($recentCourses->count() > 0)
            <div class="mb-16">
                <h2 class="text-2xl font-semibold text-gray-900 mb-8">Recent activity</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recentCourses as $course)
                        @php
                            $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
                        @endphp

                        <a href="{{ route('user.course.modules', $course->id) }}" class="course-card block rounded-2xl overflow-hidden shadow-md hover:shadow-xl group">
                            <!-- Course Image with Overlay -->
                            <div class="relative h-72">
                                <img src="{{ asset('storage/' . $course->image) }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-full h-full object-cover">
                                
                                <!-- Gradient Overlay -->
                                <div class="course-overlay absolute inset-0"></div>
                                
                                <!-- Content Overlay -->
                                <div class="absolute inset-0 p-6 flex flex-col justify-between">
                                    <!-- Top Section -->
                                    <div class="flex items-start justify-between">
                                        <!-- Progress Badge -->
                                        @if($progress['completion_percentage'] == 100)
                                        <div class="flex items-center gap-2 bg-green-500/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                            <i class="fas fa-check text-white text-xs"></i>
                                            
                                        </div>
                                        @else
                                        <div class="flex items-center gap-2 bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                                            <span class="text-xs font-semibold text-gray-700">Continue Course</span>
                                        </div>
                                        @endif
                                        
                                        <!-- Play Button -->
                                        <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center group-hover:bg-white/30 transition-colors">
                                            <i class="fas fa-play text-white text-sm ml-0.5"></i>
                                        </div>
                                    </div>

                                    <!-- Bottom Section -->
                                    <div>
                                        <h3 class="text-white font-semibold text-lg mb-2 line-clamp-2 leading-snug">
                                            {{ $course->title }}
                                        </h3>
                                        
                                        <!-- Progress Info -->
                                        <div class="flex items-center justify-between text-white/90 text-xs mb-2">
                                            <span>Completed {{ $progress['completed_videos'] ?? 0 }}/{{ $progress['total_videos'] ?? 0 }}</span>
                                        </div>
                                        
                                        <!-- Progress Bar -->
                                        <div class="h-1 bg-white/20 rounded-full overflow-hidden">
                                            <div class="h-full bg-white rounded-full transition-all duration-1000" 
                                                 style="width: {{ $progress['completion_percentage'] ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- All Courses Section -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-8">My Courses</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @forelse ($enrolledCourses as $course)
                        @php
                            $progress = $courseProgress[$course->id] ?? ['completed_videos' => 0, 'total_videos' => 0, 'completion_percentage' => 0];
                        @endphp
                        
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <a href="{{ route('user.course.modules', $course->id) }}" class="block">
                                <!-- Course Thumbnail -->
                                <div class="relative h-40">
                                    <img src="{{ asset('storage/' . $course->image) }}" 
                                         alt="{{ $course->title }}" 
                                         class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                    
                                    <!-- Play Button -->
                                    <div class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center">
                                        <i class="fas fa-play text-gray-700 text-xs ml-0.5"></i>
                                    </div>
                                    
                                    <!-- Step Info -->
                                    <div class="absolute bottom-2 left-2 text-white text-xs font-medium">
                                        Step {{ $progress['completed_videos'] ?? 0 }}/{{ $progress['total_videos'] ?? 0 }}
                                    </div>
                                </div>
                                
                                <!-- Course Info -->
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 text-sm mb-2 line-clamp-2 leading-tight">
                                        {{ $course->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        Course, {{ $course->total_duration ?? '0' }} hours
                                    </p>
                                </div>
                            </a>
                        </div>

                    @empty
                        <!-- Empty State -->
                        <div class="col-span-full bg-white rounded-2xl shadow-md p-16">
                            <div class="text-center max-w-md mx-auto">
                                <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-book-open text-4xl text-gray-300"></i>
                                </div>
                                
                                <h3 class="text-2xl font-semibold text-gray-900 mb-3">No courses yet</h3>
                                <p class="text-gray-500 mb-8 text-sm">
                                    Start your learning journey by enrolling in a course
                                </p>
                                
                                <a href="/homepage" 
                                   class="inline-block px-8 py-3 bg-teal-600 text-white text-sm font-medium rounded-xl hover:bg-teal-700 transition-colors">
                                    Browse Courses
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        
    </main>

    <script>
        // Smooth progress bar animation on load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.bg-white.rounded-full');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
    <script>
    // Progress bar animation
    window.addEventListener('load', function() {
        const progressBars = document.querySelectorAll('.bg-white.rounded-full');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => { bar.style.width = width; }, 100);
        });
    });

    // Calendar data from Laravel
    const calendarEvents = @json($calendarEvents);

    // Group events by date
    const eventsByDate = {};
    calendarEvents.forEach(ev => {
        if (!eventsByDate[ev.date]) eventsByDate[ev.date] = [];
        eventsByDate[ev.date].push(ev);
    });

    let currentYear, currentMonth;

    function renderCalendar(year, month) {
        currentYear = year;
        currentMonth = month;

        const months = ['January','February','March','April','May','June',
                        'July','August','September','October','November','December'];
        document.getElementById('cal-title').textContent = months[month] + ' ' + year;

        const grid = document.getElementById('cal-grid');
        grid.innerHTML = '';

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            grid.innerHTML += `<div></div>`;
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = year + '-' + String(month + 1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
            const events  = eventsByDate[dateStr] || [];
            const hasLive = events.some(e => e.type === 'live');
            const hasDead = events.some(e => e.type === 'deadline');
            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;

            let dots = '';
            if (hasLive) dots += `<span class="w-1.5 h-1.5 rounded-full bg-blue-500 inline-block"></span>`;
            if (hasDead) dots += `<span class="w-1.5 h-1.5 rounded-full bg-orange-400 inline-block"></span>`;

            const hasEvent = events.length > 0;

            grid.innerHTML += `
                <div class="relative flex flex-col items-center py-1 group"
                     ${hasEvent ? `data-date="${dateStr}"` : ''}>
                    <span class="w-8 h-8 flex items-center justify-center rounded-full text-xs font-medium
                        ${isToday ? 'bg-teal-600 text-white' : hasEvent ? 'hover:bg-gray-100 cursor-pointer text-gray-800' : 'text-gray-400'}
                        transition">
                        ${d}
                    </span>
                    <div class="flex gap-0.5 mt-0.5 h-2">${dots}</div>
                    ${hasEvent ? `
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block z-50
                                bg-white border border-gray-200 rounded-xl shadow-xl p-3 w-56 text-xs pointer-events-none"
                         style="min-width:200px;">
                        ${events.map(ev => `
                            <div class="mb-2 last:mb-0 flex items-start gap-2">
                                <span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 ${ev.type === 'live' ? 'bg-blue-500' : 'bg-orange-400'}"></span>
                                <div>
                                    <p class="font-semibold text-gray-800">${ev.title}</p>
                                    <p class="text-gray-500">${ev.type === 'live' ? '🎥 Live · ' + ev.time + (ev.duration ? ' · ' + ev.duration : '') : '⏰ Deadline · ' + ev.time}</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>` : ''}
                </div>`;
        }

        renderUpcoming();
    }

    function renderUpcoming() {
        const now   = new Date();
        const seven = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
        const list  = document.getElementById('upcoming-list');

        const upcoming = calendarEvents
            .filter(ev => {
                const d = new Date(ev.date + 'T' + (ev.time ? convertTo24(ev.time) : '00:00'));
                return d >= now && d <= seven;
            })
            .sort((a, b) => new Date(a.date) - new Date(b.date));

        if (upcoming.length === 0) {
            list.innerHTML = `<div class="text-center py-8 text-gray-400">
                <i class="fas fa-calendar-check text-3xl mb-2"></i>
                <p class="text-sm">No events in the next 7 days</p>
            </div>`;
            return;
        }

        list.innerHTML = upcoming.map(ev => `
            <div class="flex items-start gap-3 p-3 rounded-xl border ${ev.type === 'live' ? 'border-blue-100 bg-blue-50' : 'border-orange-100 bg-orange-50'}">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${ev.type === 'live' ? 'bg-blue-500' : 'bg-orange-400'}">
                    <i class="fas ${ev.type === 'live' ? 'fa-video' : 'fa-exclamation-circle'} text-white text-xs"></i>
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-xs">${ev.title}</p>
                    <p class="text-gray-500 text-xs mt-0.5">
                        ${formatDate(ev.date)} · ${ev.time}
                        ${ev.duration ? ' · ' + ev.duration : ''}
                    </p>
                </div>
            </div>
        `).join('');
    }

    function convertTo24(time12) {
        const [time, modifier] = time12.split(' ');
        let [hours, minutes] = time.split(':');
        if (modifier === 'PM' && hours !== '12') hours = parseInt(hours) + 12;
        if (modifier === 'AM' && hours === '12') hours = '00';
        return String(hours).padStart(2,'0') + ':' + minutes;
    }

    function formatDate(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }

    function prevMonth() {
        let m = currentMonth - 1, y = currentYear;
        if (m < 0) { m = 11; y--; }
        renderCalendar(y, m);
    }

    function nextMonth() {
        let m = currentMonth + 1, y = currentYear;
        if (m > 11) { m = 0; y++; }
        renderCalendar(y, m);
    }

    const now = new Date();
    renderCalendar(now.getFullYear(), now.getMonth());
</script>
</body>
</html>