<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Schedule Live Class</title>

```
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<!-- FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                },
            }
        }
    }
</script>
```

</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased">

@auth

<div class="flex min-h-screen" x-data="{ sidebarCollapsed: false }">

```
<!-- Sidebar -->
@include('layouts.sidebar')

<!-- Main Wrapper -->
<div class="flex-1 flex flex-col transition-all duration-300"
     :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'">

    <!-- Header -->
    <x-instructor-header title="Schedule Live Class" />

    <!-- Page Content -->
    <main class="flex-1 p-6 max-w-3xl mx-auto w-full">

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <p class="font-semibold">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <!-- Card Header -->
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                    <i class="fas fa-video text-teal-600"></i>
                    Live Class Details
                </h2>
            </div>

            <!-- Form -->
            <div class="p-6">

                <form action="{{ route('live.class.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <input type="hidden" name="course_id" value="{{ $course_id }}">

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Class Title
                        </label>
                        <input type="text"
                               name="title"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Schedule Date & Time
                        </label>
                        <input type="datetime-local"
                               name="schedule_datetime"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    </div>

                    <!-- Meeting Link -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">
                            Meeting Link
                        </label>
                        <input type="text"
                               name="meeting_link"
                               required
                               placeholder="https://meet.google.com/..."
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none">
                    </div>

                    <!-- Submit -->
                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition shadow-sm">
                            <i class="fas fa-save"></i>
                            Save Schedule
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </main>
</div>
```

</div>
@endauth

</body>
</html>
