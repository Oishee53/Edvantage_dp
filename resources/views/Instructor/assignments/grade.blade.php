<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Grade Submission</title>

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
        <x-instructor-header title="Grade Submission" />

        <!-- Page Content -->
        <main class="flex-1 p-6 max-w-3xl mx-auto w-full">

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
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-lg font-bold text-teal-900 flex items-center gap-2">
                        <i class="fas fa-star text-teal-600"></i>
                        Grade Submission
                    </h2>
                </div>

                <!-- Card Body -->
                <div class="p-6 space-y-5">

                    <!-- Student Info -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="w-10 h-10 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-sm uppercase">
                            {{ substr($submission->student->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium">Student</p>
                            <p class="text-gray-800 font-semibold">{{ $submission->student->name }}</p>
                        </div>
                    </div>
                      <div style="margin-bottom:20px;">
                   <strong>Assignment Question:</strong>
                  <p>{{ $submission->assignment->description }}</p>
                  </div>
                    <!-- View File -->
                   <!-- Submitted Files -->
<div>
    <p class="text-sm font-semibold text-gray-700 mb-3">Submitted Files</p>

    @if($submission->files->count() > 0)

        <div class="space-y-2">
            @foreach($submission->files as $file)
                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank"
                   class="flex items-center gap-3 px-5 py-3 bg-teal-50 text-teal-700 border border-teal-200 rounded-lg text-sm font-semibold hover:bg-teal-600 hover:text-white hover:border-teal-600 transition">

                    <i class="fas fa-file-pdf text-sm"></i>
                    {{ basename($file->file_path) }}

                </a>
            @endforeach
        </div>

    @else
        <p class="text-gray-400 text-sm">No files submitted.</p>
    @endif
</div>

                    <hr class="border-gray-100">

                    <!-- Grade Form -->
                    <form action="{{ route('assignment.grade', $submission->id) }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                          <label class="block text-sm font-semibold text-gray-700 mb-1">
    Score (Out of {{ $submission->assignment->marks }})
</label>

<input type="number"
       name="score"
       min="0"
       max="{{ $submission->assignment->marks }}"
       required
       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-teal-500 focus:outline-none text-gray-800">

<p class="text-xs text-gray-500 mt-1">
    Maximum marks: {{ $submission->assignment->marks }}
</p>
                        </div>

                        <div class="pt-2 flex items-center gap-3">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition shadow-sm">
                                <i class="fas fa-save"></i>
                                Save Grade
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