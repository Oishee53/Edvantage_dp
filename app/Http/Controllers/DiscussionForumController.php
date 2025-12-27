<?php

namespace App\Http\Controllers;

use App\Models\DiscussionForum;
use App\Models\DiscussionPost;
use Illuminate\Http\Request;

class DiscussionForumController extends Controller
{
    // Store new thread
    public function storeThread(Request $request)
    {
        $validated = $request->validate([
            'forum_id' => 'required|exists:discussion_forums,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        DiscussionPost::create([
            'forum_id' => $validated['forum_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Thread created successfully!');
    }

    // Show single thread with all replies
    public function showThread(DiscussionForum $forum, DiscussionPost $thread)
    {
        $thread->load(['user', 'allReplies.user', 'forum.course']);
        
        return view('discussion.thread', compact('forum', 'thread'));
    }

    // Show all threads in forum
    public function showForum(DiscussionForum $forum)
    {
        $forum->load(['course', 'module']);
        
        $threads = $forum->threads()
            ->whereNull('parent_id')
            ->with(['user', 'replies'])
            ->withCount('replies')
            ->latest()
            ->paginate(20);
        
        return view('discussion.forum', compact('forum', 'threads'));
    }

    // Store reply to thread
    public function storeReply(Request $request, DiscussionPost $thread)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        DiscussionPost::create([
            'forum_id' => $thread->forum_id,
            'user_id' => auth()->id(),
            'parent_id' => $thread->id,
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Reply posted successfully!');
    }
}