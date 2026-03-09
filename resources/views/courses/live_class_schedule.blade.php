<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Schedule Live Class</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased">

@auth

<div class="flex min-h-screen" x-data="{ sidebarCollapsed: false }">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col transition-all duration-300"
         :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'">

        <x-instructor-header title="Schedule Live Class" />

        <main class="flex-1 p-6 max-w-3xl mx-auto w-full">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-exclamation-circle text-lg"></i>
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Info banner — hybrid course notice -->
            <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-start gap-3">
                <i class="fas fa-info-circle text-indigo-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-semibold text-indigo-800">Adding a live class to a recorded course</p>
                    <p class="text-xs text-indigo-600 mt-0.5">
                        This live session will appear as an upcoming class banner on the student's course page,
                        and in the <strong>Live Classes</strong> tab.
                    </p>
                </div>
            </div>

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Card Header -->
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                        <i class="fas fa-broadcast-tower text-teal-600"></i>
                        Live Class Details
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $course->title }}</p>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('live.class.store') }}"
                          method="POST"
                          class="space-y-5">
                        @csrf

                        <input type="hidden" name="course_id" value="{{ $course_id }}">

                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Class Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required
                                   placeholder="e.g. Live Q&A Session #1"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none @error('title') border-red-400 @enderror">
                            @error('title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="date"
                                   value="{{ old('date') }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none @error('date') border-red-400 @enderror">
                            @error('date')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start Time -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Start Time <span class="text-red-500">*</span>
                            </label>
                            <input type="time"
                                   name="start_time"
                                   value="{{ old('start_time') }}"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none @error('start_time') border-red-400 @enderror">
                            @error('start_time')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">
                                Duration (minutes) <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="duration_minutes"
                                   value="{{ old('duration_minutes', 60) }}"
                                   min="15" max="480"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none @error('duration_minutes') border-red-400 @enderror">
                            @error('duration_minutes')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="pt-2 flex items-center gap-3">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition shadow-sm">
                                <i class="fas fa-save"></i>
                                Schedule Live Class
                            </button>
                            <a href="javascript:history.back()"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-300 text-gray-600 rounded-lg font-semibold hover:bg-gray-50 transition text-sm">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </main>
    </div>
</div>
@endauth

</body>
</html>