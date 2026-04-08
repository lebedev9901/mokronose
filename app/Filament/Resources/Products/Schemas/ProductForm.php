<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                    TextInput::make('title')->required(),

        Textarea::make('description'),

        TextInput::make('price')->numeric()->required(),

        TextInput::make('weight'),

        Select::make('categories')
        ->multiple()
            ->relationship('categories', 'title')
            ->required(),

        Repeater::make('images')
            ->relationship()
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('products'),

                Toggle::make('is_preview'),
            ]),
    ])->columns(2);
    }
}
