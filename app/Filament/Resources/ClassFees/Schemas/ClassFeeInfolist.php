<?php

namespace App\Filament\Resources\ClassFees\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClassFeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('classRoom.name')
                    ->label('Class'),
                
                TextEntry::make('feeType.name')
                    ->label('Fee Type'),
                
                TextEntry::make('academicYear.name')
                    ->label('Academic Year'),
                
                TextEntry::make('amount')
                    ->label('Amount')
                    ->money('KES'),
                
                TextEntry::make('frequency')
                    ->label('Frequency')
                    ->badge()
                    ->color('info'),
                
                IconEntry::make('is_mandatory')
                    ->label('Mandatory')
                    ->boolean(),
                
                TextEntry::make('notes')
                    ->label('Notes')
                    ->placeholder('-'),
                
                IconEntry::make('is_active')
                    ->label('Active')
                    ->boolean(),
                
                TextEntry::make('created_at')
                    ->label('Created')
                    ->dateTime(),
                
                TextEntry::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime(),
            ]);
    }
}