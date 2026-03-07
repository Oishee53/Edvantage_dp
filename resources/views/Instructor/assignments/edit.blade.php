<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Assignment Deadline</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>

<body class="bg-gray-50 min-h-screen font-sans antialiased">

@auth

<div class="flex min-h-screen" x-data="{ sidebarCollapsed: false }">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Wrapper -->
    <div class="flex-1 flex flex-col transition-all duration-300"
         :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-72'">

        <!-- Header -->
        <x-instructor-header title="Edit Assignment Deadline" />

        <!-- Page Content -->
        <main class="flex-1 p-6 max-w-2xl mx-auto w-full">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-check-circle text-lg"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Card Header -->
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center gap-3">
                    <div class="w-9 h-9 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-pen text-amber-600 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-teal-900">Edit Assignment Deadline</h2>
                        <p class="text-xs text-gray-500">Update the deadline for: <span class="font-semibold text-teal-700">{{ $assignment->title }}</span></p>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-6">
                    <form method="POST" action="{{ route('assignment.update', $assignment->id) }}">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-clock text-teal-500 mr-1.5"></i>
                                New Deadline
                            </label>
                            <input
                                type="datetime-local"
                                name="deadline"
                                value="{{ \Carbon\Carbon::parse($assignment->deadline)->format('Y-m-d\TH:i') }}"
                                required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-teal-400 focus:border-transparent transition"
                            >
                            @error('deadline')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-800 transition shadow-sm">
                                <i class="fas fa-save"></i>
                                Update Deadline
                            </button>

                            <a href="{{ url()->previous() }}"
                               class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-semibold text-sm hover:bg-gray-200 transition">
                                <i class="fas fa-arrow-left"></i>
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