<?php

namespace App\Filament\Resources\SupportChats\Pages;

use App\Filament\Resources\SupportChats\SupportChatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSupportChat extends EditRecord
{
    protected static string $resource = SupportChatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
