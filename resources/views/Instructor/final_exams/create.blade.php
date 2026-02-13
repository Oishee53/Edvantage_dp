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
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
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
        
        .upload-box {
            border: 3px dashed #d1d5db;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .upload-box:hover {
            border-color: #0d9488;
            background: #f0fdfa;
        }
        .upload-box.active {
            border-color: #0d9488;
            background: #ccfbf1;
        }
        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #0d9488;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
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

                    <!-- OCR Upload Section -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in" style="animation-delay: 0.1s;">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-cyan-50">
                            <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-camera text-white text-sm"></i>
                                </div>
                                Upload Exam Questions Image (Optional)
                            </h2>
                            <p class="text-sm text-teal-600 mt-1 ml-12">Upload an image of written exam questions to auto-extract them</p>
                        </div>
                        
                        <div class="p-6">
                            <input type="file" id="fileInput" accept="image/*" style="display: none;">
                            
                            <div id="uploadBox" class="upload-box" onclick="document.getElementById('fileInput').click()">
                                <div id="uploadContent">
                                    <i class="fas fa-cloud-upload-alt" style="font-size: 48px; color: #0d9488; margin-bottom: 16px;"></i>
                                    <p style="font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 8px;">
                                        Click to upload or drag and drop
                                    </p>
                                    <p style="color: #64748b; font-size: 14px;">PNG, JPG up to 10MB</p>
                                    <button type="button" id="browse-btn" class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-all mt-4">
                                        <i class="fas fa-folder-open"></i>
                                        Browse Files
                                    </button>
                                </div>

                                <div id="processingContent" style="display: none;">
                                    <div class="spinner"></div>
                                    <p id="statusText" style="margin-top: 16px; color: #0d9488; font-weight: 600;">Processing...</p>
                                </div>

                                <div id="previewContent" style="display: none;">
                                    <img id="imagePreview" style="max-width: 100%; max-height: 300px; border-radius: 8px; margin-bottom: 16px;">
                                    <button type="button" onclick="removeImage(event)" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100 transition-all">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>

                            <div id="extractedInfo" style="display: none; margin-top: 20px; padding: 16px; background: #dcfce7; border-left: 4px solid #22c55e; border-radius: 8px;">
                                <p style="color: #166534; font-weight: 600;">
                                    ✅ <span id="extractedCount"></span>
                                </p>
                            </div>

                            <div id="errorInfo" style="display: none; margin-top: 20px; padding: 16px; background: #fee2e2; border-left: 4px solid #ef4444; border-radius: 8px;">
                                <p style="color: #991b1b; font-weight: 600;">
                                    ❌ <span id="errorText"></span>
                                </p>
                            </div>

                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <h4 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                                    <i class="fas fa-lightbulb"></i>
                                    Format Tips:
                                </h4>
                                <ul class="text-sm text-blue-800 space-y-1 ml-6 list-disc">
                                    <li>Number questions clearly (Q.1, Q.2, etc.)</li>
                                    <li>Include marks in format: "(5 marks)" or "[10m]"</li>
                                    <li>Use clear, legible handwriting</li>
                                    <li>Good lighting and contrast for best results</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6 mb-6 opacity-0 animate-slide-in" style="animation-delay: 0.15s;">
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
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.2s;">
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
        let extractedQuestions = [];

        // OCR functionality
        const fileInput = document.getElementById('fileInput');
        const uploadBox = document.getElementById('uploadBox');
        const browseBtn = document.getElementById('browse-btn');

        browseBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.click();
        });

        uploadBox.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
            const isProcessing = document.getElementById('processingContent').style.display !== 'none';
            const isPreview = document.getElementById('previewContent').style.display !== 'none';
            if (isProcessing || isPreview) return;
            fileInput.click();
        });

        uploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('active');
        });

        uploadBox.addEventListener('dragleave', () => {
            uploadBox.classList.remove('active');
        });

        uploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('active');
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                handleImageUpload(file);
            }
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                handleImageUpload(file);
            }
        });

        function handleImageUpload(file) {
            console.log('File selected:', file.name);
            
            document.getElementById('uploadContent').style.display = 'none';
            document.getElementById('previewContent').style.display = 'none';
            document.getElementById('processingContent').style.display = 'block';
            document.getElementById('errorInfo').style.display = 'none';
            document.getElementById('extractedInfo').style.display = 'none';

            const reader = new FileReader();
            reader.onload = function(event) {
                const imageData = event.target.result;
                document.getElementById('imagePreview').src = imageData;
                performOCR(imageData);
            };
            reader.readAsDataURL(file);
        }

        async function performOCR(imageData) {
            const statusText = document.getElementById('statusText');
            let worker = null;
            
            try {
                statusText.textContent = 'Preprocessing image...';
                const processedImage = await preprocessImage(imageData);
                
                statusText.textContent = 'Initializing OCR...';
                worker = await Tesseract.createWorker('eng', 1, {
                    logger: m => {
                        if (m.status === 'recognizing text') {
                            statusText.textContent = `Processing: ${Math.round(m.progress * 100)}%`;
                        }
                    }
                });

                statusText.textContent = 'Extracting text...';
                const { data: { text } } = await worker.recognize(processedImage);
                await worker.terminate();

                console.log('Extracted text:', text);

                statusText.textContent = 'Parsing questions...';
                extractedQuestions = parseExamQuestions(text);

                document.getElementById('processingContent').style.display = 'none';
                document.getElementById('previewContent').style.display = 'block';

                if (extractedQuestions.length > 0) {
                    document.getElementById('extractedCount').textContent = 
                        `Extracted ${extractedQuestions.length} question(s) successfully!`;
                    document.getElementById('extractedInfo').style.display = 'block';
                    
                    // Clear existing questions and add extracted ones
                    document.getElementById('questions-container').innerHTML = '';
                    questionCount = 0;
                    extractedQuestions.forEach(q => addQuestion(q));
                    updateTotalMarks();
                } else {
                    document.getElementById('errorText').textContent = 
                        'No questions detected. Please check format or add manually.';
                    document.getElementById('errorInfo').style.display = 'block';
                }

            } catch (error) {
                console.error('OCR Error:', error);
                document.getElementById('processingContent').style.display = 'none';
                document.getElementById('uploadContent').style.display = 'block';
                document.getElementById('errorText').textContent = 'Failed to process image: ' + error.message;
                document.getElementById('errorInfo').style.display = 'block';
            }
        }

        function preprocessImage(imageData) {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    
                    const imageDataObj = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imageDataObj.data;
                    
                    for (let i = 0; i < data.length; i += 4) {
                        const avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        const contrasted = avg > 128 ? 255 : 0;
                        data[i] = data[i + 1] = data[i + 2] = contrasted;
                    }
                    
                    ctx.putImageData(imageDataObj, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                img.src = imageData;
            });
        }

        function parseExamQuestions(text) {
            const questions = [];
            const lines = text.split('\n').filter(line => line.trim().length > 0);
            
            console.log('Parsing exam questions...');
            
            let currentQuestion = null;
            
            for (let line of lines) {
                line = line.trim();
                
                // Skip headers
                if (line.match(/^(EXAM|TEST|FINAL|INSTRUCTION|TOTAL|TIME)/i)) continue;
                
                // Detect question (Q.1, Q1, Question 1, 1., etc.)
                const qMatch = line.match(/^(?:Q\.?\s*(\d+)|Question\s*(\d+)|(\d+)[\.)]\s*)(.+)/i);
                
                if (qMatch) {
                    // Save previous question
                    if (currentQuestion && currentQuestion.text) {
                        questions.push(currentQuestion);
                    }
                    
                    // New question
                    const questionText = qMatch[4] || line;
                    currentQuestion = {
                        text: questionText.trim(),
                        marks: 10 // Default
                    };
                    
                    console.log('Found question:', currentQuestion.text);
                } else if (currentQuestion) {
                    // Check for marks indication: (5 marks), [10m], (20), etc.
                    const marksMatch = line.match(/[\(\[]?\s*(\d+)\s*(?:marks?|m|pts?|points?)?\s*[\)\]]?/i);
                    if (marksMatch && !currentQuestion.marksFound) {
                        currentQuestion.marks = parseInt(marksMatch[1]);
                        currentQuestion.marksFound = true;
                        console.log('Found marks:', currentQuestion.marks);
                    } else {
                        // Continue question text
                        currentQuestion.text += ' ' + line;
                    }
                }
            }
            
            // Add last question
            if (currentQuestion && currentQuestion.text) {
                questions.push(currentQuestion);
            }
            
            console.log('Parsed questions:', questions);
            return questions;
        }

        function removeImage(event) {
            event.stopPropagation();
            document.getElementById('uploadContent').style.display = 'block';
            document.getElementById('previewContent').style.display = 'none';
            document.getElementById('extractedInfo').style.display = 'none';
            document.getElementById('errorInfo').style.display = 'none';
            fileInput.value = '';
            extractedQuestions = [];
        }

        // Add initial question on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (extractedQuestions.length === 0) {
                addQuestion();
            }
            updateTotalMarks();
            
            document.getElementById('total_marks').addEventListener('input', function() {
                updateTotalMarks();
            });
        });

        function addQuestion(extractedData = null) {
            questionCount++;
            const container = document.getElementById('questions-container');
            
            const questionText = extractedData ? extractedData.text : '';
            const marks = extractedData ? extractedData.marks : 20;
            
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
                        ${extractedData ? '<span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium"><i class="fas fa-magic mr-1"></i>Auto-filled</span>' : ''}
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
                        required>${questionText}</textarea>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-bold text-teal-900 mb-2">
                        Marks for this Question <span class="text-gray-600">*</span>
                    </label>
                    <input type="number" name="questions[${questionCount-1}][marks]" 
                        class="question-marks-input w-full md:w-48 px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-gray-600 transition-all outline-none font-medium" 
                        min="1" 
                        step="0.5"
                        value="${marks}" 
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
            
            const display = document.getElementById('totalMarksCheck');
            const icon = display.querySelector('i');
            const sumSpan = document.getElementById('sumDisplay');
            const targetSpan = document.getElementById('targetMarks');
            
            if (sum === targetMarks) {
                display.className = 'bg-green-50 border-2 border-green-200 rounded-xl p-6 text-center mb-6 shadow-md';
                icon.className = 'fas fa-check-circle text-green-600 text-xl';
                sumSpan.className = 'text-green-700 font-bold';
                targetSpan.className = 'text-green-700 font-bold';
            } else {
                display.className = 'bg-amber-50 border border-amber-200 rounded-xl p-6 text-center mb-6 shadow-md';
                icon.className = 'fas fa-calculator text-amber-600 text-xl';
                sumSpan.className = 'text-amber-700 font-bold';
                targetSpan.className = 'text-amber-700 font-bold';
            }
        }

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