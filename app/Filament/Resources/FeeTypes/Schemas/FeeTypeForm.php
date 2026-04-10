<?php

namespace App\Filament\Resources\FeeTypes\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FeeTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Fee Name'),
                
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50)
                    ->label('Fee Code')
                    ->helperText('Unique identifier (e.g., TUITION, TRANSPORT)'),
                
                Textarea::make('description')
                    ->maxLength(65535)
                    ->label('Description'),
                
                Toggle::make('is_optional')
                    ->label('Optional Fee')
                    ->helperText('Optional fees can be waived for individual students'),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),
                
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->label('Sort Order')
                    ->helperText('Determines display order in lists'),
            ]);
    }
}