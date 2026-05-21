<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function confirmOrder(Order $order)
    {
        $order->update([
            'status' => 'confirmed',
        ]);

        if ($order->chat) {
            SupportMessage::create([
                'chat_id' => $order->chat->id,
                'sender_type' => 'support',
                'message' => 'Заказ подтверждён поддержкой',
            ]);
        }

        return back()->with('success', 'Заказ подтверждён');
    }

    public function index()
    {
        $chats = SupportChat::with('message')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('profile.sections.support', compact('chats'));
    }

    public function chat(SupportChat $chat)
    {
        abort_if($chat->user_id !== auth()->id(), 403);

        $chat->load('message.user');

        $allChats = SupportChat::with('message')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('profile.support.chat', compact('chat', 'allChats'));
    }

    public function create()
    {
        return view('profile.support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
        ]);

        $chat = SupportChat::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'status' => 'open',
        ]);

        $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        return redirect()->route('support.chat', $chat->id);
    }

    public function send(Request $request, SupportChat $chat)
    {
        abort_if($chat->user_id !== auth()->id(), 403);

        $request->validate([
            'message' => 'required',
        ]);

        $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        $chat->update([
            'status' => 'waiting',
        ]);

        return back();
    }
}