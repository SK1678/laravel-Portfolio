<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        if (Auth::check()) {
            $admin = User::where('is_site_owner', 1)->first();
            if ($admin) {
                ChatMessage::create([
                    'sender_id' => Auth::id(),
                    'receiver_id' => $admin->id,
                    'message' => "Subject: " . $request->subject . "\n" . $request->message,
                ]);
            }
        }

        return "OK";
    }
}
