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
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('inside.module', ['courseId' => $forum->course_id, 'moduleNumber' => $forum->module->moduleId]) }}" 
               class="inline-flex items-center text-gray-600 hover:text-primary transition-colors">
                <i class="fas fa-arrow-left mr-2 text-sm"></i>
                <span class="text-sm font-medium">Back to Course</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Combined Thread & Replies Card --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4">
            {{-- Thread Header --}}
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                            {{ $forum->title }}
                        </span>
                        @if($thread->is_pinned)
                            <span class="px-3 py-1 bg-yellow-50 text-yellow-700 text-xs font-medium rounded-full flex items-center">
                                <i class="fas fa-thumbtack mr-1 text-xs"></i>
                                Pinned
                            </span>
                        @endif
                    </div>
                    <span class="text-xs text-gray-500">{{ $thread->created_at->format('M d, Y') }}</span>
                </div>

                <h1 class="text-xl font-bold text-gray-900 mb-4">{{ $thread->title }}</h1>

                {{-- Author Info --}}
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($thread->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-900 text-sm">{{ $thread->user->name ?? 'Anonymous' }}</div>
                        <div class="text-xs text-gray-500">{{ $thread->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                {{-- Thread Content --}}
                <div class="text-gray-700 text-sm leading-relaxed mb-4">
                    {{ $thread->content }}
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center space-x-2 pt-2 border-t border-gray-100">
                    {{-- Like --}}
                    <form action="{{ route('discussion.react', ['post' => $thread->id, 'type' => 'like']) }}" method="POST" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="flex items-center space-x-1 px-3 py-1.5 rounded-md hover:bg-gray-100 transition-colors {{ $thread->isLikedBy(auth()->user()) ? 'text-primary bg-blue-50 font-medium' : 'text-gray-600' }}">
                            <i class="{{ $thread->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-up text-sm"></i>
                            <span class="text-sm">{{ $thread->like_count }}</span>
                        </button>
                    </form>

                    {{-- Dislike --}}
                    <form action="{{ route('discussion.react', ['post' => $thread->id, 'type' => 'dislike']) }}" method="POST" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="flex items-center space-x-1 px-3 py-1.5 rounded-md hover:bg-gray-100 transition-colors {{ $thread->isDislikedBy(auth()->user()) ? 'text-red-600 bg-red-50 font-medium' : 'text-gray-600' }}">
                            <i class="{{ $thread->isDislikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-down text-sm"></i>
                            <span class="text-sm">{{ $thread->dislike_count }}</span>
                        </button>
                    </form>

                    {{-- Respond Button --}}
                    <button 
                        onclick="toggleMainReplyForm()" 
                        class="flex items-center space-x-1 px-3 py-1.5 rounded-md hover:bg-gray-100 transition-colors text-gray-600 font-medium text-sm">
                        <i class="fas fa-comment text-sm"></i>
                        <span>Respond</span>
                    </button>
                </div>

                {{-- Inline Reply Form --}}
                <div id="main-reply-form" class="hidden mt-4">
                    <form action="{{ route('discussion.reply.store', $thread->id) }}" method="POST">
                        @csrf
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <textarea 
                                name="content"
                                required
                                rows="3"
                                placeholder="Write your response..."
                                class="w-full border-0 bg-transparent text-sm focus:ring-0 focus:outline-none resize-none placeholder-gray-500 mb-2"></textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <div class="flex items-center justify-end space-x-2">
                                <button 
                                    type="button" 
                                    onclick="toggleMainReplyForm()"
                                    class="text-gray-600 hover:text-gray-900 px-3 py-1.5 text-xs font-medium transition-colors">
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    class="bg-primary hover:bg-opacity-90 text-white px-4 py-1.5 rounded text-xs font-medium transition-colors">
                                    Post Response
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Responses Divider --}}
            <div class="px-6 py-3 bg-gray-50 border-y border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">
                    {{ $thread->replies()->count() }} {{ Str::plural('Response', $thread->replies()->count()) }}
                </h2>
            </div>

            {{-- Replies List --}}
            <div class="divide-y divide-gray-100">
                @forelse($thread->allReplies as $reply)
                    @include('discussion.partials.reply', ['reply' => $reply, 'thread' => $thread, 'depth' => 0])
                @empty
                    <div class="p-12 text-center">
                        <i class="far fa-comments text-5xl text-gray-300 mb-3"></i>
                        <p class="text-base font-medium text-gray-900 mb-1">No responses yet</p>
                        <p class="text-sm text-gray-500">Be the first to respond!</p>
                    </div>
                @endforelse
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

        function toggleMainReplyForm() {
            const form = document.getElementById('main-reply-form');
            form.classList.toggle('hidden');
            if (!form.classList.contains('hidden')) {
                form.querySelector('textarea').focus();
            }
        }

        function toggleNestedReplies(replyId) {
            const repliesDiv = document.getElementById('nested-replies-' + replyId);
            const toggleBtn = document.getElementById('toggle-btn-' + replyId);
            
            repliesDiv.classList.toggle('hidden');
            
            // Change button text
            if (repliesDiv.classList.contains('hidden')) {
                const count = repliesDiv.querySelectorAll(':scope > div').length;
                toggleBtn.innerHTML = `<span>${count} ${count === 1 ? 'reply' : 'replies'}</span>`;
            } else {
                toggleBtn.innerHTML = `<i class="fas fa-chevron-up text-xs"></i><span>Hide replies</span>`;
            }
        }
    </script>
</body>
</html>