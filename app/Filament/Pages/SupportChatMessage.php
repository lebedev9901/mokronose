<?php

namespace App\Filament\Pages;

use App\Models\SupportChat;
use Filament\Pages\Page;

class SupportChatMessage extends Page
{
    protected string $view = 'filament.pages.support-chat-message';

    public SupportChat $chat;
    public string $newMessage = '';

    public function mount($chatId)
    {
        $this->chat = SupportChat::with('message')->findOrFail($chatId);
    }

    public function sendMessage()
    {
        $this->chat->message()->create([
            'message' => $this->newMessage,
            'chat_id' => $this->chatId,
            'sender_type' => 'support',
            'user_id' => auth()->id(),
        ]);

        $this->newMessage = '';
        $this->chat->load('message');
    }
}
