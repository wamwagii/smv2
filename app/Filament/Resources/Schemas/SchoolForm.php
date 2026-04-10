<?php

namespace App\Filament\Resources\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

class SchoolForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('School Name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        
                        TextInput::make('code')
                            ->label('School Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->helperText('Unique identifier for the school'),
                        
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20),
                        
                        FileUpload::make('logo')
                            ->label('School Logo')
                            ->image()
                            ->directory('schools/logos')
                            ->maxSize(1024)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->helperText('Upload a square logo (max 1MB)'),
                        
                        TextInput::make('city')
                            ->label('City/Town')
                            ->maxLength(100),
                        
                        TextInput::make('country')
                            ->label('Country')
                            ->default('Kenya')
                            ->maxLength(100),
                        
                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Inactive schools will be hidden from the system'),
                    ])->columns(2),
            ]);
    }
}