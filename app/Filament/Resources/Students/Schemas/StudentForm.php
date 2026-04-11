<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Schema as SchemaFacade;

class StudentForm
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
                    ->live() // Makes the field reactive
                    ->afterStateUpdated(fn ($set) => $set('class_room_id', null)) // Reset class when school changes
                    ->label('School'),
                
                Select::make('class_room_id')
                    ->label('Class')
                    ->options(function ($get) {
                        $schoolId = $get('school_id');
                        if (!$schoolId) {
                            return [];
                        }
                        
                        // Get all active classes for the selected school
                        return \App\Models\ClassRoom::where('school_id', $schoolId)
                            ->where('is_active', true)
                            ->with('academicYear')
                            ->get()
                            ->mapWithKeys(function ($class) {
                                $label = $class->name . ' (' . $class->code . ')';
                                if ($class->academicYear) {
                                    $label .= ' - ' . $class->academicYear->name;
                                }
                                // Show current enrollment count
                                $enrolledCount = $class->students()->count();
                                $label .= " [{$enrolledCount}/{$class->capacity}]";
                                return [$class->id => $label];
                            });
                    })
                    ->searchable()
                    ->preload()
                    ->placeholder('First select a school')
                    ->helperText('Only active classes from the selected school are shown. Shows current enrollment vs capacity.')
                    ->live(),
                
                TextInput::make('admission_number')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Admission Number'),
                
                TextInput::make('first_name')
                    ->required()
                    ->label('First Name'),
                
                TextInput::make('last_name')
                    ->required()
                    ->label('Last Name'),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('Email Address'),
                
                TextInput::make('phone')
                    ->tel()
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
                
                DatePicker::make('enrollment_date')
                    ->required()
                    ->default(now())
                    ->label('Enrollment Date'),
                
                Textarea::make('address')
                    ->label('Street Address'),
                
                TextInput::make('city')
                    ->label('City/Town'),
                
                TextInput::make('parent_name')
                    ->required()
                    ->label('Parent/Guardian Name'),
                
                TextInput::make('parent_phone')
                    ->required()
                    ->tel()
                    ->label('Parent/Guardian Phone'),
                
                TextInput::make('parent_email')
                    ->email()
                    ->label('Parent/Guardian Email'),
                
                Textarea::make('medical_notes')
                    ->label('Medical Notes / Allergies'),
                
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Active Status'),
            ]);
    }
}