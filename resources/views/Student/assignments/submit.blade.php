<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        .heading-font { font-family: 'Playfair Display', Georgia, serif; }
        body { background-color: #f9fafb; color: #333; letter-spacing: -0.01em; }
    </style>
</head>
<body class="px-20 pt-5">

    @include('layouts.header')

    <div class="pt-24">
        <div style="max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem;">

            @php
                $isDeadlinePassed = \Carbon\Carbon::now('Asia/Dhaka')
                    ->gt(\Carbon\Carbon::parse($assignment->deadline, 'Asia/Dhaka'));
            @endphp

            <!-- Assignment Header Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-50 border border-teal-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tasks text-teal-600 text-lg"></i>
                        </div>
                        <div>
                            <h1 class="heading-font text-2xl font-bold text-gray-900 mb-1">{{ $assignment->title }}</h1>
                            <div class="flex items-center gap-2 text-sm text-gray-500 font-medium">
                                <i class="fas fa-calendar-alt text-teal-500 text-xs"></i>
                                <span>Deadline: {{ \Carbon\Carbon::parse($assignment->deadline)->format('d M Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($isDeadlinePassed)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded-lg text-xs font-semibold">
                            <i class="fas fa-lock text-xs"></i> Closed
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 border border-green-200 rounded-lg text-xs font-semibold">
                            <i class="fas fa-circle text-xs"></i> Open
                        </span>
                    @endif
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm flex items-center gap-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <p class="font-semibold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Uploaded Files -->
            @if(isset($submission) && $submission->files->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-paperclip text-teal-600"></i>
                        Uploaded Files
                    </h2>
                    <div class="space-y-2">
                        @foreach($submission->files as $file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-lg group hover:border-teal-300 transition">
                                <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank"
                                   class="flex items-center gap-2 text-sm text-teal-700 font-medium hover:text-teal-900 transition">
                                    <i class="fas fa-file-pdf text-red-400"></i>
                                    {{ basename($file->file_path) }}
                                </a>
                                @if(!$isDeadlinePassed)
                                    <form action="{{ route('submission.file.delete', $file->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this file?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-600 hover:text-white hover:border-red-600 transition">
                                            <i class="fas fa-trash text-xs"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Deadline Passed Notice -->
            @if($isDeadlinePassed)
                <div class="bg-red-50 border border-red-200 rounded-xl p-5 flex items-center gap-4">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-lock text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-red-700">Submission Closed</p>
                        <p class="text-xs text-red-500 mt-0.5">The deadline for this assignment has passed.</p>
                    </div>
                </div>

            @else
                <!-- Upload Form -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <i class="fas fa-upload text-teal-600"></i>
                        Submit Your Assignment
                    </h2>

                    <form method="POST" action="{{ url('/assignment/submit') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                        <!-- File Upload Area -->
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Upload PDF(s)
                            </label>

                            <label for="fileInput"
                                   class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:border-teal-400 hover:bg-teal-50 transition group">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-teal-400 transition mb-2 block"></i>
                                    <p class="text-sm font-semibold text-gray-500 group-hover:text-teal-600 transition">Click to upload PDF files</p>
                                    <p class="text-xs text-gray-400 mt-1">PDF only · Multiple files allowed</p>
                                </div>
                                <input type="file" id="fileInput" name="files[]" accept="application/pdf" multiple required class="hidden">
                            </label>

                            <!-- File List -->
                            <ul id="fileList" class="mt-3 space-y-2"></ul>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-semibold text-sm hover:bg-teal-800 transition shadow-sm">
                            <i class="fas fa-paper-plane"></i>
                            Submit Assignment
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>

    <script>
        const input = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');

        if (input) {
            input.addEventListener('change', function () {
                fileList.innerHTML = '';
                const dt = new DataTransfer();

                Array.from(this.files).forEach((file, index) => {
                    dt.items.add(file);

                    const li = document.createElement('li');
                    li.className = 'flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-lg text-sm';

                    const nameSpan = document.createElement('span');
                    nameSpan.className = 'flex items-center gap-2 text-gray-700 font-medium';
                    nameSpan.innerHTML = `<i class="fas fa-file-pdf text-red-400"></i> ${file.name}`;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'inline-flex items-center gap-1 px-3 py-1 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-600 hover:text-white hover:border-red-600 transition';
                    removeBtn.innerHTML = '<i class="fas fa-times text-xs"></i> Remove';

                    removeBtn.onclick = function () {
                        dt.items.remove(index);
                        input.files = dt.files;
                        input.dispatchEvent(new Event('change'));
                    };

                    li.appendChild(nameSpan);
                    li.appendChild(removeBtn);
                    fileList.appendChild(li);
                });

                input.files = dt.files;
            });
        }
    </script>

</body>
</html>