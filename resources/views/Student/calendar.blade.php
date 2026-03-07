<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Calendar - Live Classes & Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <style>
        .fc-daygrid-event {
            white-space: normal !important;
            cursor: pointer;
        }
        
        .fc-event {
            border-radius: 6px;
            padding: 2px 4px !important;
        }
        
        .fc-event-title {
            font-weight: 600;
            font-size: 13px !important;
        }
        
        .fc-col-time-frame {
            background-color: #f9fafb;
        }
        
        .fc-daygrid {
            border-color: #e5e7eb;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif'],
                },
            }
        }
    }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }"
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
             :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">

            <!-- Header -->
            @include('components.instructor-header', ['title' => 'Calendar'])

            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-6">
                <div class="max-w-7xl mx-auto">

                    <!-- Page Title with Info -->
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-1">
                            <i class="fas fa-calendar-alt text-teal-600"></i>
                            My Calendar
                        </h3>
                        <p class="text-sm text-gray-500">View your live class schedule and upcoming events</p>
                    </div>

                    <!-- Legend -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2 p-3 bg-white rounded-lg border border-gray-200">
                            <div class="w-3 h-3 rounded bg-red-600"></div>
                            <span class="text-sm text-gray-700"><strong>LIVE NOW</strong> - Active sessions</span>
                        </div>
                        <div class="flex items-center gap-2 p-3 bg-white rounded-lg border border-gray-200">
                            <div class="w-3 h-3 rounded bg-blue-600"></div>
                            <span class="text-sm text-gray-700"><strong>SCHEDULED</strong> - Upcoming live classes</span>
                        </div>
                        <div class="flex items-center gap-2 p-3 bg-white rounded-lg border border-gray-200">
                            <div class="w-3 h-3 rounded bg-orange-500"></div>
                            <span class="text-sm text-gray-700"><strong>DEADLINES</strong> - Assignment due dates</span>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-6">

                        <!-- Calendar -->
                        <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-200 p-4 lg:p-6">
                            <div id="calendar" class="calendar-container"></div>
                        </div>

                        <!-- Upcoming Events Sidebar -->
                        <div class="w-full lg:w-80 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-blue-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-clock text-teal-600"></i>
                                    Upcoming Events
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">Next 7 days</p>
                            </div>
                            <div class="flex-1 p-4 overflow-y-auto" style="max-height: 600px;">
                                <div id="upcoming-events" class="space-y-3"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                height: 'auto',
                contentHeight: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: '/calendar-events',

                eventContent: function(arg) {
                    let title = arg.event.title;
                    let time = arg.event.start ? arg.event.start.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
                    }) : '';
                    
                    let icon = 'fa-calendar-alt';
                    if (title.startsWith('LIVE:')) {
                        icon = 'fa-video';
                    } else if (title.startsWith('DEADLINE:')) {
                        icon = 'fa-exclamation-circle';
                    }

                    return {
                        html: `<div style="padding: 4px; font-size: 12px; line-height: 1.3;">
                                <div style="font-weight: 600;">
                                    <i class="fas ${icon}" style="font-size: 10px; margin-right: 4px;"></i>${title}
                                </div>
                                <div style="font-size: 11px; opacity: 0.8; margin-top: 2px;">${time}</div>
                              </div>`
                    };
                },

                eventClick: function (info) {
                    const event = info.event;
                    const props = event.extendedProps;
                    let details = event.title + '\n';
                    details += 'Date: ' + (event.start ? event.start.toLocaleDateString() : 'N/A') + '\n';
                    details += 'Time: ' + (event.start ? event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'N/A') + '\n';
                    
                    if (props.duration) {
                        details += 'Duration: ' + props.duration + '\n';
                    }
                    if (props.status) {
                        details += 'Status: ' + props.status.toUpperCase();
                    }
                    
                    alert(details);
                }
            });

            calendar.render();
        });

        /* UPCOMING EVENTS */
        fetch('/calendar-events')
            .then(res => res.json())
            .then(data => {
                let container = document.getElementById('upcoming-events');

                // Filter and sort upcoming events (next 7 days)
                const now = new Date();
                const sevenDaysLater = new Date(now.getTime() + 7 * 24 * 60 * 60 * 1000);
                
                const upcomingData = data
                    .filter(event => new Date(event.start) >= now && new Date(event.start) <= sevenDaysLater)
                    .sort((a, b) => new Date(a.start) - new Date(b.start))
                    .slice(0, 10);

                if (upcomingData.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-check text-2xl text-teal-600"></i>
                            </div>
                            <p class="text-sm font-medium text-gray-700">No upcoming events</p>
                            <p class="text-xs text-gray-500 mt-1">Check back later for more events</p>
                        </div>`;
                    return;
                }

                upcomingData.forEach((event, index) => {
                    const eventDate = new Date(event.start);
                    const isToday = eventDate.toDateString() === now.toDateString();
                    const isTomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000).toDateString() === eventDate.toDateString();
                    
                    const dateStr = isToday ? 'Today' : isTomorrow ? 'Tomorrow' : eventDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    const timeStr = eventDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    
                    const isLive = event.extendedProps?.status === 'live';
                    const typeIcon = event.title.startsWith('LIVE:') ? 'fa-video' : 'fa-clipboard-list';
                    const typeClass = event.title.startsWith('LIVE:') ? 'bg-red-50 border-red-200 text-red-700' : 'bg-orange-50 border-orange-200 text-orange-700';

                    let div = document.createElement('div');
                    div.className = `p-4 border rounded-lg transition-all hover:shadow-md ${typeClass}`;
                    
                    div.innerHTML = `
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate flex items-center gap-2">
                                    <i class="fas ${typeIcon} flex-shrink-0"></i>
                                    <span>${event.title}</span>
                                    ${isLive ? '<span class="inline-block w-2 h-2 bg-red-600 rounded-full animate-pulse"></span>' : ''}
                                </p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs font-medium text-gray-600">
                                        <i class="fas fa-calendar-alt text-xs"></i> ${dateStr}
                                    </p>
                                    <p class="text-xs font-medium text-gray-600">
                                        <i class="fas fa-clock text-xs"></i> ${timeStr}
                                    </p>
                                    ${event.extendedProps?.duration ? `<p class="text-xs font-medium text-gray-600"><i class="fas fa-hourglass-half text-xs"></i> ${event.extendedProps.duration}</p>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                    container.appendChild(div);
                });
            });
    </script>

</body>
</html>