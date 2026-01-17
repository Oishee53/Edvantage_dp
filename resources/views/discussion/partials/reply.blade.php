<div class="p-6 {{ $depth > 0 ? 'ml-12 border-l-2 border-gray-200' : '' }}">
    <div class="flex items-start space-x-4">
        <div class="flex-shrink-0">
            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
            </div>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <span class="font-semibold text-gray-900">{{ $reply->user->name ?? 'Anonymous' }}</span>
                    <span class="text-gray-500 text-sm ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <p class="text-gray-700 mb-3">{{ $reply->content }}</p>

            {{-- Reply Button --}}
            <button 
                onclick="toggleReplyForm({{ $reply->id }})" 
                class="text-sm text-primary hover:text-opacity-80 font-medium">
                <i class="fas fa-reply mr-1"></i>
                Reply
            </button>

            {{-- Nested Reply Form --}}
            <div id="reply-form-{{ $reply->id }}" class="hidden mt-4 bg-gray-50 p-4 rounded-lg">
                <form action="{{ route('discussion.reply.store', $thread->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                    <div class="mb-3">
                        <textarea 
                            name="content"
                            required
                            rows="3"
                            placeholder="Write your reply..."
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent focus:outline-none resize-none"></textarea>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button 
                            type="submit" 
                            class="bg-primary hover:bg-opacity-90 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                            Post Reply
                        </button>
                        <button 
                            type="button" 
                            onclick="toggleReplyForm({{ $reply->id }})"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            {{-- Nested Replies --}}
            @if($reply->allReplies->count() > 0)
                <div class="mt-4 space-y-4">
                    @foreach($reply->allReplies as $nestedReply)
                        @include('discussion.partials.reply', ['reply' => $nestedReply, 'thread' => $thread, 'depth' => $depth + 1])
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>