<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Courses</title>
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
        transform: translateY(12px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .animate-fade-in-up {
      animation: fadeInUp 0.4s ease-out forwards;
    }
    .course-card:nth-child(1) { animation-delay: 0.05s; }
    .course-card:nth-child(2) { animation-delay: 0.1s; }
    .course-card:nth-child(3) { animation-delay: 0.15s; }
    .course-card:nth-child(4) { animation-delay: 0.2s; }
    .course-card:nth-child(5) { animation-delay: 0.25s; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

  <div class="flex min-h-screen" x-data="{ sidebarCollapsed: false }">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-h-screen transition-all duration-300"
         :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'">
      
      <!-- Sticky Header -->
      <x-instructor-header :title="$pageTitle ?? 'Manage Courses'" />

      <!-- Main Content -->
      <main class="flex-1 px-10">
        <!-- Page Content -->
        <div class="p-4 lg:p-6 max-w-7xl mx-auto">
          @auth
            <!-- Add Course Button -->
            <div class="mb-6">
              <form action="/manage_courses/add" method="GET">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg font-semibold shadow-sm hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                  <span>Add New Course</span>
                </button>
              </form>
            </div>

            <!-- Approved Courses Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
              <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                    Approved Courses
                  </h2>
                  @if(isset($courses))
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                      {{ $courses->count() }} {{ $courses->count() === 1 ? 'Course' : 'Courses' }}
                    </span>
                  @endif
                </div>
              </div>
              
              <div class="p-5">
                @if(isset($courses) && $courses->isEmpty())
                  <div class="text-center py-12">
                    <div class="w-16 h-16 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                      <i class="fas fa-book-open text-2xl text-teal-400"></i>
                    </div>
                    <h3 class="text-base font-semibold text-teal-900 mb-2">No Approved Courses</h3>
                    <p class="text-sm text-teal-600">Your approved courses will appear here once they're reviewed by the admin.</p>
                  </div>
                @else
                  <div class="space-y-3">
                    @foreach($courses as $course)
                      <div class="course-card group relative flex items-start gap-4 p-4 border border-gray-200 rounded-lg hover:border-gray-900 hover:shadow-md transition-all duration-200 bg-white hover:bg-gray-50 opacity-0 animate-fade-in-up">
                        <!-- Course Image -->
                        @if($course->image)
                          <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-32 h-24 object-cover rounded-lg border border-gray-200 flex-shrink-0 group-hover:border-gray-900 transition-colors">
                        @else
                          <div class="w-32 h-24 bg-teal-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-image text-2xl text-teal-400"></i>
                          </div>
                        @endif
                        
                        <!-- Course Details -->
                        <div class="flex-1 min-w-0">
                          <h3 class="text-base font-semibold text-teal-900 mb-3 group-hover:text-teal-900 transition-colors">{{ $course->title }}</h3>
                          
                          <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                            <div class="flex items-center gap-2">
                              <div class="min-w-0 space-y-2">
                                <p class="text-sm font-medium text-teal-900 truncate">Category</p>
                                <p class="text-xs text-gray-500">{{ $course->category }}</p>
                              </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="min-w-0 space-y-1">
                                <p class="text-sm font-medium text-teal-900">Videos</p>
                                <p class="text-xs text-gray-500">{{ $course->video_count }}</p>
                              </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="min-w-0 space-y-1">
                                <p class="text-sm font-medium text-teal-900">Duration</p>
                                <p class="text-xs text-gray-500">{{ $course->total_duration }} hrs</p>
                              </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="min-w-0 space-y-1">
                                <p class="text-sm font-medium text-teal-900">Price</p>
                                <p class="text-xs text-gray-500">৳{{ $course->price }}</p>
                              </div>
                            </div>
                          </div>
                            <!-- Action Dropdown (TOP RIGHT) -->
                            <div class="absolute top-4 right-4">
                                <button 
                                    type="button"
                                    class="p-2 rounded-lg hover:bg-gray-100 text-gray-600"
                                    onclick="this.nextElementSibling.classList.toggle('hidden')"
                                >
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>

                                <div class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                    <a 
                                        href="{{ url("/admin_panel/manage_resources/{$course->id}/modules") }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Manage Modules
                                    </a>

                                    @php
                                        $finalExam = \App\Models\FinalExam::where('course_id', $course->id)->first();
                                    @endphp

                                    @if($finalExam)
                                        <a 
                                            href="{{ route('instructor.final-exams.show', $finalExam->id) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            Manage Final Exam
                                        </a>
                                    @else
                                        <a 
                                            href="{{ route('instructor.final-exams.create') }}?course_id={{ $course->id }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        >
                                            Create Final Exam
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
              </div>
            </div>

            <!-- Pending Courses Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
              <div class="px-5 py-4 border-b border-gray-100 bg-amber-50">
                <div class="flex items-center justify-between">
                  <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                    <i class="fas fa-clock text-amber-600"></i>
                    Pending Courses
                  </h2>
                  @if(isset($pendingCourses))
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-semibold">
                      {{ $pendingCourses->count() }} Awaiting Approval
                    </span>
                  @endif
                </div>
              </div>
              
              <div class="p-5">
                @if(isset($pendingCourses) && $pendingCourses->isEmpty())
                  <div class="text-center py-12">
                    <div class="w-16 h-16 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                      <i class="fas fa-check-double text-2xl text-teal-400"></i>
                    </div>
                    <h3 class="text-base font-semibold text-teal-900 mb-2">No Pending Courses</h3>
                    <p class="text-sm text-teal-600">All your courses have been reviewed!</p>
                  </div>
                @else
                  <div class="space-y-3">
                    @foreach($pendingCourses as $course)
                      <div class="course-card group flex items-start gap-4 p-4 border border-amber-200 rounded-lg hover:border-amber-400 hover:shadow-md transition-all duration-200 bg-white opacity-0 animate-fade-in-up">
                        <!-- Course Image -->
                        @if($course->image)
                          <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-32 h-24 object-cover rounded-lg border border-amber-200 flex-shrink-0 group-hover:border-amber-400 transition-colors">
                        @else
                          <div class="w-32 h-24 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-image text-2xl text-amber-600"></i>
                          </div>
                        @endif
                        
                        <!-- Course Details -->
                        <div class="flex-1 min-w-0">
                          <div class="flex items-start justify-between mb-3">
                            <h3 class="text-base font-semibold text-teal-900 group-hover:text-amber-700 transition-colors">{{ $course->title }}</h3>
                            
                            @if(\App\Models\CourseNotification::where('pending_course_id', $course->id)->exists())
                              <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold flex items-center gap-1 flex-shrink-0 ml-2">
                                <i class="fas fa-paper-plane"></i>Submitted
                              </span>
                            @else
                              <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold flex items-center gap-1 flex-shrink-0 ml-2">
                                <i class="fas fa-exclamation-circle"></i>Not Submitted
                              </span>
                            @endif
                          </div>
                          
                          <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                            <div class="flex items-center gap-2">
                              <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-tag text-blue-600 text-xs"></i>
                              </div>
                              <div class="min-w-0 space-y-3">
                                <p class="text-xs text-gray-500">Category</p>
                                <p class="text-sm font-semibold text-teal-900 truncate">{{ $course->category }}</p>
                              </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-video text-purple-600 text-xs"></i>
                              </div>
                              <div class="min-w-0 space-y-1">
                                <p class="text-xs text-gray-500">Videos</p>
                                <p class="text-sm font-semibold text-teal-900">{{ $course->video_count }}</p>
                              </div>

                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-orange-600 text-xs"></i>
                              </div>
                              <div class="min-w-0 space-y-1">
                                <p class="text-xs text-gray-500">Duration</p>
                                <p class="text-sm font-semibold text-teal-900">{{ $course->total_duration }} hrs</p>
                              </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                              <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bangladeshi-taka-sign text-green-600 text-xs"></i>
                              </div>
                              <div class="min-w-0 space-y-1">
                                <p class="text-xs text-gray-500">Price</p>
                                <p class="text-sm font-semibold text-teal-900">৳{{ $course->price }}</p>
                              </div>
                            </div>
                          </div>

                          <!-- Action Buttons -->
                          <div class="flex flex-wrap gap-2">
                            <a href="{{ url("/instructor/manage_resources/{$course->id}/modules") }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all text-xs">
                              <i class="fas fa-folder-open"></i>
                              Manage Modules
                            </a>
                            
                            <form action="/admin/manage_courses/courses/{{ $course->id }}/edit" method="GET" class="inline">
                              <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-all text-xs">
                                <i class="fas fa-edit"></i>
                                Edit Course
                              </button>
                            </form>
                            
                            <form action="/admin_panel/manage_courses/delete-course/{{ $course->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-all text-xs">
                                <i class="fas fa-trash"></i>
                                Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
              </div>
            </div>

          @else
            <!-- Not Logged In -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
              <div class="p-16 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                  <i class="fas fa-lock text-2xl text-red-600"></i>
                </div>
                <h2 class="text-xl font-bold text-teal-900 mb-3">Access Denied</h2>
                <p class="text-sm text-teal-600 mb-6">You need to be logged in to view this page.</p>
                <a href="/" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white rounded-lg font-semibold shadow-sm hover:bg-teal-800 transition-all hover:shadow-md text-sm">
                  <i class="fas fa-sign-in-alt text-xs"></i>
                  Go to Login
                </a>
              </div>
            </div>
          @endauth
        </div>
      </main>
    </div>
  </div>

</body>
</html>