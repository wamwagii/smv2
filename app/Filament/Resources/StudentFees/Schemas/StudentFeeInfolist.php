<?php

namespace App\Filament\Resources\StudentFees\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudentFeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('student.full_name')
                    ->label('Student')
                    ->weight('bold'),
                
                TextEntry::make('classFee.classRoom.name')
                    ->label('Class'),
                
                TextEntry::make('classFee.feeType.name')
                    ->label('Fee Type'),
                
                TextEntry::make('amount')
                    ->label('Amount')
                    ->money('KES'),
                
                TextEntry::make('discount')
                    ->label('Discount')
                    ->money('KES'),
                
                TextEntry::make('total_payable')
                    ->label('Total Payable')
                    ->money('KES')
                    ->weight('bold'),
                
                TextEntry::make('paid_amount')
                    ->label('Paid Amount')
                    ->money('KES')
                    ->color('success'),
                
                TextEntry::make('balance')
                    ->label('Balance')
                    ->money('KES')
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                
                TextEntry::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'pending' => 'info',
                        'overdue' => 'danger',
                        'waived' => 'gray',
                        default => 'secondary',
                    }),
                
                TextEntry::make('due_date')
                    ->label('Due Date')
                    ->date(),
                
                TextEntry::make('notes')
                    ->label('Notes')
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