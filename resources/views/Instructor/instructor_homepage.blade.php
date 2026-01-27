<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
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

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out forwards;
        }
        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.1s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.2s; }
        
        @media (min-width: 1024px) {
            aside {
                display: block !important;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false">
        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 "
             :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            <!-- Header -->
            @include('components.instructor-header', ['title' => 'Dashboard'])

            <!-- Main Content -->
            <main class="flex-1 pr-10">
                <!-- Dashboard Content -->
                <div class="p-4 lg:p-6 max-w-5xl mx-auto">
                    
                    <!-- Welcome Section - Compact -->
                   <div class="flex items-center gap-2.5 mb-5">
                        <h2 class="text-xl font-semibold text-teal-900">Welcome back, {{ Auth::user()->name }}</h2>
                    </div>
                    

                    <!-- Statistics Grid - Compact -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-5">
                        <!-- Approved Courses -->
                        <div onclick="window.location='/instructor/manage_courses'" 
                             class="stat-card cursor-pointer bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-200 hover:border-gray-900 transition-all duration-200 group opacity-0 animate-fade-in-up">
                            <div class="text-2xl font-semibold text-teal-900 mb-0.5">{{ isset($approvedCourses) ? count($approvedCourses) : 0 }}</div>
                            <div class="text-xs font-medium text-teal-600 uppercase tracking-wide">Approved</div>
                        </div>

                        <!-- Pending Courses -->
                        <div onclick="window.location='/instructor/manage_courses'" 
                             class="stat-card cursor-pointer bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-200 hover:border-gray-900 transition-all duration-200 group opacity-0 animate-fade-in-up">
                            <div class="text-2xl font-semibold text-teal-900 mb-0.5">{{ isset($pendingCourses) ? count($pendingCourses) : 0 }}</div>
                            <div class="text-xs font-medium text-teal-600 uppercase tracking-wide">Pending</div>
                        </div>

                        <!-- Rejected Courses -->
                        <div onclick="window.location='{{ route('rejected.course.show') }}'" 
                             class="stat-card cursor-pointer bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-200 hover:border-gray-900 transition-all duration-200 group opacity-0 animate-fade-in-up">
                            <div class="text-2xl font-semibold text-teal-900 mb-0.5">{{ isset($rejectedCourses) ? count($rejectedCourses) : 0 }}</div>
                            <div class="text-xs font-medium text-teal-600 uppercase tracking-wide">Rejected</div>
                        </div>

                        <!-- Total Earnings -->
                        <div class="stat-card bg-white rounded-lg p-4 shadow-sm hover:shadow-md border border-gray-200 hover:border-gray-900 transition-all duration-200 group opacity-0 animate-fade-in-up">
                            <div class="text-2xl font-semibold text-teal-900 mb-0.5">৳{{ number_format($totalEarnings ?? 0, 2) }}</div>
                            <div class="text-xs font-medium text-teal-600 uppercase tracking-wide">Total Earnings</div>
                        </div>
                    </div>

                    <!-- Courses Section - Compact -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base font-semibold text-teal-900 flex items-center gap-2">
                                    <i class="fas fa-graduation-cap text-teal-700 text-sm"></i>
                                    My Courses
                                </h3>
                                @if(isset($coursesWithStudents) && count($coursesWithStudents) > 0)
                                <span class="text-xs text-teal-600 font-medium">{{ count($coursesWithStudents) }} course{{ count($coursesWithStudents) !== 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            @if(isset($coursesWithStudents) && count($coursesWithStudents) > 0)
                                <div class="space-y-2">
                                    @foreach($coursesWithStudents as $course)
                                        <div onclick="showStudents('{{ addslashes($course->title) }}', '{{ $course->id }}')" 
                                             class="group flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-gray-900 hover:shadow-sm transition-all duration-200 cursor-pointer bg-white hover:bg-teal-50">
                                            <div class="flex-1 min-w-0 pr-3">
                                                <h4 class="text-sm font-medium text-teal-900 mb-0.5 truncate">{{ $course->title }}</h4>
                                                <p class="text-xs text-teal-600 line-clamp-1">{{ Str::limit($course->description, 60) }}</p>
                                            </div>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <div class="flex items-center gap-1.5 px-2.5 py-1 bg-teal-600 text-white rounded-md text-xs font-medium group-hover:bg-teal-800 transition-colors">
                                                    <i class="fas fa-users" style="font-size: 10px;"></i>
                                                    <span>{{ $course->student_count ?? 0 }}</span>
                                                </div>
                                                <i class="fas fa-chevron-right text-teal-400 group-hover:text-teal-900 group-hover:translate-x-0.5 transition-all" style="font-size: 10px;"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="w-14 h-14 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-book-open text-xl text-teal-400"></i>
                                    </div>
                                    <h4 class="text-base font-semibold text-teal-900 mb-1">No Courses Yet</h4>
                                    <p class="text-sm text-teal-600 mb-4 max-w-md mx-auto">Start by creating your first course and share your knowledge with students!</p>
                                    <a href="/instructor/manage_courses" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-lg text-sm font-medium shadow-sm hover:bg-teal-800 transition-all hover:shadow-md">
                                        <i class="fas fa-plus" style="font-size: 10px;"></i>
                                        <span>Create Course</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Student Modal - Compact -->
    <div id="studentsModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 p-4 items-center justify-center">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 bg-teal-600">
                <div class="flex items-center justify-between">
                    <h3 id="modalTitle" class="text-base font-semibold text-white flex items-center gap-2">
                        <i class="fas fa-users text-xs"></i>
                        Course Students
                    </h3>
                    <button onclick="closeModal()" 
                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition-colors">
                        <i class="fas fa-times text-white text-sm"></i>
                    </button>
                </div>
            </div>
            <div id="studentsContent" class="p-4 overflow-y-auto max-h-[calc(85vh-60px)]"></div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        const courseStudents = @json(
            isset($coursesWithStudents) ? 
            $coursesWithStudents->mapWithKeys(function($course) {
                return [$course->id => $course->students ?? []];
            }) : []
        );

        function showStudents(courseName, courseId) {
            const modal = document.getElementById('studentsModal');
            const modalTitle = document.getElementById('modalTitle');
            const studentsContent = document.getElementById('studentsContent');
            
            modalTitle.innerHTML = `<i class="fas fa-users text-xs"></i> ${courseName}`;
            const students = courseStudents[courseId] || [];
            let studentsHTML = '';

            if (students.length > 0) {
                studentsHTML = '<div class="space-y-2">';
                students.forEach(student => {
                    const initials = student.name.split(' ').map(n => n[0]).join('');
                    const enrollDate = new Date(student.enroll_date).toLocaleDateString('en-US', {
                        month: 'short',
                        day: '2-digit',
                        year: 'numeric'
                    });
                    studentsHTML += `
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-gray-900 hover:shadow-sm transition-all bg-white">
                            <div class="w-10 h-10 rounded-lg bg-teal-600 flex items-center justify-center text-white font-medium text-xs flex-shrink-0">
                                ${initials}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-teal-900 truncate">${student.name}</h4>
                                <p class="text-xs text-teal-600 truncate mb-0.5">${student.email}</p>
                                <p class="text-xs text-teal-400 flex items-center gap-1">
                                    <i class="fas fa-calendar-alt" style="font-size: 9px;"></i>
                                    ${enrollDate}
                                </p>
                            </div>
                        </div>
                    `;
                });
                studentsHTML += '</div>';
            } else {
                studentsHTML = `
                    <div class="text-center py-10">
                        <div class="w-14 h-14 bg-teal-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-users text-xl text-teal-400"></i>
                        </div>
                        <p class="text-sm text-teal-600 font-medium">No students enrolled yet</p>
                    </div>
                `;
            }

            studentsContent.innerHTML = studentsHTML;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('studentsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.addEventListener('click', function(event) {
            const modal = document.getElementById('studentsModal');
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>