<?php

namespace App\Http\Controllers;

use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Models\SupportChat;
use App\Models\SupportMessage;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use App\Notifications\SupportMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function confirmOrder(Order $order)
    {
        $order->update([
            'status' => 'confirmed',
        ]);
        $order->user->notify(
            new OrderStatusNotification(
                $order,
                'Заказ подтверждён',
                'Ваш заказ №' . $order->id . ' подтверждён поддержкой'
            )
        );

        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->queue(
                new OrderStatusMail(
                    $order,
                    'Заказ подтверждён',
                    'Ваш заказ №' . $order->id . ' подтверждён поддержкой.'
                )
            );
        }

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

        $message = $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        User::where('role', 'admin')->get()->each(function ($admin) use ($chat, $message) {
            $admin->notify(
                new SupportMessageNotification($chat, $message, 'admin')
            );
        });

        return redirect()->route('support.chat', $chat->id);
    }

    public function send(Request $request, SupportChat $chat)
    {
        abort_if($chat->user_id !== auth()->id(), 403);

        $request->validate([
            'message' => 'required',
        ]);

        $message = $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        $chat->update([
            'status' => 'waiting',
        ]);

        User::where('role', 'admin')->get()->each(function ($admin) use ($chat, $message) {
            $admin->notify(
                new SupportMessageNotification($chat, $message, 'admin')
            );
        });

        return back();
    }
    public function messages(SupportChat $chat)
    {
        abort_if($chat->user_id !== auth()->id(), 403);

        $chat->load('message.user');

        return response()->json([
            'html' => view('profile.support.partials.messages', [
                'messages' => $chat->message,
            ])->render(),
            'status' => $chat->status,
            'status_label' => $chat->status_label,
            'count' => $chat->message->count(),
        ]);
    }

    public function sendAjax(Request $request, SupportChat $chat)
    {
        abort_if($chat->user_id !== auth()->id(), 403);

        $request->validate([
            'message' => 'required',
        ]);

        $message = $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'user',
        ]);

        $chat->update([
            'status' => 'waiting',
        ]);

        User::where('role', 'admin')->get()->each(function ($admin) use ($chat, $message) {
            $admin->notify(
                new SupportMessageNotification($chat, $message, 'admin')
            );
        });

        return response()->json([
            'success' => true,
        ]);
    }
}