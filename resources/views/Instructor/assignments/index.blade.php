<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Manage Assignments</title>

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
        <x-instructor-header title="Manage Assignments" />

        <!-- Page Content -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">

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
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-teal-600"></i>
                        Assignments
                    </h2>
                    <a href="{{ url('/course/'.$courseId.'/assignment/create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-800 transition shadow-sm">
                        <i class="fas fa-plus"></i>
                        Create Assignment
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-left">
                                <th class="px-6 py-3 font-semibold text-gray-600">#</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Title</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Deadline</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Submissions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($assignments as $index => $assignment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-400 font-medium">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $assignment->title }}</td>
                                <td class="px-6 py-4 text-gray-500">
                                    <span class="inline-flex items-center gap-1.5">
                                        <i class="fas fa-calendar-alt text-teal-500 text-xs"></i>
                                        {{ $assignment->deadline }}
                                    </span>
                                </td>
                               <td class="px-6 py-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('assignment.submissions', $assignment->id) }}"
           class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-lg text-xs font-semibold hover:bg-teal-600 hover:text-white hover:border-teal-600 transition">
            <i class="fas fa-eye text-xs"></i>
            View Submissions
        </a>
        <a href="{{ route('assignment.edit', $assignment->id) }}"
           class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg text-xs font-semibold hover:bg-amber-500 hover:text-white hover:border-amber-500 transition">
            <i class="fas fa-calendar-pen text-xs"></i>
            Edit Deadline
        </a>
    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-folder-open text-3xl mb-3 block text-gray-300"></i>
                                    No assignments found. Create one to get started.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>

</div>
@endauth

</body>
</html>