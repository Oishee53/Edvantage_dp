<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Exam - {{ $submission->exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accent { color: #0E1B33; }
        .bg-accent { background-color: #0E1B33; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $submission->exam->title }}</h1>
                    <p class="text-gray-600 mt-1">Grading Submission</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Student</div>
                    <div class="font-semibold text-gray-900">{{ $submission->user->name }}</div>
                    <div class="text-xs text-gray-500 mt-1">{{ $submission->user->email }}</div>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-4">
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="text-xs text-gray-500 uppercase">Questions</div>
                    <div class="text-xl font-bold text-gray-900">{{ $submission->exam->questions()->count() }}</div>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="text-xs text-gray-500 uppercase">Total Marks</div>
                    <div class="text-xl font-bold text-gray-900">{{ $submission->exam->total_marks }}</div>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="text-xs text-gray-500 uppercase">Submitted At</div>
                    <div class="text-sm font-semibold text-gray-900">{{ $submission->submitted_at->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-500">{{ $submission->submitted_at->format('g:i A') }}</div>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="text-xs text-gray-500 uppercase">Status</div>
                    <div class="text-sm font-semibold text-yellow-600">⏳ Pending Grading</div>
                </div>
            </div>
        </div>

        <!-- Grading Form -->
        <form action="{{ route('instructor.final-exams.save-grades', $submission->id) }}" method="POST" id="grading-form">
            @csrf

            <!-- Questions -->
            @foreach($submission->answers as $answer)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-start justify-between mb-4 pb-4 border-b-2 border-gray-200">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                Question {{ $answer->question->question_number }}
                            </h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $answer->question->question_text }}
                            </p>

                            @if($answer->question->marking_criteria)
                                <div class="mt-3 bg-green-50 border-l-4 border-green-500 p-3 rounded">
                                    <div class="text-xs text-green-700 font-semibold uppercase mb-1">Marking Criteria</div>
                                    <p class="text-sm text-green-800">{{ $answer->question->marking_criteria }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 bg-blue-100 text-blue-800 px-4 py-2 rounded-full font-semibold">
                            {{ $answer->question->marks }} marks
                        </div>
                    </div>

                    <!-- Student's Answer Images -->
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-3">📄 Student's Answer:</h4>
                        
                        @php
                            $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
                        @endphp

                        @if(count($images) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($images as $imageUrl)
                                    <div class="relative group">
                                        <img src="{{ $imageUrl }}" 
                                             alt="Answer Image" 
                                             class="w-full h-64 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-blue-500 transition"
                                             onclick="enlargeImage('{{ $imageUrl }}')">
                                        <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-xs">
                                            Click to enlarge
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                <p class="text-red-600">⚠️ No images uploaded</p>
                            </div>
                        @endif
                    </div>

                    <!-- Grading Section -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-4">✏️ Your Grading:</h4>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Marks Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Marks Obtained (out of {{ $answer->question->marks }})
                                </label>
                                <input type="number" 
                                       name="marks[{{ $answer->id }}]" 
                                       min="0" 
                                       max="{{ $answer->question->marks }}" 
                                       step="0.5"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition text-lg font-semibold"
                                       placeholder="0"
                                       required
                                       onchange="calculateTotal()">
                            </div>

                            <!-- Comment Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Comment/Feedback (optional)
                                </label>
                                <textarea name="comments[{{ $answer->id }}]" 
                                          rows="3"
                                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                                          placeholder="Write your feedback here..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Overall Feedback & Submit -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">📝 Overall Feedback</h3>
                
                <textarea name="overall_feedback" 
                          rows="4"
                          class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition mb-4"
                          placeholder="Write overall feedback for the student..."></textarea>

                <!-- Total Score Display -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-blue-700 font-medium">Total Score</div>
                            <div class="text-3xl font-bold text-blue-900" id="total-score">0</div>
                        </div>
                        <div>
                            <div class="text-sm text-blue-700 font-medium">Out of</div>
                            <div class="text-3xl font-bold text-blue-900">{{ $submission->exam->total_marks }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-blue-700 font-medium">Percentage</div>
                            <div class="text-3xl font-bold text-blue-900" id="percentage">0%</div>
                        </div>
                        <div>
                            <div class="text-sm text-blue-700 font-medium">Result</div>
                            <div class="text-xl font-bold" id="result-badge">
                                <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-full">Not Graded</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-lg transition transform hover:-translate-y-0.5 shadow-lg">
                        ✅ Submit Grading & Notify Student
                    </button>
                    <a href="{{ route('instructor.final-exams.submissions', $submission->exam->id) }}" 
                       class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-4 px-6 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Image Enlargement Modal -->
    <div id="image-modal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="closeModal()">
        <img id="modal-image" src="" class="max-w-full max-h-full rounded-lg" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-white text-4xl hover:text-gray-300">×</button>
    </div>

    <script>
        function calculateTotal() {
            let total = 0;
            const totalMarks = {{ $submission->exam->total_marks }};
            
            // Sum all marks inputs
            document.querySelectorAll('input[name^="marks"]').forEach(input => {
                const value = parseFloat(input.value) || 0;
                total += value;
            });

            // Update display
            document.getElementById('total-score').textContent = total.toFixed(1);
            
            // Calculate percentage
            const percentage = (total / totalMarks * 100).toFixed(1);
            document.getElementById('percentage').textContent = percentage + '%';

            // Update result badge
            const resultBadge = document.getElementById('result-badge');
            if (percentage >= 70) {
                resultBadge.innerHTML = '<span class="px-4 py-2 bg-green-500 text-white rounded-full">✅ PASS</span>';
            } else if (percentage > 0) {
                resultBadge.innerHTML = '<span class="px-4 py-2 bg-red-500 text-white rounded-full">❌ FAIL</span>';
            } else {
                resultBadge.innerHTML = '<span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-full">Not Graded</span>';
            }
        }

        function enlargeImage(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            document.getElementById('image-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('image-modal').classList.add('hidden');
        }

        // Validate before submit
        document.getElementById('grading-form').addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('input[name^="marks"]');
            let allFilled = true;

            inputs.forEach(input => {
                if (input.value === '' || input.value === null) {
                    allFilled = false;
                }
            });

            if (!allFilled) {
                e.preventDefault();
                alert('Please enter marks for all questions before submitting!');
                return false;
            }

            return confirm('Are you sure you want to submit this grading? The student will be notified.');
        });

        // Initialize calculation on page load
        calculateTotal();
    </script>
</body>
</html>