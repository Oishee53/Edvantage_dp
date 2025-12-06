<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->title }} - lectures</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Course Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex items-center gap-4 mb-4">
                
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                    <p class="text-gray-600 mt-1">Course lectures</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ count($modules) }} Lectures</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Self-paced</span>
                </div>
            </div>
        </div>

        <!-- Modules List -->
        <div class="space-y-4">
            @forelse ($modules as $moduleNumber)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-accent/20 transition-all duration-200 group">
                    <a href="{{ route('inside.module', ['courseId' => $course->id, 'moduleNumber' => $moduleNumber]) }}" 
                       class="block p-6 hover:bg-gray-50/50 rounded-lg transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <!-- Module Number Badge -->
                                <div class="w-12 h-12 bg-gray-100 group-hover:bg-accent group-hover:text-white rounded-lg flex items-center justify-center font-semibold text-gray-700 transition-all duration-200">
                                    {{ $moduleNumber }}
                                </div>
                                
                                <!-- Module Info -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-accent transition-colors duration-200">
                                        Lecture {{ $moduleNumber }}
                                    </h3>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Click to access lectures content
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Status and Arrow -->
                            <div class="flex items-center gap-3">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                    Available
                                </span>
                                
                                <!-- Arrow Icon -->
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-accent group-hover:translate-x-1 transition-all duration-200" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No lectures found</h3>
                    <p class="text-gray-600">This course doesn't have any lectures yet. Check back later!</p>
                </div>
            @endforelse
        </div>
        
      
</body>
</html>


