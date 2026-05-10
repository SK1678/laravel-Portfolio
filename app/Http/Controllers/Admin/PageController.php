<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index');
    }

    public function portfolio()
    {
        return view('admin.pages.portfolio');
    }

    public function skills()
    {
        return view('admin.pages.skills');
    }

    public function messages(Request $request)
    {
        // Mark all messages as read
        \App\Models\Message::where('is_read', false)->update(['is_read' => true]);
        \App\Models\ChatMessage::where('receiver_id', \Illuminate\Support\Facades\Auth::id())->where('is_read', false)->update(['is_read' => true]);

        // 1. Fetch Guest Messages
        $guestMessages = \App\Models\Message::latest()->get()->map(function($msg) {
            return (object) [
                'id' => $msg->id,
                'name' => $msg->name,
                'email' => $msg->email,
                'subject' => $msg->subject,
                'message' => $msg->message,
                'is_read' => $msg->is_read,
                'created_at' => $msg->created_at,
                'type' => 'guest',
                'user_id' => null
            ];
        });

        // 2. Fetch Chat Conversations
        $adminId = \Illuminate\Support\Facades\Auth::id();
        $userConversations = \App\Models\User::whereHas('sentMessages', fn($q) => $q->where('receiver_id', $adminId))
            ->orWhereHas('receivedMessages', fn($q) => $q->where('sender_id', $adminId))
            ->get()->map(function($user) use ($adminId) {
                $lastMsg = \App\Models\ChatMessage::where(function($q) use ($user, $adminId) {
                        $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
                    })->orWhere(function($q) use ($user, $adminId) {
                        $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
                    })->latest()->first();

                return (object) [
                    'id' => $lastMsg ? $lastMsg->id : $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'subject' => 'Chat Conversation',
                    'message' => $lastMsg ? $lastMsg->message : '...',
                    'is_read' => true, // We already marked all as read above
                    'created_at' => $lastMsg ? $lastMsg->created_at : $user->created_at,
                    'type' => 'user',
                    'user_id' => $user->id
                ];
            });

        // 3. Unify and Paginate
        $merged = $guestMessages->concat($userConversations)->sortByDesc('created_at');
        
        $page = $request->input('page', 1);
        $perPage = 10;
        $messages = new \Illuminate\Pagination\LengthAwarePaginator(
            $merged->forPage($page, $perPage),
            $merged->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        if ($request->ajax()) {
            return view('admin.pages.messages_list', compact('messages'))->render();
        }

        return view('admin.pages.messages', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = \App\Models\Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function destroyMessage($id)
    {
        $message = \App\Models\Message::findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }
}
