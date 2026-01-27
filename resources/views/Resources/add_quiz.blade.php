<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Quiz</title>
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
      document.getElementById('question_count').addEventListener('change', generateQuestions);

      function generateQuestions() {
        const count = parseInt(document.getElementById('question_count').value);
        const container = document.getElementById('questions-section');
        container.innerHTML = '';

        for (let i = 1; i <= count; i++) {
          const qDiv = document.createElement('div');
          qDiv.className = 'question-section bg-white border border-gray-200 rounded-xl p-5 hover:border-gray-900 hover:shadow-md transition-all duration-200 opacity-0 animate-slide-in';
          qDiv.innerHTML = `
            <div class="flex items-center gap-3 mb-5">
              <div class="w-9 h-9 bg-teal-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <span class="text-white font-bold text-sm">${i}</span>
              </div>
              <h3 class="text-lg font-bold text-teal-900">Question ${i}</h3>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-teal-900 mb-2">
                <i class="fas fa-question-circle text-teal-700 mr-2"></i>Question Text
              </label>
              <input type="text" name="questions[${i}][text]" 
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-medium" 
                placeholder="Enter your question here..."
                required>
            </div>

            <div class="mb-4">
              <label class="block text-sm font-bold text-teal-900 mb-2">
                <i class="fas fa-list text-teal-700 mr-2"></i>Number of Options
              </label>
              <div class="flex items-center gap-4">
                <input type="number" name="questions[${i}][option_count]" 
                  class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:border-gray-900 focus:ring-2 focus:ring-teal-900/10 transition-all outline-none font-bold text-center" 
                  min="2" max="6" value="4" onchange="generateOptions(${i}, this.value)" required>
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
          generateOptions(i, 4); // Default 4 options
        }
      }

      function generateOptions(qIndex, count) {
        const optContainer = document.getElementById(`options-${qIndex}`);
        optContainer.innerHTML = '';

        for (let j = 1; j <= count; j++) {
          const optionDiv = document.createElement('div');
          optionDiv.className = 'flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-300 hover:border-gray-900 transition-all group';
          optionDiv.innerHTML = `
            <span class="w-7 h-7 bg-gray-50 rounded-md flex items-center justify-center border border-gray-300 font-bold text-teal-700 text-sm flex-shrink-0 group-hover:border-gray-900 group-hover:text-teal-900 transition-all">${j}</span>
            <input type="text" name="questions[${qIndex}][options][${j}][text]" 
              class="flex-1 px-3 py-2 border-0 bg-transparent outline-none font-medium text-teal-900 placeholder-teal-400" 
              placeholder="Option ${j} text..." required>
            <div class="flex items-center gap-2 flex-shrink-0">
              <input type="radio" name="questions[${qIndex}][correct]" value="${j}" 
                class="w-4 h-4 text-teal-900 focus:ring-2 focus:ring-teal-900 cursor-pointer" required>
              <label class="text-sm font-bold text-teal-700 cursor-pointer select-none">Correct</label>
            </div>
          `;
          optContainer.appendChild(optionDiv);
        }
      }

      // Initial load
      generateQuestions();
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