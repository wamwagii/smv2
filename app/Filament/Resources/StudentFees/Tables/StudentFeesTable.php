<?php

namespace App\Filament\Resources\StudentFees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StudentFeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.full_name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('student.admission_number')
                    ->label('Admission No')
                    ->searchable(),
                
                TextColumn::make('classFee.classRoom.name')
                    ->label('Class')
                    ->searchable(),
                
                TextColumn::make('classFee.feeType.name')
                    ->label('Fee Type')
                    ->searchable(),
                
                TextColumn::make('total_payable')
                    ->label('Total')
                    ->money('KES')
                    ->sortable(),
                
                TextColumn::make('paid_amount')
                    ->label('Paid')
                    ->money('KES')
                    ->sortable(),
                
                TextColumn::make('balance')
                    ->label('Balance')
                    ->money('KES')
                    ->sortable()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),
                
                TextColumn::make('status')
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
                
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                        'overdue' => 'Overdue',
                        'waived' => 'Waived',
                    ])
                    ->label('Status'),
                
                SelectFilter::make('classFee.feeType_id')
                    ->relationship('classFee.feeType', 'name')
                    ->label('Fee Type')
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}