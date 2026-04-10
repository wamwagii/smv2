<?php

namespace App\Filament\Resources\ClassFees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClassFeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classRoom.name')
                    ->label('Class')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('feeType.name')
                    ->label('Fee Type')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('academicYear.name')
                    ->label('Academic Year')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('KES')
                    ->sortable(),
                
                TextColumn::make('frequency')
                    ->label('Frequency')
                    ->badge()
                    ->color('info'),
                
                IconColumn::make('is_mandatory')
                    ->label('Mandatory')
                    ->boolean(),
                
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('class_room_id')
                    ->relationship('classRoom', 'name')
                    ->label('Class')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('fee_type_id')
                    ->relationship('feeType', 'name')
                    ->label('Fee Type')
                    ->searchable(),
                
                SelectFilter::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->label('Academic Year'),
                
                SelectFilter::make('is_mandatory')
                    ->options([
                        '1' => 'Mandatory',
                        '0' => 'Optional',
                    ])
                    ->label('Type'),
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