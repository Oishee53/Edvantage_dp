<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Assignment Submissions</title>

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
        <x-instructor-header title="Assignment Submissions" />

        <!-- Page Content -->
        <main class="flex-1 p-6 max-w-5xl mx-auto w-full">

            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Card Header -->
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                        <i class="fas fa-file-alt text-teal-600"></i>
                        Submissions for <span class="text-teal-600 ml-1">{{ $assignment->title }}</span>
                    </h2>
                    <span class="text-sm text-gray-500 font-medium">
                        {{ $submissions->count() }} {{ Str::plural('submission', $submissions->count()) }}
                    </span>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-left">
                                <th class="px-6 py-3 font-semibold text-gray-600">#</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Student</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Score</th>
                                <th class="px-6 py-3 font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($submissions as $index => $submission)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-gray-400 font-medium">{{ $index + 1 }}</td>

                                <!-- Student -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs uppercase">
                                            {{ substr($submission->student->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-gray-800">{{ $submission->student->name }}</span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    @if($submission->status === 'graded')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            <i class="fas fa-check-circle text-xs"></i>
                                            Graded
                                        </span>
                                    @elseif($submission->status === 'submitted')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <i class="fas fa-paper-plane text-xs"></i>
                                            Submitted
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                            <i class="fas fa-clock text-xs"></i>
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Score -->
                                <td class="px-6 py-4">
                                    @if($submission->score !== null)
                                        <span class="font-bold text-teal-700">{{ $submission->score }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4">
                                    <a href="{{ route('assignment.grade.form', $submission->id) }}"
                                       class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-teal-50 text-teal-700 border border-teal-200 rounded-lg text-xs font-semibold hover:bg-teal-600 hover:text-white hover:border-teal-600 transition">
                                        <i class="fas fa-eye text-xs"></i>
                                        View & Grade
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                                    No submissions yet for this assignment.
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