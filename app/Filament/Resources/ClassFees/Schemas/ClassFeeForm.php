<?php

namespace App\Filament\Resources\ClassFees\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClassFeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('class_room_id')
                    ->relationship('classRoom', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Class'),
                
                Select::make('fee_type_id')
                    ->relationship('feeType', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Fee Type'),
                
                Select::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Academic Year'),
                
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('KES')
                    ->minValue(0)
                    ->label('Amount'),
                
                Select::make('frequency')
                    ->options([
                        'term' => 'Per Term',
                        'monthly' => 'Monthly',
                        'annual' => 'Annual',
                        'one_time' => 'One Time',
                    ])
                    ->required()
                    ->default('term')
                    ->label('Payment Frequency'),
                
                Toggle::make('is_mandatory')
                    ->default(true)
                    ->label('Mandatory Fee')
                    ->helperText('If mandatory, all students in this class must pay'),
                
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->label('Notes'),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),
            ]);
    }
}