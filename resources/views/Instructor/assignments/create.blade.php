<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Create Assignment</title>

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

    <style>
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.375rem;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="datetime-local"],
        .form-group textarea {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            color: #333;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.12);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 110px;
        }
    </style>
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
        <x-instructor-header title="Create Assignment" />

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
                        <i class="fas fa-pen-to-square text-teal-600"></i>
                        Assignment Details
                    </h2>
                </div>

                <!-- Form -->
                <div class="p-6">

                    <form method="POST" action="{{ url('/assignment/store') }}" class="space-y-5">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $courseId }}">

                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" required placeholder="Enter assignment title">
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" required placeholder="Enter assignment description..."></textarea>
                        </div>

                        <!-- Total Marks -->
                        <div class="form-group">
                            <label>Total Marks</label>
                            <input type="number" name="marks" min="1" required>
                        </div>

                        <!-- Deadline -->
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" id="deadline" name="deadline" required>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center gap-3 pt-2">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition shadow-sm">
                                <i class="fas fa-save"></i>
                                Create Assignment
                            </button>
                            <a href="javascript:history.back()"
                               class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-gray-600 border border-gray-300 rounded-lg font-semibold hover:bg-gray-50 hover:border-gray-400 transition shadow-sm">
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