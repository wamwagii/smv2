<?php

namespace App\Filament\Resources\ClassRooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ClassRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Class Name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('code')
                    ->label('Class Code')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('academicYear.name')
                    ->label('Academic Year')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('school.name')
                    ->label('School')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->numeric()
                    ->sortable(),
                
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('students_count')
                    ->label('Students Enrolled')
                    ->counts('students')
                    ->numeric()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('school_id')
                    ->relationship('school', 'name')
                    ->label('School')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('academic_year_id')
                    ->relationship('academicYear', 'name')
                    ->label('Academic Year')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->label('Status'),
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