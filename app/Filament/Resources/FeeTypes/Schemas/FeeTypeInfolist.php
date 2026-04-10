<?php

namespace App\Filament\Resources\FeeTypes\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FeeTypeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Fee Name')
                    ->weight('bold'),
                
                TextEntry::make('code')
                    ->label('Fee Code')
                    ->badge()
                    ->color('info'),
                
                TextEntry::make('description')
                    ->label('Description')
                    ->placeholder('-'),
                
                IconEntry::make('is_optional')
                    ->label('Optional')
                    ->boolean(),
                
                IconEntry::make('is_active')
                    ->label('Active')
                    ->boolean(),
                
                TextEntry::make('sort_order')
                    ->label('Sort Order'),
                
                TextEntry::make('created_at')
                    ->label('Created')
                    ->dateTime(),
                
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(),
            ]);
    }
}