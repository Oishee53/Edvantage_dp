<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Details - Edvantage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        i[class^="fa-"], i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free" !important;
            font-style: normal;
            font-weight: 900 !important;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-question text-gray-600 text-xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Question Details</h1>
                <p class="text-gray-600">Review the status and response from your instructor</p>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <!-- Question -->
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Your Question</h2>
                <p class="text-gray-700">{{ $question->content }}</p>
            </div>

            <!-- Status -->
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Status</h2>
                @if($question->status === 'answered')
                    <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fa-solid fa-check-circle"></i> Answered
                    </span>
                @elseif($question->status === 'rejected')
                    <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fa-solid fa-xmark-circle"></i> Rejected
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fa-solid fa-hourglass-half"></i> Pending Review
                    </span>
                @endif
            </div>

            <!-- Answer / Message -->
            <div class="px-6 py-5">
                @if($question->status === 'answered')
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Instructor’s Answer</h2>
                    <p class="text-gray-700">{{ $question->answer }}</p>
                @elseif($question->status === 'rejected')
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-exclamation text-red-500 mt-1"></i>
                        <p class="text-red-600">This question was rejected by the instructor.</p>
                    </div>
                @else
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-clock text-yellow-500 mt-1"></i>
                        <p class="text-yellow-600">Your question is still pending review.</p>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <a href="/homepage" class="inline-flex items-center gap-2 bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-800 transition">
                    <i class="fa-solid fa-arrow-left"></i> Back to homepage
                </a>
            </div>
        </div>
    </div>
</body>
</html>
