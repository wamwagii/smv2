<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Filament\Resources\StudentResource\Pages\ViewStudent;
use App\Models\Student;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    
    // Remove these lines - they cause the error
    // protected static ?string $navigationGroup = 'School Management';
    // protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->schema([
                        Select::make('school_id')
                            ->relationship('school', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        
                        TextInput::make('admission_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                        
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        
                        DatePicker::make('date_of_birth')
                            ->required(),
                        
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->required(),
                        
                        DatePicker::make('enrollment_date')
                            ->required(),
                        
                        Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
                
                Section::make('Address Information')
                    ->schema([
                        Textarea::make('address')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        
                        TextInput::make('city')
                            ->maxLength(100),
                    ])->columns(2),
                
                Section::make('Parent/Guardian Information')
                    ->schema([
                        TextInput::make('parent_name')
                            ->label('Parent/Guardian Name')
                            ->maxLength(255),
                        
                        TextInput::make('parent_phone')
                            ->label('Parent/Guardian Phone')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('parent_email')
                            ->label('Parent/Guardian Email')
                            ->email()
                            ->maxLength(255),
                    ])->columns(2),
                
                Section::make('Medical Information')
                    ->schema([
                        Textarea::make('medical_notes')
                            ->label('Medical Notes / Allergies')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('admission_number')
                    ->label('Admission No')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('first_name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('school.name')
                    ->label('School')
                    ->searchable(),
                
                TextColumn::make('email')
                    ->searchable(),
                
                TextColumn::make('phone'),
                
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                
                TextColumn::make('enrollment_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('school_id')
                    ->relationship('school', 'name')
                    ->label('School'),
                
                SelectFilter::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ]),
                
                SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
                \Filament\Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'view' => ViewStudent::route('/{record}'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}