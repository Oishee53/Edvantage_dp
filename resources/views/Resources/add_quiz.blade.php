<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Quiz - OCR Enabled</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5.0.4/dist/tesseract.min.js"></script>
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
    .question-section:nth-child(1) { animation-delay: 0.1s; }
    .question-section:nth-child(2) { animation-delay: 0.15s; }
    .question-section:nth-child(3) { animation-delay: 0.2s; }
    .question-section:nth-child(4) { animation-delay: 0.25s; }
    .question-section:nth-child(5) { animation-delay: 0.3s; }
    
    @media (min-width: 1024px) {
      aside {
        display: block !important;
      }
    }

    .upload-zone {
      border: 2px dashed #cbd5e1;
      transition: all 0.3s ease;
    }
    
    .upload-zone:hover {
      border-color: #0d9488;
      background-color: #f0fdfa;
    }
    
    .upload-zone.dragover {
      border-color: #0d9488;
      background-color: #ccfbf1;
      transform: scale(1.01);
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .spinner {
      animation: spin 1s linear infinite;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

  @auth
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024, sidebarCollapsed: false }" 
         @resize.window="if (window.innerWidth >= 1024) sidebarOpen = true; else if (window.innerWidth < 1024) sidebarCollapsed = false"
         class="flex min-h-screen">
      
      <!-- Sidebar Component -->
      @include('layouts.sidebar')

      <!-- Main Content Wrapper -->
      <main class="flex-1 transition-all duration-300"
            :class="sidebarCollapsed && window.innerWidth >= 1024 ? 'lg:ml-20' : 'lg:ml-72'">
        
        <!-- Header -->
        <x-instructor-header :title="$pageTitle ?? 'Add New Quiz'" />

        <!-- Main Content -->
        <div class="p-4 lg:p-6 max-w-7xl mx-auto px-20">
          <!-- Course Info Card -->
          <div class="bg-teal-600 rounded-2xl shadow-sm overflow-hidden mb-6 opacity-0 animate-slide-in">
            <div class="p-6">
              <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                  <i class="fas fa-book-open text-white text-sm"></i>
                </div>
                <div>
                  <p class="text-sm text-teal-300 font-medium">Creating quiz for</p>
                  <h3 class="text-lg font-bold text-white">{{ $course->title ?? 'Sample Course Title' }} - Lecture {{ $moduleNumber ?? '1' }}</h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Image Upload Section -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6 opacity-0 animate-slide-in" style="animation-delay: 0.1s;">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-teal-50 to-cyan-50">
              <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                  <i class="fas fa-camera text-white text-sm"></i>
                </div>
                Upload MCQ Image (Optional)
              </h2>
              <p class="text-sm text-teal-600 mt-1 ml-12">Upload a handwritten or printed image of MCQs to auto-fill questions</p>
            </div>
            
            <div class="p-6">
              <div id="upload-zone" class="upload-zone rounded-xl p-8 text-center cursor-pointer">
                <input type="file" id="image-upload" accept="image/*" class="hidden">
                <div id="upload-prompt">
                  <div class="w-16 h-16 bg-teal-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cloud-upload-alt text-3xl text-teal-600"></i>
                  </div>
                  <h3 class="text-lg font-bold text-teal-900 mb-2">Click or drag image here</h3>
                  <p class="text-sm text-teal-600 mb-4">Supports JPG, PNG, JPEG (Max 10MB)</p>
                  <button type="button" id="browse-btn" class="inline-flex items-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-700 transition-all">
                    <i class="fas fa-folder-open"></i>
                    Browse Files
                  </button>
                </div>
                
                <div id="processing-status" class="hidden">
                  <div class="w-16 h-16 bg-teal-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-spinner spinner text-3xl text-teal-600"></i>
                  </div>
                  <h3 class="text-lg font-bold text-teal-900 mb-2">Processing Image...</h3>
                  <p class="text-sm text-teal-600" id="ocr-progress">Extracting text from image</p>
                </div>

                <div id="preview-container" class="hidden">
                  <img id="image-preview" class="max-w-full max-h-64 mx-auto rounded-lg shadow-md mb-4">
                  <button type="button" onclick="removeImage()" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-lg font-medium hover:bg-red-100 transition-all">
                    <i class="fas fa-trash"></i>
                    Remove Image
                  </button>
                </div>
              </div>

              <div id="extraction-tips" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                  <i class="fas fa-lightbulb"></i>
                  Tips for Better Results:
                </h4>
                <ul class="text-sm text-blue-800 space-y-1 ml-6 list-disc">
                  <li>Use clear, well-lit images with good contrast</li>
                  <li>Format: Question text followed by options (A, B, C, D or 1, 2, 3, 4)</li>
                  <li>Mark correct answers with asterisk (*) or "correct" label</li>
                  <li>Keep handwriting legible and avoid overlapping text</li>
                  <li>One question per section for best accuracy</li>
                </ul>
              </div>

              <!-- Debug Section -->
              <div id="debug-section" class="mt-4 hidden">
                <button type="button" onclick="toggleDebugView()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-all text-sm">
                  <i class="fas fa-code"></i>
                  <span>View Extracted Text (Debug)</span>
                </button>
                <div id="debug-text-view" class="hidden mt-3 p-4 bg-gray-900 text-green-400 rounded-lg font-mono text-sm max-h-64 overflow-y-auto">
                  <pre id="debug-text-content"></pre>
                </div>
              </div>
            </div>
          </div>

          <!-- Quiz Form Card -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden opacity-0 animate-slide-in" style="animation-delay: 0.15s;">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
              <h2 class="text-xl font-bold text-teal-900 flex items-center gap-3">
                <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center">
                  <i class="fas fa-clipboard-question text-white text-sm"></i>
                </div>
                Quiz Details
              </h2>
            </div>
            
            <div class="p-6">
              <form action="{{ route('quiz.store', ['course' => $course->id ?? 1, 'module' => $moduleNumber ?? 1]) }}" method="POST">
                @csrf

                <input type="hidden" name="course_id" value="{{ $course->id ?? 1 }}">
                <input type="hidden" name="module_number" value="{{ $moduleNumber ?? 1 }}">

                <!-- Quiz Title -->
                <div class="mb-6">
                  <label for="title" class="block text-sm font-bold text-teal-900 mb-2">
                    <i class="fas fa-heading text-teal-700 mr-2"></i>Quiz Title
                  </label>
                  <input type="text" name="title" id="title" 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                    placeholder="Enter quiz title..."
                    required>
                </div>

                <!-- Quiz Description -->
                <div class="mb-6">
                  <label for="description" class="block text-sm font-bold text-teal-900 mb-2">
                    <i class="fas fa-align-left text-teal-700 mr-2"></i>Quiz Description
                  </label>
                  <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium resize-none" 
                    placeholder="Describe the quiz and what students will learn..."
                    required></textarea>
                </div>

                <hr class="my-6 border-gray-200">

                <!-- Number of Questions -->
                <div class="mb-6">
                  <label for="question_count" class="block text-sm font-bold text-teal-900 mb-2">
                    <i class="fas fa-list-ol text-teal-700 mr-2"></i>Number of Questions
                  </label>
                  <div class="flex items-center gap-4">
                    <input type="number" name="question_count" id="question_count" 
                      class="w-32 px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-bold text-center text-lg" 
                      min="1" max="20" value="5" required>
                    <span class="text-sm text-teal-600 font-medium">Choose between 1 and 20 questions</span>
                  </div>
                </div>

                <!-- Questions Section -->
                <div id="questions-section" class="space-y-4">
                  <!-- Questions will be generated by JavaScript -->
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-3 mt-6 pt-6 border-t border-gray-200">
                  <button type="submit" class="w-full sm:flex-1 inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-teal-600 text-white rounded-lg font-medium hover:bg-teal-800 transition-all hover:shadow-md">
                    <i class="fas fa-check"></i>
                    <span>Create Quiz</span>
                  </button>
                  
                  <a href="javascript:history.back()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-teal-700 border border-gray-300 rounded-lg font-medium hover:bg-gray-50 hover:border-gray-900 transition-all">
                    <i class="fas fa-arrow-left"></i>
                    <span>Go Back</span>
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script>
      let extractedQuestions = [];
      let rawOCRText = '';

      function toggleDebugView() {
        const debugView = document.getElementById('debug-text-view');
        debugView.classList.toggle('hidden');
      }

      // File input and upload zone setup
      const uploadZone = document.getElementById('upload-zone');
      const imageUpload = document.getElementById('image-upload');
      const browseBtn = document.getElementById('browse-btn');

      // Browse button click handler
      browseBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        console.log('Browse button clicked');
        imageUpload.click();
      });

      // Upload zone click handler
      uploadZone.addEventListener('click', (e) => {
        console.log('Upload zone clicked');
        console.log('Target:', e.target.tagName);
        
        // Don't trigger if clicking on buttons inside
        if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
          console.log('Clicked on button, ignoring zone click');
          return;
        }
        
        // Don't trigger if processing or when preview is shown
        const isProcessing = !document.getElementById('processing-status').classList.contains('hidden');
        const isPreview = !document.getElementById('preview-container').classList.contains('hidden');
        
        console.log('Is processing:', isProcessing, 'Is preview:', isPreview);
        
        if (isProcessing || isPreview) {
          console.log('Processing or preview active, ignoring click');
          return;
        }
        
        console.log('Triggering file input click');
        imageUpload.click();
      });

      uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.classList.add('dragover');
      });

      uploadZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.classList.remove('dragover');
      });

      uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        e.stopPropagation();
        uploadZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
          document.getElementById('image-upload').files = e.dataTransfer.files;
          handleImageUpload(file);
        }
      });

      imageUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
          console.log('File selected from input:', file.name);
          handleImageUpload(file);
        } else {
          console.log('No file selected');
        }
      });

      function handleImageUpload(file) {
        console.log('=== handleImageUpload called ===');
        console.log('File:', file.name, 'Size:', file.size, 'Type:', file.type);
        
        // Validate file
        if (!file.type.startsWith('image/')) {
          showNotification('error', 'Please upload an image file (PNG, JPG, JPEG)');
          return;
        }
        
        if (file.size > 10 * 1024 * 1024) { // 10MB limit
          showNotification('error', 'File size too large. Please upload an image smaller than 10MB.');
          return;
        }
        
        // Show processing state
        document.getElementById('upload-prompt').classList.add('hidden');
        document.getElementById('preview-container').classList.add('hidden');
        document.getElementById('processing-status').classList.remove('hidden');
        document.getElementById('extraction-tips').style.display = 'none';

        // Read file
        const reader = new FileReader();
        
        reader.onerror = function(error) {
          console.error('FileReader error:', error);
          showNotification('error', 'Failed to read file. Please try again.');
          document.getElementById('processing-status').classList.add('hidden');
          document.getElementById('upload-prompt').classList.remove('hidden');
          document.getElementById('extraction-tips').style.display = 'block';
        };
        
        reader.onload = (e) => {
          console.log('File loaded, data length:', e.target.result.length);
          const imageData = e.target.result;
          document.getElementById('image-preview').src = imageData;
          // Start OCR processing
          performOCR(imageData);
        };
        
        console.log('Starting file read...');
        reader.readAsDataURL(file);
      }

      function removeImage() {
        console.log('Removing image...');
        document.getElementById('upload-prompt').classList.remove('hidden');
        document.getElementById('preview-container').classList.add('hidden');
        document.getElementById('processing-status').classList.add('hidden');
        document.getElementById('extraction-tips').style.display = 'block';
        document.getElementById('debug-section').classList.add('hidden');
        document.getElementById('image-upload').value = '';
        extractedQuestions = [];
        rawOCRText = '';
        console.log('Image removed, state reset');
      }

      async function performOCR(imageData) {
        let worker = null;
        try {
          const progressElement = document.getElementById('ocr-progress');
          
          progressElement.textContent = 'Initializing OCR engine...';
          console.log('Starting OCR process...');
          
          // Preprocess image to improve OCR accuracy
          progressElement.textContent = 'Preprocessing image...';
          const processedImage = await preprocessImage(imageData);
          
          progressElement.textContent = 'Initializing OCR engine...';
          console.log('Creating Tesseract worker...');
          
          // Create worker with better configuration
          worker = await Tesseract.createWorker('eng', 1, {
            logger: m => {
              console.log('Tesseract:', m);
              if (m.status === 'recognizing text') {
                progressElement.textContent = `Processing: ${Math.round(m.progress * 100)}%`;
              } else if (m.status) {
                progressElement.textContent = m.status;
              }
            }
          });

          console.log('Worker created successfully');
          progressElement.textContent = 'Analyzing image...';
          
          // Perform OCR with processed image
          const { data: { text, confidence } } = await worker.recognize(processedImage);
          
          console.log('OCR Complete. Confidence:', confidence);
          console.log('Extracted text length:', text.length);
          console.log('Raw OCR Text:', text);
          
          // Store raw text for debugging
          rawOCRText = text;
          document.getElementById('debug-text-content').textContent = text;
          document.getElementById('debug-section').classList.remove('hidden');
          
          await worker.terminate();
          console.log('Worker terminated');

          // Parse extracted text
          progressElement.textContent = 'Parsing questions...';
          
          if (!text || text.trim().length < 10) {
            throw new Error('No text extracted from image. Image may be too blurry or empty.');
          }
          
          extractedQuestions = parseQuestions(text);

          // Show preview
          document.getElementById('processing-status').classList.add('hidden');
          document.getElementById('preview-container').classList.remove('hidden');

          // Update question count and generate questions
          if (extractedQuestions.length > 0) {
            document.getElementById('question_count').value = extractedQuestions.length;
            generateQuestions();
            
            // Show success message
            showNotification('success', `Successfully extracted ${extractedQuestions.length} question(s)!`);
          } else {
            console.warn('No questions parsed from text');
            showNotification('warning', 'No questions detected. The text was extracted but could not be parsed into questions. Please check the format or enter manually.');
            // Still show the preview and allow manual entry
            generateQuestions();
          }

        } catch (error) {
          console.error('OCR Error Details:', error);
          if (error.stack) {
            console.error('Error stack:', error.stack);
          }
          
          if (worker) {
            try {
              await worker.terminate();
            } catch (e) {
              console.error('Error terminating worker:', e);
            }
          }
          
          document.getElementById('processing-status').classList.add('hidden');
          document.getElementById('upload-prompt').classList.remove('hidden');
          
          let errorMessage = 'Failed to process image. ';
          if (error.message && error.message.includes('Aborted')) {
            errorMessage += 'Image format issue. Try converting to a different format (JPG/PNG) or use a simpler image.';
          } else if (error.message && error.message.includes('network')) {
            errorMessage += 'Network error. Please check your internet connection.';
          } else if (error.message && error.message.includes('text extracted')) {
            errorMessage += error.message;
          } else {
            errorMessage += 'Please try a clearer image or enter manually.';
          }
          
          showNotification('error', errorMessage);
        }
      }

      // Preprocess image to improve OCR
      function preprocessImage(imageData) {
        return new Promise((resolve) => {
          const img = new Image();
          img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            // Set canvas size to image size
            canvas.width = img.width;
            canvas.height = img.height;
            
            // Draw image
            ctx.drawImage(img, 0, 0);
            
            // Get image data
            const imageDataObj = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageDataObj.data;
            
            // Simple contrast enhancement
            for (let i = 0; i < data.length; i += 4) {
              // Convert to grayscale
              const avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
              // Increase contrast
              const contrasted = avg > 128 ? 255 : 0;
              data[i] = data[i + 1] = data[i + 2] = contrasted;
            }
            
            // Put processed data back
            ctx.putImageData(imageDataObj, 0, 0);
            
            // Return as data URL
            resolve(canvas.toDataURL('image/png'));
          };
          img.src = imageData;
        });
      }

      function parseQuestions(text) {
        const questions = [];
        const lines = text.split('\n').map(line => line.trim()).filter(line => line.length > 0);
        
        let currentQuestion = null;
        let optionCounter = 0;
        let inQuestionBlock = false;
        
        console.log('=== OCR Text ===');
        console.log(text);
        console.log('=== Parsing Lines ===');
        
        for (let i = 0; i < lines.length; i++) {
          const line = lines[i];
          console.log(`Line ${i}: "${line}"`);
          
          // Skip headers and instructions
          if (line.match(/^(MCQ|TEST|QUIZ|SAMPLE|INSTRUCTION|MARK|Note)/i)) {
            console.log('  -> Skipped (header)');
            continue;
          }
          
          // Detect question patterns - more flexible
          // Pattern 1: Q.1, Q1, Q 1, Question 1, 1), 1., etc.
          const questionMatch = line.match(/^(?:Q\.?\s*\d+|Question\s*\d+|\d+[\.)]\s*)(.+)/i);
          
          // Pattern 2: Line ends with question mark and is substantial
          const isQuestion = questionMatch || (line.length > 15 && line.includes('?'));
          
          if (isQuestion) {
            // Save previous question if valid
            if (currentQuestion && currentQuestion.options.length >= 2) {
              questions.push(currentQuestion);
              console.log(`  -> Saved question: "${currentQuestion.text}" with ${currentQuestion.options.length} options`);
            }
            
            // Start new question
            currentQuestion = {
              text: questionMatch ? questionMatch[1].trim() : line.trim(),
              options: [],
              correct: null
            };
            optionCounter = 0;
            inQuestionBlock = true;
            console.log(`  -> New question detected: "${currentQuestion.text}"`);
            continue;
          }
          
          // Detect option patterns (only if we have a current question)
          if (currentQuestion && inQuestionBlock) {
            // Very flexible option pattern
            // Matches: A), (A), A., A:, a), 1), (1), 1., etc.
            const optionMatch = line.match(/^[(\[]?([A-Za-z]|[0-9])[)\].\s:]+(.+)/);
            
            if (optionMatch) {
              optionCounter++;
              const optionText = optionMatch[2].trim();
              const isCorrect = optionText.includes('*') || 
                               optionText.includes('✓') || 
                               optionText.includes('√') ||
                               optionText.toLowerCase().includes('correct') ||
                               optionText.includes('(correct)');
              
              const cleanText = optionText
                .replace(/[\*✓√]/g, '')
                .replace(/\s*\(correct\)/i, '')
                .replace(/\s*correct\s*/i, '')
                .trim();
              
              currentQuestion.options.push({
                text: cleanText,
                isCorrect: isCorrect
              });
              
              if (isCorrect && currentQuestion.correct === null) {
                currentQuestion.correct = optionCounter;
              }
              
              console.log(`  -> Option ${optionCounter}: "${cleanText}" ${isCorrect ? '(CORRECT)' : ''}`);
            } 
            // If line doesn't match option pattern but we have few options, try to add it
            else if (line.length > 3 && optionCounter < 6 && !line.match(/^[0-9]+$/)) {
              optionCounter++;
              const isCorrect = line.includes('*') || 
                               line.includes('✓') || 
                               line.includes('√') ||
                               line.toLowerCase().includes('correct');
              
              const cleanText = line
                .replace(/[\*✓√]/g, '')
                .replace(/\s*\(correct\)/i, '')
                .replace(/\s*correct\s*/i, '')
                .trim();
              
              currentQuestion.options.push({
                text: cleanText,
                isCorrect: isCorrect
              });
              
              if (isCorrect && currentQuestion.correct === null) {
                currentQuestion.correct = optionCounter;
              }
              
              console.log(`  -> Loose option ${optionCounter}: "${cleanText}" ${isCorrect ? '(CORRECT)' : ''}`);
            }
          }
        }
        
        // Add last question
        if (currentQuestion && currentQuestion.options.length >= 2) {
          questions.push(currentQuestion);
          console.log(`  -> Saved final question: "${currentQuestion.text}" with ${currentQuestion.options.length} options`);
        }
        
        // Set default correct answer if not marked
        questions.forEach((q, idx) => {
          if (q.correct === null && q.options.length > 0) {
            // Try to find first option marked as correct
            const correctIdx = q.options.findIndex(opt => opt.isCorrect);
            q.correct = correctIdx !== -1 ? correctIdx + 1 : 1;
          }
        });
        
        console.log(`=== Extracted ${questions.length} questions ===`);
        console.log(questions);
        
        return questions;
      }

      document.getElementById('question_count').addEventListener('change', generateQuestions);

      function generateQuestions() {
        const count = parseInt(document.getElementById('question_count').value);
        const container = document.getElementById('questions-section');
        container.innerHTML = '';

        console.log('=== generateQuestions called ===');
        console.log('Question count:', count);
        console.log('extractedQuestions array:', extractedQuestions);
        console.log('extractedQuestions length:', extractedQuestions.length);

        for (let i = 1; i <= count; i++) {
          const qDiv = document.createElement('div');
          qDiv.className = 'question-section bg-white border border-gray-200 rounded-xl p-5 hover:border-gray-900 hover:shadow-md transition-all duration-200 opacity-0 animate-slide-in';
          
          // Get extracted question data if available
          const extracted = extractedQuestions[i - 1] || null;
          console.log(`Question ${i} extracted data:`, extracted);
          
          const questionText = extracted ? extracted.text : '';
          const optionCount = extracted ? extracted.options.length : 4;
          
          console.log(`Question ${i}: text="${questionText}", optionCount=${optionCount}`);
          
          // Escape HTML for safe insertion
          const escapedQuestionText = questionText.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
          
          qDiv.innerHTML = `
            <div class="flex items-center gap-3 mb-5">
              <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">${i}</span>
              </div>
              <h3 class="text-lg font-bold text-teal-900">Question ${i}</h3>
              ${extracted ? '<span class="ml-auto text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium"><i class="fas fa-magic mr-1"></i>Auto-filled</span>' : ''}
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-teal-900 mb-2">
                <i class="fas fa-question-circle text-teal-700 mr-2"></i>Question Text
              </label>
              <input type="text" name="questions[${i}][text]" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                placeholder="Enter your question here..."
                value="${escapedQuestionText}"
                required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-teal-900 mb-2">
                <i class="fas fa-list text-teal-700 mr-2"></i>Number of Options
              </label>
              <div class="flex items-center gap-4">
                <input type="number" name="questions[${i}][option_count]" 
                  class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-bold text-center" 
                  min="2" max="6" value="${optionCount}" onchange="generateOptions(${i}, this.value)" required>
                <span class="text-sm text-teal-600 font-medium">Options (2-6)</span>
              </div>
            </div>

            <div class="bg-gray-50 rounded-lg border border-gray-200 p-4">
              <p class="text-sm font-bold text-teal-900 mb-3 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                Answer Options (Select the correct one)
              </p>
              <div id="options-${i}" class="space-y-2">
                <!-- Options will be generated here -->
              </div>
            </div>
          `;
          container.appendChild(qDiv);
          generateOptions(i, optionCount, extracted);
        }
      }

      function generateOptions(qIndex, count, extracted = null) {
        const optContainer = document.getElementById(`options-${qIndex}`);
        optContainer.innerHTML = '';

        console.log(`=== generateOptions for Q${qIndex} ===`);
        console.log('Count:', count);
        console.log('Extracted data:', extracted);

        for (let j = 1; j <= count; j++) {
          const optionDiv = document.createElement('div');
          optionDiv.className = 'flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-300 hover:border-gray-900 transition-all group';
          
          const extractedOption = extracted && extracted.options[j - 1] ? extracted.options[j - 1] : null;
          const optionText = extractedOption ? extractedOption.text : '';
          const isCorrect = extractedOption ? extractedOption.isCorrect : (j === 1);
          
          console.log(`Option ${j}: text="${optionText}", isCorrect=${isCorrect}, extracted.correct=${extracted ? extracted.correct : 'N/A'}`);
          
          // Escape HTML for safe insertion
          const escapedOptionText = optionText.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
          
          optionDiv.innerHTML = `
            <span class="w-7 h-7 bg-gray-50 rounded-md flex items-center justify-center border border-gray-300 font-bold text-teal-700 text-sm flex-shrink-0 group-hover:border-gray-900 group-hover:text-teal-900 transition-all">${j}</span>
            <input type="text" name="questions[${qIndex}][options][${j}][text]" 
              class="flex-1 px-3 py-2 border-0 bg-transparent outline-none font-medium text-teal-900 placeholder-teal-400" 
              placeholder="Option ${j} text..." 
              value="${escapedOptionText}"
              required>
            <div class="flex items-center gap-2 flex-shrink-0">
              <input type="radio" name="questions[${qIndex}][correct]" value="${j}" 
                class="w-4 h-4 text-teal-900 focus:ring-2 focus:ring-teal-900 cursor-pointer" 
                ${isCorrect || (extracted && extracted.correct === j) ? 'checked' : ''} required>
              <label class="text-sm font-bold text-teal-700 cursor-pointer select-none">Correct</label>
            </div>
          `;
          optContainer.appendChild(optionDiv);
        }
      }

      function showNotification(type, message) {
        const colors = {
          success: 'bg-green-500',
          warning: 'bg-yellow-500',
          error: 'bg-red-500'
        };
        
        const icons = {
          success: 'fa-check-circle',
          warning: 'fa-exclamation-triangle',
          error: 'fa-times-circle'
        };
        
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in`;
        notification.innerHTML = `
          <i class="fas ${icons[type]}"></i>
          <span class="font-medium">${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
          notification.style.opacity = '0';
          setTimeout(() => notification.remove(), 300);
        }, 4000);
      }

      // Initial load - only generate if no extracted questions
      if (extractedQuestions.length === 0) {
        generateQuestions();
      }
    </script>

  @else
    <!-- Not Logged In -->
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden max-w-md w-full">
        <div class="p-12 text-center">
          <div class="w-20 h-20 bg-red-50 rounded-xl flex items-center justify-center mx-auto mb-6 border border-red-200">
            <i class="fas fa-lock text-3xl text-red-600"></i>
          </div>
          <h2 class="text-2xl font-bold text-teal-900 mb-3">Access Denied</h2>
          <p class="text-teal-600 mb-6">You need to be logged in to view this page.</p>
          <a href="/" class="inline-flex items-center gap-2 px-6 py-3 bg-teal-600 text-white rounded-lg font-semibold hover:bg-teal-800 transition-all hover:shadow-lg">
            <i class="fas fa-sign-in-alt"></i>
            Go to Login
          </a>
        </div>
      </div>
    </div>
  @endauth
</body>
</html>