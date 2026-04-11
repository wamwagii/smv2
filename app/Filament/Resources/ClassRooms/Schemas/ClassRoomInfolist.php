<?php

namespace App\Filament\Resources\ClassRooms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClassRoomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('school_id')
                    ->numeric(),
                TextEntry::make('academic_year_id')
                    ->numeric(),
                TextEntry::make('name')
                    ->columnSpanFull(),
                TextEntry::make('code')
                    ->columnSpanFull(),
                TextEntry::make('capacity')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('section')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('is_active')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('updated_at')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
