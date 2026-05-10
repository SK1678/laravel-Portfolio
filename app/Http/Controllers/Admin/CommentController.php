<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // Mark all as read when visiting the manager
        Comment::where('is_read', false)->update(['is_read' => true]);

        $comments = Comment::with(['user', 'post'])->latest()->paginate(15);
        return view('admin.pages.comments.index', compact('comments'));
    }

    public function toggleStatus($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->status = !$comment->status;
        $comment->save();

        return response()->json([
            'success' => true,
            'status' => $comment->status,
            'message' => 'Comment status updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    public function markAsRead($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_read = true;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    }
}
