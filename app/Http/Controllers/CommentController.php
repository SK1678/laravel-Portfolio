<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment posted successfully.');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->update([
            'body' => $request->body,
        ]);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
