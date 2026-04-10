<?php

namespace App\Filament\Resources;

use App\Models\AcademicYear;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendar;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('school_id')
                    ->relationship('school', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('School'),
                
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., 2024-2025'),
                
                DatePicker::make('start_date')
                    ->required()
                    ->label('Start Date'),
                
                DatePicker::make('end_date')
                    ->required()
                    ->label('End Date'),
                
                Toggle::make('is_current')
                    ->label('Current Academic Year'),
                
                Textarea::make('description')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('school.name')
                    ->label('School')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('name')
                    ->label('Academic Year')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                
                IconColumn::make('is_current')
                    ->boolean()
                    ->label('Current'),
                
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
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                \Filament\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\AcademicYearResource\Pages\ListAcademicYears::route('/'),
            'create' => \App\Filament\Resources\AcademicYearResource\Pages\CreateAcademicYear::route('/create'),
            'view' => \App\Filament\Resources\AcademicYearResource\Pages\ViewAcademicYear::route('/{record}'),
            'edit' => \App\Filament\Resources\AcademicYearResource\Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}