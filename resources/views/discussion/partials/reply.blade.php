<div class="p-4 {{ $depth > 0 ? 'ml-8 border-l-2 border-gray-200' : '' }}">
    <div class="flex items-start space-x-3">
        {{-- Avatar --}}
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
            </div>
        </div>

        {{-- Reply Content --}}
        <div class="flex-1 min-w-0">
            {{-- User Info --}}
            <div class="flex items-baseline space-x-2 mb-1">
                <span class="font-medium text-gray-900 text-sm">{{ $reply->user->name ?? 'Anonymous' }}</span>
                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
            </div>

            {{-- Reply Text --}}
            <p class="text-gray-700 text-sm leading-relaxed mb-2">{{ $reply->content }}</p>

            {{-- Action Buttons --}}
            <div class="flex items-center space-x-1">
                {{-- Like --}}
                <form action="{{ route('discussion.react', ['post' => $reply->id, 'type' => 'like']) }}" method="POST" class="inline">
                    @csrf
                    <button 
                        type="submit" 
                        class="flex items-center space-x-1 px-2 py-1 rounded hover:bg-gray-100 transition-colors text-xs {{ $reply->isLikedBy(auth()->user()) ? 'text-primary font-medium' : 'text-gray-600' }}">
                        <i class="{{ $reply->isLikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-up"></i>
                        <span>{{ $reply->like_count }}</span>
                    </button>
                </form>

                {{-- Dislike --}}
                <form action="{{ route('discussion.react', ['post' => $reply->id, 'type' => 'dislike']) }}" method="POST" class="inline">
                    @csrf
                    <button 
                        type="submit" 
                        class="flex items-center space-x-1 px-2 py-1 rounded hover:bg-gray-100 transition-colors text-xs {{ $reply->isDislikedBy(auth()->user()) ? 'text-red-600 font-medium' : 'text-gray-600' }}">
                        <i class="{{ $reply->isDislikedBy(auth()->user()) ? 'fas' : 'far' }} fa-thumbs-down"></i>
                        <span>{{ $reply->dislike_count }}</span>
                    </button>
                </form>

                {{-- Reply Button --}}
                <button 
                    onclick="toggleReplyForm({{ $reply->id }})" 
                    class="text-gray-600 hover:bg-gray-100 px-2 py-1 rounded font-medium transition-colors text-xs">
                    <i class="fas fa-reply mr-1"></i>
                    Reply
                </button>
            </div>

            {{-- Show Nested Replies Toggle --}}
            @if($reply->allReplies->count() > 0)
                <button 
                    onclick="toggleNestedReplies({{ $reply->id }})"
                    id="toggle-btn-{{ $reply->id }}"
                    class="mt-2 text-primary underline hover:underline text-xs font-medium hover:font-bold flex items-center space-x-1">
                    <span>{{ $reply->allReplies->count() }} {{ Str::plural('reply', $reply->allReplies->count()) }}</span>
                </button>
            @endif

            {{-- Nested Reply Form --}}
            <div id="reply-form-{{ $reply->id }}" class="hidden mt-3">
                <form action="{{ route('discussion.reply.store', $thread->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                        <textarea 
                            name="content"
                            required
                            rows="2"
                            placeholder="Write a reply..."
                            class="w-full border-0 bg-transparent text-sm focus:ring-0 focus:outline-none resize-none placeholder-gray-500 mb-2"></textarea>
                        <div class="flex items-center justify-end space-x-2">
                            <button 
                                type="button" 
                                onclick="toggleReplyForm({{ $reply->id }})"
                                class="text-gray-600 hover:text-gray-900 px-3 py-1.5 text-xs font-medium transition-colors">
                                Cancel
                            </button>
                            <button 
                                type="submit" 
                                class="bg-primary hover:bg-opacity-90 text-white px-3 py-1.5 rounded text-xs font-medium transition-colors">
                                Reply
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Nested Replies (Hidden by default) --}}
            @if($reply->allReplies->count() > 0)
                <div id="nested-replies-{{ $reply->id }}" class="hidden mt-3">
                    @foreach($reply->allReplies as $nestedReply)
                        @include('discussion.partials.reply', ['reply' => $nestedReply, 'thread' => $thread, 'depth' => $depth + 1])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>