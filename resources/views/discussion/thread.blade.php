<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $thread->title }} - Discussion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#0E1B33',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-4xl">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('inside.module', ['courseId' => $forum->course_id, 'moduleNumber' => $forum->module->moduleId]) }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Course
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Thread Header --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                        {{ $forum->title }}
                    </span>
                    @if($thread->is_pinned)
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full flex items-center">
                            <i class="fas fa-thumbtack mr-1"></i>
                            Pinned
                        </span>
                    @endif
                </div>
                <span class="text-sm text-gray-500">
                    {{ $thread->created_at->format('M d, Y') }}
                </span>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $thread->title }}</h1>

            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-semibold text-lg">
                    {{ strtoupper(substr($thread->user->name ?? 'U', 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-900">{{ $thread->user->name ?? 'Anonymous' }}</div>
                    <div class="text-sm text-gray-500">{{ $thread->created_at->diffForHumans() }}</div>
                </div>
            </div>

            <div class="prose max-w-none text-gray-700">
                {{ $thread->content }}
            </div>

                        {{-- Like/Dislike Buttons --}}
            <div class="border-t border-gray-200 p-6 flex items-center space-x-6">
                {{-- Like Button --}}
                <form action="{{ route('discussion.react', ['post' => $thread->id, 'type' => 'like']) }}" method="POST" class="inline">
                    @csrf
                    <button 
                        type="submit" 
                        class="flex items-center space-x-2 hover:text-primary focus:outline-none {{ $thread->isLikedBy(auth()->user()) ? 'text-primary font-semibold' : 'text-gray-600' }}">
                        <i class="{{ $thread->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                        <span>{{ $thread->like_count }}</span>
                    </button>
                </form>

                {{-- Dislike Button --}}
                <form action="{{ route('discussion.react', ['post' => $thread->id, 'type' => 'dislike']) }}" method="POST" class="inline">
                    @csrf
                    <button 
                        type="submit" 
                        class="flex items-center space-x-2 hover:text-red-600 focus:outline-none {{ $thread->isDislikedBy(auth()->user()) ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                        <i class="{{ $thread->isDislikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-down"></i>
                        <span>{{ $thread->dislike_count }}</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Replies Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    {{ $thread->replies()->count() }} {{ Str::plural('Reply', $thread->replies()->count()) }}
                </h2>
            </div>

            {{-- Replies List --}}
            <div class="divide-y divide-gray-200">
                @forelse($thread->allReplies as $reply)
                    @include('discussion.partials.reply', ['reply' => $reply, 'thread' => $thread, 'depth' => 0])
                @empty
                    <div class="p-12 text-center text-gray-500">
                        <i class="far fa-comments text-4xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-900 mb-2">No replies yet</p>
                        <p class="text-sm">Be the first to respond!</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Main Reply Form --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Post a Reply</h3>
            <form action="{{ route('discussion.reply.store', $thread->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="reply_content" class="block text-sm font-medium text-gray-700 mb-2">
                        Your Reply
                    </label>
                    <textarea 
                        id="reply_content" 
                        name="content"
                        required
                        rows="4"
                        placeholder="Write your response..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary focus:border-transparent focus:outline-none resize-none"></textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Be respectful and constructive
                    </p>
                    <button 
                        type="submit" 
                        class="bg-primary hover:bg-opacity-90 text-white px-6 py-2 rounded-lg transition-colors">
                        Post Reply
                    </button>
                </div>
            </form>
        </div>


        </div>
    </div>

    <script>
        function toggleReplyForm(replyId) {
            const form = document.getElementById('reply-form-' + replyId);
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                form.querySelector('textarea').focus();
            }
        }
    </script>
</body>
</html>