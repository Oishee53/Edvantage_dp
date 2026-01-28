<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Final Exam</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
        .question-card:nth-child(1) { animation-delay: 0.1s; }
        .question-card:nth-child(2) { animation-delay: 0.15s; }
        .question-card:nth-child(3) { animation-delay: 0.2s; }
        .question-card:nth-child(4) { animation-delay: 0.25s; }
        .question-card:nth-child(5) { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <main class="flex-1 transition-all duration-300"
              :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
            
            <x-instructor-header :title="$pageTitle ?? 'Create Final Exam'" />

            <!-- Page Content -->
            <div class="p-6 lg:p-8 max-w-4xl mx-auto">
                @auth
                    <!-- Info Box -->
                    <div class="bg-teal-50 rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in">
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-info-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-teal-900 mb-1">Important Information</h3>
                                    <p class="text-teal-700">You can save as draft or publish immediately. Passing mark is automatically set to 70%.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6 mb-6 opacity-0 animate-slide-in" style="animation-delay: 0.1s;">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-red-900 mb-2">Please fix the following errors:</h3>
                                    <ul class="space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-red-700 flex items-center gap-2">
                                                <i class="fas fa-circle text-xs"></i>
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.15s;">
                        <div class="px-12 py-6 border-b border-gray-200 bg-gray-50">
                            <h2 class="text-2xl font-bold text-teal-800 flex items-center gap-3">
                                Exam Details
                            </h2>
                        </div>
                        
                        <div class="p-12">
                            <form action="{{ route('instructor.final-exams.store') }}" method="POST" id="examForm">
                                @csrf

                                <!-- Course Selection -->
                                <div class="mb-6">
                                    <label for="course_id" class="block text-sm font-bold text-teal-900 mb-2">
                                        Select Course <span class="text-gray-600">*</span>
                                    </label>
                                    <select name="course_id" id="course_id" 
                                        class="w-full px-4 py-3 border-2 border-gray-200 focus:border-gray-600 transition-all rounded-xl outline-none font-medium bg-white" 
                                        required>
                                        <option value="">-- Select Course --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Exam Title -->
                                <div class="mb-6">
                                    <label for="title" class="block text-sm font-bold text-teal-900 mb-2">
                                        Exam Title <span class="text-gray-600">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium" 
                                        placeholder="Final Written Examination"
                                        required>
                                </div>

                                <!-- Description -->
                                <div class="mb-6">
                                    <label for="description" class="block text-sm font-bold text-teal-900 mb-2">
                                        Description / Instructions
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium resize-none" 
                                        placeholder="Provide instructions or overview for students">{{ old('description') }}</textarea>
                                </div>

                                <!-- Total Marks and Duration -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="total_marks" class="block text-sm font-bold text-teal-900 mb-2">
                                            Total Marks <span class="text-gray-600">*</span>
                                        </label>
                                        <input type="number" name="total_marks" id="total_marks" 
                                            value="{{ old('total_marks', 100) }}" min="1"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium" 
                                            required>
                                        <p class="text-sm text-gray-600 mt-1 pl-2">Must match sum of question marks</p>
                                    </div>

                                    <div>
                                        <label for="duration_minutes" class="block text-sm font-bold text-teal-900 mb-2">
                                            Duration (minutes) <span class="text-gray-600">*</span>
                                        </label>
                                        <input type="number" name="duration_minutes" id="duration_minutes" 
                                            value="{{ old('duration_minutes', 180) }}" min="30" max="480"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium" 
                                            required>
                                        <p class="text-sm text-gray-600 mt-1 pl-2">Default: 180 minutes (3 hours)</p>
                                    </div>
                                </div>

                                <hr class="my-8 border-gray-200">

                                <!-- Questions Section Header -->
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-bold text-teal-900 flex items-center gap-2">
                                        Exam Questions
                                    </h3>
                                    <button type="button" onclick="addQuestion()" 
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-teal-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5 text-sm">
                                        <i class="fas fa-plus"></i>
                                        Add Question
                                    </button>
                                </div>

                                <!-- Questions Container -->
                                <div id="questions-container" class="space-y-4 mb-6">
                                    <!-- Questions will be added here dynamically -->
                                </div>

                                <!-- Total Marks Display -->
                                <div id="totalMarksCheck" class="bg-amber-50 border border-amber-200 rounded-xl p-6 text-center mb-6 shadow-md">
                                    <div class="flex items-center justify-center gap-3">
                                        <i class="fas fa-calculator text-amber-600 text-xl"></i>
                                        <p class="text-lg font-semibold text-teal-900">
                                            Total Question Marks: <span id="sumDisplay" class="text-amber-700 font-bold">0</span> / <span id="targetMarks" class="text-amber-700 font-bold">100</span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Publish Option -->
                                <div class="bg-teal-50 rounded-xl border border-teal-200 p-6 mb-6 shadow-md">
                                    <label class="flex items-start gap-3 cursor-pointer group">
                                        <input type="checkbox" name="publish_now" value="1" 
                                            class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 transition-all mt-0.5 cursor-pointer">
                                        <div>
                                            <span class="text-sm font-bold text-teal-900 group-hover:text-teal-700 transition-colors">
                                                <i class="fas fa-globe text-green-600 mr-2"></i>Publish immediately (make available to students now)
                                            </span>
                                            <p class="text-sm text-teal-600 mt-1">
                                                If unchecked, exam will be saved as draft. You can publish it later.
                                            </p>
                                        </div>
                                    </label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                                    <button type="submit" 
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-3 bg-teal-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Create Final Exam</span>
                                    </button>
                                    
                                    <a href="javascript:history.back()" 
                                        class="inline-flex items-center gap-2 px-8 py-3 bg-white text-teal-700 border-2 border-teal-700 rounded-xl font-semibold hover:bg-teal-700 hover:text-white transition-all">
                                        <i class="fas fa-times"></i>
                                        <span>Cancel</span>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                @else
                    <!-- Not Logged In -->
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-16 text-center">
                            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-lock text-4xl text-red-600"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-teal-900 mb-3">Access Denied</h2>
                            <p class="text-teal-600 mb-6">You need to be logged in to view this page.</p>
                            <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                                <i class="fas fa-sign-in-alt"></i>
                                Go to Login
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </main>
    </div>

    <script>
        let questionCount = 0;

        // Add initial question on page load
        document.addEventListener('DOMContentLoaded', function() {
            addQuestion();
            updateTotalMarks();
            
            // Watch for changes in total_marks input to update the target
            document.getElementById('total_marks').addEventListener('input', function() {
                updateTotalMarks();
            });
        });

        function addQuestion() {
            questionCount++;
            const container = document.getElementById('questions-container');
            
            const questionCard = document.createElement('div');
            questionCard.className = 'question-card bg-gray-50 border-2 border-gray-200 rounded-2xl p-6 hover:border-gray-300 hover:shadow-lg transition-all duration-200 opacity-0 animate-slide-in';
            questionCard.setAttribute('data-question-number', questionCount);
            questionCard.innerHTML = `
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-700 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">${questionCount}</span>
                        </div>
                        <h4 class="text-xl font-bold text-teal-900">Question ${questionCount}</h4>
                    </div>
                    <button type="button" onclick="removeQuestion(this)" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-all text-sm">
                        <i class="fas fa-trash"></i>
                        Remove
                    </button>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-teal-900 mb-2">
                       Question Text <span class="text-gray-600">*</span>
                    </label>
                    <textarea name="questions[${questionCount-1}][question_text]" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium resize-none" 
                        rows="3"
                        placeholder="Enter the question..."
                        required></textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-teal-900 mb-2">
                        Marks for this Question <span class="text-gray-600">*</span>
                    </label>
                    <input type="number" name="questions[${questionCount-1}][marks]" 
                        class="question-marks-input w-full md:w-48 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium" 
                        min="1" 
                        step="0.5"
                        value="20" 
                        oninput="updateTotalMarks()" 
                        required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-teal-900 mb-2">
                        Marking Criteria (Optional)
                    </label>
                    <textarea name="questions[${questionCount-1}][marking_criteria]" 
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium resize-none" 
                        rows="2"
                        placeholder="Guidelines for grading this question..."></textarea>
                </div>
            `;
            
            container.appendChild(questionCard);
            updateTotalMarks();
        }

        function removeQuestion(button) {
            if (document.querySelectorAll('.question-card').length <= 1) {
                alert('You must have at least one question!');
                return;
            }
            
            button.closest('.question-card').remove();
            updateQuestionNumbers();
            updateTotalMarks();
        }

        function updateQuestionNumbers() {
            const questions = document.querySelectorAll('.question-card');
            questions.forEach((card, index) => {
                const numberBadge = card.querySelector('.w-10.h-10 span');
                const titleText = card.querySelector('h4');
                if (numberBadge) numberBadge.textContent = index + 1;
                if (titleText) titleText.textContent = `Question ${index + 1}`;
                card.setAttribute('data-question-number', index + 1);
            });
        }

        function updateTotalMarks() {
            const marksInputs = document.querySelectorAll('.question-marks-input');
            let sum = 0;
            
            marksInputs.forEach(input => {
                const value = parseFloat(input.value) || 0;
                sum += value;
            });
            
            const targetMarks = parseFloat(document.getElementById('total_marks').value) || 100;
            
            document.getElementById('sumDisplay').textContent = sum.toFixed(1);
            document.getElementById('targetMarks').textContent = targetMarks.toFixed(1);
            
            // Visual feedback based on whether marks match
            const display = document.getElementById('totalMarksCheck');
            const icon = display.querySelector('i');
            const sumSpan = document.getElementById('sumDisplay');
            const targetSpan = document.getElementById('targetMarks');
            
            if (sum === targetMarks) {
                // Marks match - show green success state
                display.className = 'bg-green-50 border-2 border-green-200 rounded-xl p-6 text-center mb-6 shadow-md';
                icon.className = 'fas fa-check-circle text-green-600 text-xl';
                sumSpan.className = 'text-green-700 font-bold';
                targetSpan.className = 'text-green-700 font-bold';
            } else {
                // Marks don't match - show amber warning state
                display.className = 'bg-amber-50 border border-amber-200 rounded-xl p-6 text-center mb-6 shadow-md';
                icon.className = 'fas fa-calculator text-amber-600 text-xl';
                sumSpan.className = 'text-amber-700 font-bold';
                targetSpan.className = 'text-amber-700 font-bold';
            }
        }

        // Validate before submit
        document.getElementById('examForm').addEventListener('submit', function(e) {
            const marksInputs = document.querySelectorAll('.question-marks-input');
            let sum = 0;
            marksInputs.forEach(input => {
                sum += parseFloat(input.value) || 0;
            });
            
            const targetMarks = parseFloat(document.getElementById('total_marks').value) || 100;
            
            if (sum !== targetMarks) {
                e.preventDefault();
                alert(`Sum of question marks (${sum.toFixed(1)}) must equal total marks (${targetMarks.toFixed(1)})`);
            }
        });
    </script>
</body>
</html>