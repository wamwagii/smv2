<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher_code')
                    ->label('Teacher Code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('school.name')
                    ->label('School')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                
                TextColumn::make('qualification')
                    ->label('Qualification')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('specialization')
                    ->label('Specialization')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('hire_date')
                    ->label('Hired')
                    ->date()
                    ->sortable(),
                
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                
                TextColumn::make('created_at')
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
                
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->label('Gender'),
                
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