<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('school_id')
                    ->relationship('school', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('School'),
                
                TextInput::make('teacher_code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50)
                    ->label('Teacher Code'),
                
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255)
                    ->label('First Name'),
                
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255)
                    ->label('Last Name'),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Email Address'),
                
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->label('Phone Number'),
                
                DatePicker::make('date_of_birth')
                    ->required()
                    ->label('Date of Birth'),
                
                Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->required()
                    ->label('Gender'),
                
                TextInput::make('qualification')
                    ->maxLength(255)
                    ->label('Qualification'),
                
                TextInput::make('specialization')
                    ->maxLength(255)
                    ->label('Specialization'),
                
                DatePicker::make('hire_date')
                    ->required()
                    ->label('Hire Date'),
                
                TextInput::make('salary')
                    ->numeric()
                    ->prefix('KES')
                    ->maxValue(9999999)
                    ->label('Salary'),
                
                Textarea::make('address')
                    ->maxLength(65535)
                    ->label('Address'),
                
                TextInput::make('city')
                    ->maxLength(100)
                    ->label('City'),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active Status'),
                
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->label('Additional Notes'),
            ]);
    }
}