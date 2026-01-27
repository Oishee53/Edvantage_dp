<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Exam - {{ $submission->exam->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f2f9',
                            100: '#e3e6f3',
                            600: '#1a2d52',
                            700: '#0E1B33',
                            800: '#0a1426',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in { animation: slideIn 0.5s ease-out forwards; }
        .question-card:nth-child(1) { animation-delay: 0.1s; }
        .question-card:nth-child(2) { animation-delay: 0.15s; }
        .question-card:nth-child(3) { animation-delay: 0.2s; }
        .question-card:nth-child(4) { animation-delay: 0.25s; }
        .question-card:nth-child(5) { animation-delay: 0.3s; }
        
        .modal { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.9); z-index: 1000; align-items: center; justify-content: center; padding: 2rem; }
        .modal.active { display: flex; }
        .modal img { max-width: 100%; max-height: 100%; border-radius: 8px; }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-blue-50/30 to-indigo-50/20 min-h-screen font-sans antialiased">

    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 lg:ml-0">
            <x-instructor-header 
                :title="'Grade Submission'" 
                :subtitle="$submission->exam->title"
            />

            <div class="p-6 lg:p-8 max-w-7xl mx-auto">
                <!-- Student Info Card -->
                <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden mb-6 opacity-0 animate-slide-in">
                    <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-teal-900">{{ $submission->user->name }}</h2>
                                <p class="text-sm text-teal-600 mt-1">{{ $submission->user->email }}</p>
                            </div>
                            <div class="text-right">
                                @if($submission->status === 'graded')
                                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold border border-green-200">
                                        <i class="fas fa-check-circle mr-1"></i>Graded
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-amber-100 text-amber-700 rounded-lg font-bold border border-amber-200">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-200 text-center">
                                <div class="text-2xl font-bold text-blue-700">{{ $submission->exam->questions()->count() }}</div>
                                <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide mt-1">Questions</div>
                            </div>
                            <div class="bg-purple-50 rounded-xl p-4 border-2 border-purple-200 text-center">
                                <div class="text-2xl font-bold text-purple-700">{{ $submission->exam->total_marks }}</div>
                                <div class="text-xs text-purple-600 font-semibold uppercase tracking-wide mt-1">Total Marks</div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 border-2 border-green-200 text-center">
                                <div class="text-lg font-bold text-green-700">{{ $submission->submitted_at->format('M d, Y') }}</div>
                                <div class="text-xs text-green-600 font-semibold uppercase tracking-wide mt-1">Submitted</div>
                                <div class="text-xs text-teal-600 mt-1">{{ $submission->submitted_at->format('g:i A') }}</div>
                            </div>
                            <div class="bg-amber-50 rounded-xl p-4 border-2 border-amber-200 text-center">
                                <div class="text-2xl font-bold text-amber-700" id="total-score">0</div>
                                <div class="text-xs text-amber-600 font-semibold uppercase tracking-wide mt-1">Current Score</div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('instructor.final-exams.save-grades', $submission->id) }}" method="POST" id="grading-form">
                    @csrf

                    <!-- Questions -->
                    @foreach($submission->answers as $answer)
                        <div class="question-card bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden mb-6 opacity-0 animate-slide-in">
                            <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                                <span class="text-white font-bold">{{ $answer->question->question_number }}</span>
                                            </div>
                                            <h3 class="text-xl font-bold text-teal-900">Question {{ $answer->question->question_number }}</h3>
                                        </div>
                                        <p class="text-teal-700 leading-relaxed">{{ $answer->question->question_text }}</p>
                                        
                                        @if($answer->question->marking_criteria)
                                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 mt-4">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="fas fa-list-check text-blue-600"></i>
                                                    <span class="text-xs font-bold text-blue-900 uppercase tracking-wide">Marking Criteria</span>
                                                </div>
                                                <p class="text-sm text-teal-700">{{ $answer->question->marking_criteria }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="ml-4 px-4 py-2 bg-amber-100 text-amber-700 rounded-lg font-bold border border-amber-200 whitespace-nowrap">
                                        <i class="fas fa-star mr-1"></i>{{ $answer->question->marks }} marks
                                    </span>
                                </div>
                            </div>

                            <div class="p-8">
                                <h4 class="text-sm font-bold text-teal-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-image text-primary-700"></i>Student's Answer
                                </h4>
                                
                                @php
                                    $images = $answer->answer_images ? json_decode($answer->answer_images, true) : [];
                                @endphp

                                @if(count($images) > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        @foreach($images as $imageUrl)
                                            <div class="relative group cursor-pointer rounded-xl overflow-hidden border-2 border-teal-200 hover:border-primary-600 transition-all" onclick="enlargeImage('{{ $imageUrl }}')">
                                                <img src="{{ $imageUrl }}" alt="Answer" class="w-full h-56 object-cover">
                                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                                                    <span class="text-white font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <i class="fas fa-search-plus text-2xl"></i>
                                                    </span>
                                                </div>
                                                <div class="absolute top-2 right-2 bg-black bg-opacity-70 text-white px-3 py-1 rounded-lg text-xs font-semibold">
                                                    Click to enlarge
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-teal-50 border-2 border-dashed border-teal-300 rounded-xl p-8 text-center">
                                        <i class="fas fa-image text-4xl text-teal-400 mb-2"></i>
                                        <p class="text-teal-600">No images uploaded</p>
                                    </div>
                                @endif
                            </div>

                            <div class="px-8 pb-8 pt-6 bg-gradient-to-r from-teal-50 to-white border-t border-teal-200">
                                <h4 class="text-sm font-bold text-teal-900 mb-4 flex items-center gap-2">
                                    <i class="fas fa-pen text-green-600"></i>Grading
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-teal-900 mb-2">
                                            Marks (out of {{ $answer->question->marks }})
                                        </label>
                                        <input type="number" 
                                               name="marks[{{ $answer->id }}]" 
                                               min="0" 
                                               max="{{ $answer->question->marks }}" 
                                               step="0.5"
                                               class="w-full px-4 py-3 border-2 border-teal-200 rounded-xl focus:border-primary-600 focus:ring-4 focus:ring-primary-100 transition-all outline-none font-bold text-lg"
                                               placeholder="0"
                                               value="{{ $answer->marks_obtained ?? '' }}"
                                               required
                                               onchange="calculateTotal()">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-bold text-teal-900 mb-2">
                                            Comment/Feedback (Optional)
                                        </label>
                                        <textarea name="comments[{{ $answer->id }}]" 
                                                  rows="3"
                                                  class="w-full px-4 py-3 border-2 border-teal-200 rounded-xl focus:border-primary-600 focus:ring-4 focus:ring-primary-100 transition-all outline-none font-medium resize-none"
                                                  placeholder="Write your feedback...">{{ $answer->instructor_comment ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($submission->webcam_playback_id)
                        <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden mb-6 opacity-0 animate-slide-in">
                            <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                                <h3 class="text-xl font-bold text-teal-900 flex items-center gap-2">
                                    <i class="fas fa-video text-red-600"></i>Webcam Recording
                                </h3>
                            </div>
                            <div class="p-8">
                                <video controls class="w-full max-w-2xl mx-auto rounded-xl border-2 border-teal-200">
                                    <source src="https://stream.mux.com/{{ $submission->webcam_playback_id }}.m3u8" type="application/x-mpegURL">
                                </video>
                            </div>
                        </div>
                    @endif

                    <!-- Summary -->
                    <div class="bg-white rounded-3xl shadow-xl border border-teal-100 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.4s;">
                        <div class="px-8 py-6 border-b border-teal-200 bg-gradient-to-r from-teal-50 to-white">
                            <h3 class="text-xl font-bold text-teal-900 flex items-center gap-2">
                                <i class="fas fa-clipboard-check text-primary-700"></i>Overall Feedback & Summary
                            </h3>
                        </div>
                        
                        <div class="p-8">
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-teal-900 mb-2">
                                    <i class="fas fa-comment-dots text-blue-600 mr-2"></i>Overall Feedback
                                </label>
                                <textarea name="overall_feedback" 
                                          rows="4"
                                          class="w-full px-4 py-3 border-2 border-teal-200 rounded-xl focus:border-primary-600 focus:ring-4 focus:ring-primary-100 transition-all outline-none font-medium resize-none"
                                          placeholder="Write overall feedback for the student...">{{ $submission->instructor_feedback ?? '' }}</textarea>
                            </div>

                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-200 mb-6">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Total Score</div>
                                        <div class="text-3xl font-bold text-teal-900" id="total-score-display">0</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Out of</div>
                                        <div class="text-3xl font-bold text-teal-900">{{ $submission->exam->total_marks }}</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Percentage</div>
                                        <div class="text-3xl font-bold text-teal-900" id="percentage">0%</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-xs text-teal-600 font-semibold uppercase tracking-wide mb-2">Result</div>
                                        <div id="result-badge" class="mt-1">
                                            <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs font-bold">Not Graded</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $submission->status === 'graded' ? 'Update Grading' : 'Submit Grading' }} & Notify Student</span>
                                </button>
                                <a href="{{ route('instructor.final-exams.submissions', $submission->exam->id) }}" 
                                   class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-700 border-2 border-primary-700 rounded-xl font-semibold hover:bg-primary-700 hover:text-white transition-all">
                                    <i class="fas fa-times"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Image Modal -->
    <div id="image-modal" class="modal" onclick="closeModal()">
        <button class="absolute top-4 right-4 w-12 h-12 bg-white rounded-full flex items-center justify-center text-2xl font-bold hover:bg-teal-100 transition-colors" onclick="closeModal()">×</button>
        <img id="modal-image" src="" onclick="event.stopPropagation()">
    </div>

    <script>
        function calculateTotal() {
            let total = 0;
            const totalMarks = {{ $submission->exam->total_marks }};
            
            document.querySelectorAll('input[name^="marks"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('total-score').textContent = total.toFixed(1);
            document.getElementById('total-score-display').textContent = total.toFixed(1);
            
            const percentage = (total / totalMarks * 100).toFixed(1);
            document.getElementById('percentage').textContent = percentage + '%';

            const resultBadge = document.getElementById('result-badge');
            if (percentage >= 70) {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold border border-green-200"><i class="fas fa-check-circle mr-1"></i>PASS</span>';
            } else if (percentage > 0) {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold border border-red-200"><i class="fas fa-times-circle mr-1"></i>FAIL</span>';
            } else {
                resultBadge.innerHTML = '<span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs font-bold">Not Graded</span>';
            }
        }

        function enlargeImage(imageUrl) {
            document.getElementById('modal-image').src = imageUrl;
            document.getElementById('image-modal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('image-modal').classList.remove('active');
        }

        document.getElementById('grading-form').addEventListener('submit', function(e) {
            const inputs = document.querySelectorAll('input[name^="marks"]');
            let allFilled = true;

            inputs.forEach(input => {
                if (input.value === '' || input.value === null) allFilled = false;
            });

            if (!allFilled) {
                e.preventDefault();
                alert('Please enter marks for all questions before submitting!');
                return false;
            }

            return confirm('Are you sure you want to submit this grading? The student will be notified.');
        });

        calculateTotal();
    </script>
</body>
</html>