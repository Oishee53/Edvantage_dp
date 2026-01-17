@props(['forum', 'course'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    {{-- Header --}}
    <div class="border-b border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-comments text-gray-600"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Discussion Forum</h2>
                    <p class="text-sm text-gray-500">
                        {{ $forum->threads()->whereNull('parent_id')->count() }} threads
                    </p>
                </div>
            </div>
            <button 
                onclick="toggleNewThread()" 
                class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                <i class="fas fa-plus"></i>
                <span>New Thread</span>
            </button>
        </div>
    </div>

    {{-- New Thread Form (Hidden by default) --}}
    <div id="newThreadForm" class="hidden border-b border-gray-200 p-6 bg-gray-50">
        <form action="{{ route('discussion.thread.store') }}" method="POST">
            @csrf
            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="mb-4">
                <label for="thread_title" class="block text-sm font-medium text-gray-700 mb-2">
                    Thread Title
                </label>
                <input 
                    type="text" 
                    id="thread_title" 
                    name="title"
                    required
                    placeholder="What's your question or topic?"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:border-transparent focus:outline-none">
            </div>
            
            <div class="mb-4">
                <label for="thread_content" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="thread_content" 
                    name="content"
                    required
                    rows="4"
                    placeholder="Provide more details about your question..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-gray-900 focus:border-transparent focus:outline-none resize-none"></textarea>
            </div>
            
            <div class="flex items-center space-x-3">
                <button 
                    type="submit" 
                    class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition-colors">
                    Post Thread
                </button>
                <button 
                    type="button" 
                    onclick="toggleNewThread()"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    {{-- Threads List --}}
    <div class="divide-y divide-gray-200">
        @forelse($forum->threads()->whereNull('parent_id')->with(['user', 'replies'])->latest()->get() as $thread)
            <div class="p-6 hover:bg-gray-50 transition-colors">
                <div class="flex items-start space-x-4">
                    {{-- User Avatar --}}
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-900 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($thread->user->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>

                    {{-- Thread Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="text-base font-semibold text-gray-900">
                                {{ $thread->title }}
                            </h3>
                            @if($thread->is_pinned)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-thumbtack mr-1"></i>
                                    Pinned
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                            {{ $thread->content }}
                        </p>

                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <i class="far fa-user mr-1"></i>
                                {{ $thread->user->name ?? 'Anonymous' }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-clock mr-1"></i>
                                {{ $thread->created_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-comments mr-1"></i>
                                {{ $thread->replies()->count() }} 
                                {{ Str::plural('reply', $thread->replies()->count()) }}
                            </span>
                        </div>

                        {{-- View Thread Button --}}
                        <div class="mt-3">
                            {{-- In discussion-forum component --}}
                            {{-- Change this line --}}
                            <a href="{{ route('discussion.thread.show', [
                                'forum' => $forum->id, 
                                'thread' => $thread->id
                            ]) }}?return={{ urlencode(url()->current()) }}" 
                            class="inline-flex items-center text-sm font-medium text-gray-900 hover:text-gray-700">
                                View Thread
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-gray-500">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <p class="text-lg font-medium text-gray-900 mb-2">No discussions yet</p>
                <p class="text-sm">Be the first to start a conversation!</p>
            </div>
        @endforelse
    </div>

    {{-- View All Link (if more than 5 threads) --}}
    @if($forum->threads()->whereNull('parent_id')->count() > 5)
        <div class="border-t border-gray-200 p-4 bg-gray-50 text-center">
            <a href="{{ route('discussion.forum.show', $forum->id) }}" 
               class="text-sm font-medium text-gray-900 hover:text-gray-700">
                View All Discussions
                <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    @endif
</div>

<script>
    function toggleNewThread() {
        const form = document.getElementById('newThreadForm');
        form.classList.toggle('hidden');
        
        if (!form.classList.contains('hidden')) {
            document.getElementById('thread_title').focus();
        }
    }
</script>