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
                // Print receipt column - placed first for visibility
                TextColumn::make('print_action')
                    ->label('Print Receipt')
                    ->getStateUsing(function ($record) {
                        // Try to get or create receipt
                        $receipt = \App\Models\Receipt::where('student_fee_id', $record->id)->first();
                        
                        if (!$receipt) {
                            $payment = \App\Models\FeePayment::where('student_fee_id', $record->id)->first();
                            if ($payment) {
                                $receipt = \App\Models\Receipt::create([
                                    'receipt_number' => \App\Models\Receipt::generateReceiptNumber(),
                                    'student_fee_id' => $record->id,
                                    'fee_payment_id' => $payment->id,
                                    'amount' => $payment->amount,
                                    'payment_method' => $payment->payment_method,
                                    'transaction_reference' => $payment->transaction_reference,
                                    'payment_date' => $payment->payment_date,
                                    'printed_by' => null,
                                    'printed_at' => now(),
                                    'print_count' => 1,
                                ]);
                            }
                        }
                        
                        if ($receipt) {
                            return '<a href="' . route('receipt.print', $receipt) . '" target="_blank" style="color: #3b82f6; text-decoration: underline; font-weight: bold;">PRINT RECEIPT</a>';
                        }
                        
                        return '<span style="color: #9ca3af;">No payment</span>';
                    })
                    ->html()
                    ->toggleable(false), // Force it to always be visible
                
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