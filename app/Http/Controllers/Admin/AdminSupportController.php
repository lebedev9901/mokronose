<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SupportMessageMail;
use App\Models\SupportChat;
use App\Notifications\SupportMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminSupportController extends Controller
{
    public function index()
    {
        $chats = SupportChat::with([
                'user',
                'message'
            ])
            ->latest()
            ->get();

        return view(
            'admin.support.index',
            compact('chats')
        );
    }

    public function chat(SupportChat $chat)
    {
        $chat->load([
            'user',
            'message.user'
        ]);

        $allChats = SupportChat::with([
                'user',
                'message'
            ])
            ->latest()
            ->get();

        return view(
            'admin.support.chat',
            compact(
                'chat',
                'allChats'
            )
        );
    }

    public function send(Request $request, SupportChat $chat)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $message = $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'support'
        ]);

        $chat->update([
            'status' => 'answered'
        ]);

        $chat->user->notify(
            new SupportMessageNotification($chat, $message, 'user')
        );

       

        return back();
    }
}