<?php

namespace App\Filament\Resources\ClassRooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClassRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('school_id')
                    ->relationship('school', 'name')
                    ->required()
                    ->searchable()
                    ->label('School'),
                Select::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->required()
                    ->searchable()
                    ->label('Academic Year'),
                Textarea::make('name')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('code')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('capacity')
                    ->numeric()
                    ->default(30),
                Textarea::make('section')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active Status'),
            ]);
    }
}
