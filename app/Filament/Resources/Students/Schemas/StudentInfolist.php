<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('admission_number')
                    ->label('Admission Number'),
                
                TextEntry::make('first_name')
                    ->label('First Name'),
                
                TextEntry::make('last_name')
                    ->label('Last Name'),
                
                TextEntry::make('full_name')
                    ->label('Full Name')
                    ->getStateUsing(function ($record) {
                        return $record->first_name . ' ' . $record->last_name;
                    }),
                
                TextEntry::make('school.name')
                    ->label('School'),
                
                TextEntry::make('email')
                    ->label('Email Address')
                    ->copyable(),
                
                TextEntry::make('phone')
                    ->label('Phone Number')
                    ->placeholder('-'),
                
                TextEntry::make('date_of_birth')
                    ->label('Date of Birth')
                    ->date(),
                
                TextEntry::make('gender')
                    ->label('Gender'),
                
                TextEntry::make('enrollment_date')
                    ->label('Enrollment Date')
                    ->date(),
                
                TextEntry::make('address')
                    ->label('Address')
                    ->placeholder('-'),
                
                TextEntry::make('city')
                    ->label('City')
                    ->placeholder('-'),
                
                TextEntry::make('parent_name')
                    ->label('Parent/Guardian Name')
                    ->placeholder('-'),
                
                TextEntry::make('parent_phone')
                    ->label('Parent/Guardian Phone')
                    ->placeholder('-'),
                
                TextEntry::make('parent_email')
                    ->label('Parent/Guardian Email')
                    ->placeholder('-'),
                
                TextEntry::make('medical_notes')
                    ->label('Medical Notes / Allergies')
                    ->placeholder('-'),
                
                IconEntry::make('is_active')
                    ->label('Active Status')
                    ->boolean(),
                
                TextEntry::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->placeholder('-'),
                
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}