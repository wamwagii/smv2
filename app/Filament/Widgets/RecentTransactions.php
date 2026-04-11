<?php

namespace App\Filament\Widgets;

use App\Models\FeePayment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTransactions extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = 'Recent Transactions';
    
    protected function getTableHeading(): string
    {
        return 'Recent Transactions';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                FeePayment::query()
                    ->with(['studentFee.student', 'studentFee.classFee.feeType'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('studentFee.student.admission_number')
                    ->label('Admission No')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('studentFee.student.full_name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('studentFee.classFee.feeType.name')
                    ->label('Fee Type')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('KES')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'mpesa' => 'success',
                        'bank_equity' => 'primary',
                        'bank_coop' => 'primary',
                        'cash' => 'warning',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'mpesa' => 'M-PESA',
                        'bank_equity' => 'Equity Bank',
                        'bank_coop' => 'Co-op Bank',
                        'cash' => 'Cash',
                        default => ucfirst($state),
                    }),
                
                Tables\Columns\TextColumn::make('transaction_reference')
                    ->label('Reference')
                    ->copyable()
                    ->placeholder('N/A'),
                
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('studentFee.student.classRoom.name')
                    ->label('Class')
                    ->placeholder('N/A'),
                
                Tables\Columns\TextColumn::make('studentFee.status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'pending' => 'info',
                        'overdue' => 'danger',
                        default => 'secondary',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'mpesa' => 'M-PESA',
                        'bank_equity' => 'Equity Bank',
                        'bank_coop' => 'Co-op Bank',
                        'cash' => 'Cash',
                    ]),
                
                Tables\Filters\SelectFilter::make('status')
                    ->label('Payment Status')
                    ->options([
                        'paid' => 'Paid',
                        'partial' => 'Partial',
                        'pending' => 'Pending',
                        'overdue' => 'Overdue',
                    ]),
                
                Tables\Filters\Filter::make('payment_date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        \Filament\Forms\Components\DatePicker::make('to')
                            ->label('To Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('payment_date', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('payment_date', '<=', $data['to']));
                    }),
            ])
            ->defaultSort('payment_date', 'desc')
            ->striped()
            ->poll('30s');
    }
}