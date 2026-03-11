<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\SupportChat as ModelsSupportChat;

class SupportChat extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Чаты под2342держки';

    protected static ?string $title = 'Чаты под11держки';

    protected string $view = 'filament.pages.support-chat';

    public $selectedChat = null;
    public $newMessage = '';

    public function selectChat($chatId)
    {
        $this->selectedChat = ModelsSupportChat::find($chatId);
    }

    public function sendMessage()
    {
        if(!$this->selectedChat) return;

        if(trim($this->newMessage) === '') return;

        $this->selectedChat->message()->create([
            'message' => $this->newMessage,
            'user_id' => auth()->id(),
            'sender_type' => 'support'
        ]);

        $this->newMessage = '';
    }
}
