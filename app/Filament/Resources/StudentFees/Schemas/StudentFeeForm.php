<?php

namespace App\Filament\Resources\StudentFees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentFeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->first_name . ' ' . $record->last_name . ' (' . $record->admission_number . ')')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Student'),
                
                Select::make('class_fee_id')
                    ->relationship('classFee', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->classRoom->name . ' - ' . $record->feeType->name . ' (KES ' . $record->amount . ')')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Class Fee'),
                
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('KES')
                    ->label('Amount'),
                
                TextInput::make('discount')
                    ->numeric()
                    ->prefix('KES')
                    ->default(0)
                    ->label('Discount'),
                
                TextInput::make('total_payable')
                    ->required()
                    ->numeric()
                    ->prefix('KES')
                    ->label('Total Payable'),
                
                TextInput::make('paid_amount')
                    ->numeric()
                    ->prefix('KES')
                    ->default(0)
                    ->label('Paid Amount'),
                
                TextInput::make('balance')
                    ->numeric()
                    ->prefix('KES')
                    ->label('Balance'),
                
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'waived' => 'Waived',
                    ])
                    ->required()
                    ->default('pending')
                    ->label('Status'),
                
                DatePicker::make('due_date')
                    ->required()
                    ->label('Due Date'),
                
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->label('Notes'),
            ]);
    }
}