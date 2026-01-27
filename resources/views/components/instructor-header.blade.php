@props(['title' => 'Dashboard', 'subtitle' => 'Manage your courses and students'])

<header class="bg-white sticky top-0 z-40 border-b border-gray-200 shadow-sm ">
    <div class="px-4 lg:px-6 py-3 ">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- Mobile Toggle Button -->
                <button 
                    @click="window.dispatchEvent(new CustomEvent('toggle-sidebar'))" 
                    class="lg:hidden p-2 hover:bg-teal-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-lg text-teal-700"></i>
                </button>
                
                
                
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-teal-600">
                        {{ $title }}
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <!-- Notifications -->
                <div class="relative notifications">
                    <button type="button" onclick="toggleNotifications()" class="relative w-10 h-10 flex items-center justify-center hover:bg-teal-100 rounded-lg transition-all duration-200">
                        <i class="fa fa-bell text-lg text-teal-700"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white text-[10px] px-1">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>

                    <div id="notifDropdown" class="notif-dropdown hidden absolute right-0 top-full mt-2 w-80 lg:w-96 bg-white rounded-xl shadow-xl border border-gray-200 z-50">
                        <div class="px-4 py-3 border-b border-gray-200 bg-teal-50">
                            <h3 class="font-semibold text-teal-900 text-sm">Notifications</h3>
                        </div>
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                @php
                                    switch ($notification->type) {
                                        case 'App\Notifications\approveCourseNotification':
                                             $route = url("/admin_panel/manage_resources/{$notification->data['course_id']}/modules");
                                            break;    
                                        case 'App\Notifications\rejectCourseNotification':
                                            $route = route('rejected.course.show');
                                            break;
                                        case 'App\Notifications\NewQuestionNotification':
                                            $route = route('instructor.questions.show', $notification->data['question_id']); 
                                            break;
                                        case 'App\Notifications\FinalExamSubmittedNotification':
                                            $route = route('notifications.markAsReadAndRedirect', $notification->id);
                                            break;
                                        default:
                                            $route = route('notifications.read', $notification->id);
                                    }
                                @endphp

                                <a href="{{ $route }}" class="block px-4 py-3 hover:bg-teal-50 transition-colors border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0
                                            @if($notification->type === 'App\Notifications\approveCourseNotification') bg-green-100
                                            @elseif($notification->type === 'App\Notifications\rejectCourseNotification') bg-red-100
                                            @elseif($notification->type === 'App\Notifications\NewQuestionNotification') bg-blue-100
                                            @else bg-teal-100
                                            @endif">
                                            @if($notification->type === 'App\Notifications\approveCourseNotification')
                                                <i class="fas fa-check-circle text-green-600 text-sm"></i>
                                            @elseif($notification->type === 'App\Notifications\rejectCourseNotification')
                                                <i class="fas fa-times-circle text-red-600 text-sm"></i>
                                            @elseif($notification->type === 'App\Notifications\NewQuestionNotification')
                                                <i class="fas fa-question-circle text-blue-600 text-sm"></i>
                                            @else
                                                <i class="fas fa-info-circle text-teal-600 text-sm"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-teal-900 mb-1 leading-tight">
                                                @if($notification->type === 'App\Notifications\approveCourseNotification')
                                                    {{ $notification->data['content'] }}
                                                @elseif($notification->type === 'App\Notifications\rejectCourseNotification')
                                                    Course rejected: {{ $notification->data['course_title'] }}
                                                @elseif($notification->type === 'App\Notifications\NewQuestionNotification')
                                                    {{ $notification->data['content'] }}
                                                @elseif($notification->type === 'App\Notifications\CourseUpdatedNotification')
                                                    {{ $notification->data['content'] }}
                                                @elseif($notification->type === 'App\Notifications\CourseDeleteNotification')
                                                    {{ $notification->data['content'] }}
                                                @elseif($notification->type === 'App\Notifications\FinalExamSubmittedNotification')
                                                    {{ $notification->data['message'] }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-teal-500">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-10 text-center">
                                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-bell-slash text-2xl text-teal-400"></i>
                                    </div>
                                    <p class="text-sm text-teal-600 font-medium">No new notifications</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Student View Link -->
                <a href="/homepage" class="flex items-center gap-2 px-3 lg:px-4 py-2 bg-teal-600 text-white rounded-lg font-medium text-sm hover:bg-teal-800 transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-user-graduate text-xs"></i>
                    <span class="hidden sm:inline">Student View</span>
                </a>

                <!-- Logout -->
                <form action="/logout" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="px-3 lg:px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium text-sm shadow-sm hover:shadow-md transition-all duration-200">
                        <i class="fas fa-sign-out-alt text-xs mr-1.5"></i>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notifDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const notifContainer = document.querySelector('.notifications');
        const dropdown = document.getElementById('notifDropdown');
        
        if (notifContainer && !notifContainer.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>