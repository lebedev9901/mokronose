<?php

namespace App\Filament\Resources\SupportChats\Pages;

use App\Filament\Resources\SupportChats\SupportChatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSupportChats extends ListRecords
{
    protected static string $resource = SupportChatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
