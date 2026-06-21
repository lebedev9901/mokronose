<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SupportMessageMail;
use App\Models\SupportChat;
use App\Notifications\SupportMessageNotification;
use App\Services\VkMessageService;
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

    public function send(Request $request, SupportChat $chat, VkMessageService $vk)
    {
     
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat->load('user');

        $message = $chat->message()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'sender_type' => 'support',
        ]);

        $chat->update([
            'status' => 'answered',
        ]);

        if ($chat->user) {
            $chat->user->notify(
                new SupportMessageNotification($chat, $message, 'user')
            );
        }

        try {
            if ($chat->user?->vk_id) {
                $vk->sendToUser(
                    $chat->user->vk_id,
                    "💬 МокроНос\n\n" .
                    "В чате поддержки появилось новое сообщение:\n\n" .
                    $message->message
                );
            }
        } catch (\Throwable $e) {
            Log::error('Ошибка отправки VK уведомления поддержки', [
                'chat_id' => $chat->id,
                'user_id' => $chat->user_id,
                'error' => $e->getMessage(),
            ]);
        }

   

        return back();
    }
}