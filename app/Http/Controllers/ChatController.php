<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // User side: Get chat history
    public function index()
    {
        $userId = Auth::id();
        $admin = User::where('is_site_owner', 1)->first();
        if (!$admin) return response()->json([]);
        
        $messages = ChatMessage::with('replyTo')->where(function($q) use ($userId, $admin) {
            $q->where('sender_id', $userId)->where('receiver_id', $admin->id);
        })->orWhere(function($q) use ($userId, $admin) {
            $q->where('sender_id', $admin->id)->where('receiver_id', $userId);
        })->oldest()->get();

        // Mark as read
        ChatMessage::where('sender_id', $admin->id)->where('receiver_id', $userId)->update(['is_read' => true]);

        return response()->json($messages);
    }

    // User side: Send message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|max:51200', // 50MB
            'reply_to_id' => 'nullable|exists:chat_messages,id'
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json(['error' => 'Message or attachment is required'], 422);
        }

        $admin = User::where('is_site_owner', 1)->first();
        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $admin->id,
            'message' => $request->message ?? '',
            'reply_to_id' => $request->reply_to_id,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $data['attachment'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $mime = $file->getMimeType();
            
            if (str_starts_with($mime, 'image/')) $data['file_type'] = 'image';
            elseif (str_starts_with($mime, 'video/')) $data['file_type'] = 'video';
            elseif (str_starts_with($mime, 'audio/')) $data['file_type'] = 'audio';
            else $data['file_type'] = 'file';
        }

        $chat = ChatMessage::create($data);
        return response()->json($chat->load('replyTo'));
    }

    // Admin side: List conversations
    public function adminIndex()
    {
        // Get unique users who have messaged admin or received messages
        $conversations = User::whereHas('sentMessages', function($q) {
            $q->where('receiver_id', Auth::id());
        })->orWhereHas('receivedMessages', function($q) {
            $q->where('sender_id', Auth::id());
        })->withCount(['sentMessages as unread_count' => function($q) {
            $q->where('receiver_id', Auth::id())->where('is_read', false);
        }])->get()->map(function($user) {
            $lastMsg = ChatMessage::where(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->latest()->first();
            $user->last_message = $lastMsg;
            return $user;
        })->sortByDesc(function($user) {
            return $user->last_message ? $user->last_message->created_at : $user->created_at;
        });

        return view('admin.pages.chats', compact('conversations'));
    }

    // Admin side: Get sidebar html specifically for polling
    public function getSidebar()
    {
        $conversations = User::whereHas('sentMessages', function($q) {
            $q->where('receiver_id', Auth::id());
        })->orWhereHas('receivedMessages', function($q) {
            $q->where('sender_id', Auth::id());
        })->withCount(['sentMessages as unread_count' => function($q) {
            $q->where('receiver_id', Auth::id())->where('is_read', false);
        }])->get()->map(function($user) {
            $lastMsg = ChatMessage::where(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->latest()->first();
            $user->last_message = $lastMsg;
            return $user;
        })->sortByDesc(function($user) {
            return $user->last_message ? $user->last_message->created_at : $user->created_at;
        });

        return view('admin.components.chat_sidebar_items', compact('conversations'));
    }

    // Admin side: Get conversations as JSON for public widget
    public function getConversationsJson()
    {
        $conversations = User::whereHas('sentMessages', function($q) {
            $q->where('receiver_id', Auth::id());
        })->orWhereHas('receivedMessages', function($q) {
            $q->where('sender_id', Auth::id());
        })->withCount(['sentMessages as unread_count' => function($q) {
            $q->where('receiver_id', Auth::id())->where('is_read', false);
        }])->get()->map(function($user) {
            $lastMsg = ChatMessage::where(function($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->orWhere(function($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->latest()->first();
            
            return [
                'id' => $user->id,
                'name' => $user->name,
                'profile_image' => $user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name),
                'unread_count' => $user->unread_count,
                'last_message' => $lastMsg ? [
                    'message' => $lastMsg->message,
                    'file_name' => $lastMsg->file_name,
                    'created_at' => $lastMsg->created_at,
                    'is_read' => $lastMsg->is_read,
                    'sender_id' => $lastMsg->sender_id
                ] : null
            ];
        })->sortByDesc(function($user) {
            return $user['last_message'] ? $user['last_message']['created_at'] : null;
        })->values();

        return response()->json($conversations);
    }

    // Admin side: Search all users to start new conversation
    public function searchUsers(Request $request)
    {
        $term = $request->query('term');
        if (!$term) {
            return response()->json([]);
        }
        
        $users = User::where('id', '!=', Auth::id())
                     ->where(function($q) use ($term) {
                         $q->where('name', 'like', "%{$term}%")
                           ->orWhere('email', 'like', "%{$term}%");
                     })
                     ->limit(10)
                     ->get(['id', 'name', 'email', 'profile_image']);
                     
        $users->transform(function($user) {
            $user->profile_image = $user->profile_image ? asset('storage/'.$user->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name);
            return $user;
        });

        return response()->json($users);
    }

    // Admin side: Get specific user conversation
    public function getConversation($userId)
    {
        $adminId = Auth::id();
        $messages = ChatMessage::with('replyTo')->where(function($q) use ($userId, $adminId) {
            $q->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function($q) use ($userId, $adminId) {
            $q->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->oldest()->get();

        ChatMessage::where('sender_id', $userId)->where('receiver_id', $adminId)->update(['is_read' => true]);

        return response()->json($messages);
    }

    // Admin side: Send reply
    public function adminReply(Request $request, $userId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|max:51200',
            'reply_to_id' => 'nullable|exists:chat_messages,id'
        ]);

        if (!$request->message && !$request->hasFile('attachment')) {
            return response()->json(['error' => 'Message or attachment is required'], 422);
        }

        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'message' => $request->message ?? '',
            'reply_to_id' => $request->reply_to_id,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $data['attachment'] = $path;
            $data['file_name'] = $file->getClientOriginalName();
            $mime = $file->getMimeType();
            
            if (str_starts_with($mime, 'image/')) $data['file_type'] = 'image';
            elseif (str_starts_with($mime, 'video/')) $data['file_type'] = 'video';
            elseif (str_starts_with($mime, 'audio/')) $data['file_type'] = 'audio';
            else $data['file_type'] = 'file';
        }

        $chat = ChatMessage::create($data);
        return response()->json($chat->load('replyTo'));
    }
}
