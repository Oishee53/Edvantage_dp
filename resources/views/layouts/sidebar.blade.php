@php
    $isManageCoursesActive =
        request()->is('instructor/manage_courses*') ||
        request()->is('instructor/manage_resources*') ||
        request()->is('instructor/courses*') ||
        request()->is('admin_panel/manage_resources*') ||
        request()->is('admin_panel/courses*') ||
        request()->is('manage_courses/add') ||
        request()->is('instructor/final-exams*') ||
        request()->is('view/inside-module*');
@endphp

<!-- Sidebar Wrapper -->
<div 
    x-data="{ open: window.innerWidth >= 1024, collapsed: false }"
    @toggle-sidebar.window="open = !open"
    @toggle-collapse.window="collapsed = !collapsed"
    class="relative"
>
    <!-- Overlay (Mobile) -->
    <div 
        x-show="open && window.innerWidth < 1024"
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden"
        style="display: none;"
    ></div>

    <!-- Sidebar -->
    <aside
        x-show="open"
        :class="collapsed ? 'lg:w-20' : 'lg:w-72'"
        x-transition:enter="transition transform duration-300 ease-out lg:transition-all lg:duration-300"
        x-transition:enter-start="-translate-x-full lg:translate-x-0"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300 ease-in lg:transition-none"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full lg:translate-x-0"
        @resize.window="if (window.innerWidth >= 1024) open = true; else if (window.innerWidth < 1024) collapsed = false"
        class="w-72 bg-white border-r border-gray-200 min-h-screen fixed top-0 left-0 z-50 transition-all duration-300"
        style="display: none;"
    >
        <!-- Logo -->
        <div class="px-4 py-2.5 border-b border-gray-100 bg-white flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <img src="/image/Edvantage.png" alt="Edvantage Logo" :class="collapsed ? 'h-8 lg:mx-auto' : 'h-10'" class="transition-all duration-300">
            </div>
            <!-- Desktop Collapse Toggle Button -->
                <button 
                    @click="window.dispatchEvent(new CustomEvent('toggle-collapse'))" 
                    class="hidden lg:block p-2 hover:bg-teal-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-lg text-teal-700"></i>
                </button>
        </div>
        <!-- Navigation -->
        <nav class="mt-6 px-4 pb-24 space-y-1 ">
            {{-- ================= INSTRUCTOR ================= --}}
            @if(auth()->user()->role === 3)
                <!-- Dashboard -->
                <a href="{{ route('instructor.dashboard') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Dashboard' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                   {{ request()->routeIs('instructor.dashboard')
                        ? 'text-white bg-teal-600 font-semibold shadow-sm'
                        : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-home text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>Dashboard</span>
                </a>

                <!-- Manage Courses -->
                <a href="{{ route('instructor.courses') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Manage Courses' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                    {{ $isManageCoursesActive
                            ? 'text-white bg-teal-600 font-semibold shadow-sm'
                            : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-book text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>Manage Courses</span>
                </a>

            {{-- ================= ADMIN ================= --}}
            @elseif(auth()->user()->role === 2)
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Dashboard' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                   {{ request()->routeIs('admin.dashboard')
                        ? 'text-white bg-teal-600 font-semibold shadow-sm'
                        : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-home text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>Dashboard</span>
                </a>

                <!-- Manage Courses -->
                <a href="{{ route('admin.courses') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Manage Courses' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                   {{ request()->routeIs('admin.courses*')
                        ? 'text-white bg-teal-600 font-semibold shadow-sm'
                        : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-book text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>Manage Courses</span>
                </a>

                <!-- Manage Users -->
                <a href="{{ route('admin.users') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Manage Users' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                   {{ request()->routeIs('admin.users*')
                        ? 'text-white bg-teal-600 font-semibold shadow-sm'
                        : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-users text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>Manage Users</span>
                </a>

                <!-- Pending Courses -->
                <a href="{{ route('admin.pending') }}"
                   :class="collapsed ? 'lg:justify-center lg:px-0' : ''"
                   :title="collapsed ? 'Pending Courses' : ''"
                   class="group flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                   {{ request()->routeIs('admin.pending*')
                        ? 'text-white bg-teal-600 font-semibold shadow-sm'
                        : 'text-teal-700 hover:text-teal-900 hover:bg-teal-50 font-medium' }}">
                    <i class="fas fa-clock text-base w-5 flex-shrink-0"></i>
                    <span class="text-sm truncate" x-show="!collapsed" x-transition>
                        <span class="flex items-center gap-2">
                            Pending Courses
                            @if(isset($pendingCoursesCount) && $pendingCoursesCount > 0)
                            <span class="ml-auto px-2 py-0.5 text-xs rounded-full bg-amber-100 text-amber-700 font-semibold">
                                {{ $pendingCoursesCount }}
                            </span>
                            @endif
                        </span>
                    </span>
                </a>
            @endif
        </nav>

        <!-- User Profile -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-white">
            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-100" :class="collapsed ? 'lg:flex-col lg:gap-1 lg:p-2' : ''">
                <div class="w-10 h-10 rounded-lg bg-gray-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0" x-show="!collapsed" x-transition>
                    <p class="text-sm font-semibold text-teal-900 truncate">
                        {{ Auth::user()->name }}
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ auth()->user()->role === 2 ? 'Admin' : 'Instructor' }}
                    </p>
                </div>
            </div>
        </div>
    </aside>
</div>

<style>
    @media (min-width: 1024px) {
        aside {
            display: block !important;
        }
    }
</style>
