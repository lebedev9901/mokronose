<?php

namespace App\Http\Controllers;

use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportChatController extends Controller
{
    public function show($id)
    {
        $chat = SupportChat::with('message')->findOrFail($id);
        return view('chat.show', compact('chat'));
    }

    public function send(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        SupportMessage::create([
            'chat_id' => $id,
            'user_id' => auth()->id(),
            'sender_type' => 'user',
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $id)->with('success', 'Заказ оформлен');
    }
}
