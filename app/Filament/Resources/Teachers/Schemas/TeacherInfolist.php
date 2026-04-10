<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('teacher_code')
                    ->label('Teacher Code')
                    ->badge()
                    ->color('info'),
                
                TextEntry::make('full_name')
                    ->label('Full Name')
                    ->weight('bold')
                    ->size('lg'),
                
                TextEntry::make('school.name')
                    ->label('School'),
                
                TextEntry::make('email')
                    ->label('Email')
                    ->copyable(),
                
                TextEntry::make('phone')
                    ->label('Phone'),
                
                TextEntry::make('date_of_birth')
                    ->label('Date of Birth')
                    ->date(),
                
                TextEntry::make('gender')
                    ->label('Gender'),
                
                TextEntry::make('qualification')
                    ->label('Qualification')
                    ->placeholder('-'),
                
                TextEntry::make('specialization')
                    ->label('Specialization')
                    ->placeholder('-'),
                
                TextEntry::make('hire_date')
                    ->label('Hire Date')
                    ->date(),
                
                TextEntry::make('salary')
                    ->label('Salary')
                    ->money('KES'),
                
                TextEntry::make('address')
                    ->label('Address')
                    ->placeholder('-'),
                
                TextEntry::make('city')
                    ->label('City')
                    ->placeholder('-'),
                
                IconEntry::make('is_active')
                    ->label('Status')
                    ->boolean(),
                
                TextEntry::make('notes')
                    ->label('Additional Notes')
                    ->placeholder('-'),
                
                TextEntry::make('created_at')
                    ->label('Created')
                    ->dateTime(),
                
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(),
            ]);
    }
}