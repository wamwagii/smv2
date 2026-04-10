<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Facades\DB;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';
    
    protected string $view = 'filament.pages.settings';
    
    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'app_name' => Setting::get('app_name'),
            'dark_mode' => Setting::get('dark_mode'),
            'primary_color' => Setting::get('primary_color'),
            'timezone' => Setting::get('timezone'),
            'date_format' => Setting::get('date_format'),
            'school_name' => Setting::get('school_name'),
            'school_address' => Setting::get('school_address'),
            'school_phone' => Setting::get('school_phone'),
            'school_email' => Setting::get('school_email'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        Tab::make('General')
                            ->schema([
                                TextInput::make('app_name')
                                    ->label('Application Name')
                                    ->required()
                                    ->maxLength(255),
                                
                                Select::make('timezone')
                                    ->label('Timezone')
                                    ->options([
                                        'Africa/Nairobi' => 'Africa/Nairobi (EAT)',
                                        'Africa/Lagos' => 'Africa/Lagos (WAT)',
                                        'Africa/Johannesburg' => 'Africa/Johannesburg (SAST)',
                                        'UTC' => 'UTC',
                                    ])
                                    ->required(),
                                
                                Select::make('date_format')
                                    ->label('Date Format')
                                    ->options([
                                        'Y-m-d' => 'YYYY-MM-DD',
                                        'd/m/Y' => 'DD/MM/YYYY',
                                        'm/d/Y' => 'MM/DD/YYYY',
                                        'd M Y' => 'DD Mon YYYY',
                                    ])
                                    ->required(),
                            ]),
                        
                        Tab::make('Appearance')
                            ->schema([
                                Select::make('dark_mode')
                                    ->label('Theme')
                                    ->options([
                                        'light' => 'Light Mode',
                                        'dark' => 'Dark Mode',
                                        'system' => 'System Default',
                                    ])
                                    ->required(),
                                
                                ColorPicker::make('primary_color')
                                    ->label('Primary Color')
                                    ->required(),
                            ]),
                        
                        Tab::make('School Information')
                            ->schema([
                                TextInput::make('school_name')
                                    ->label('School Name')
                                    ->maxLength(255),
                                
                                Textarea::make('school_address')
                                    ->label('School Address')
                                    ->rows(3),
                                
                                TextInput::make('school_phone')
                                    ->label('School Phone')
                                    ->maxLength(50),
                                
                                TextInput::make('school_email')
                                    ->label('School Email')
                                    ->email()
                                    ->maxLength(255),
                            ]),
                        
                        Tab::make('Database')
                            ->schema([
                                Section::make('Data Management')
                                    ->description('Warning: These actions will permanently delete data!')
                                    ->schema([
                                        Actions::make([
                                            Action::make('delete_all_students')
                                                ->label('Delete All Students')
                                                ->color('danger')
                                                ->icon('heroicon-o-user-minus')
                                                ->requiresConfirmation()
                                                ->modalHeading('Delete All Students')
                                                ->modalDescription('Are you sure you want to delete ALL students? This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Delete All')
                                                ->action(function () {
                                                    DB::table('students')->delete();
                                                    Notification::make()->title('All students deleted successfully!')->success()->send();
                                                }),
                                            
                                            Action::make('delete_all_teachers')
                                                ->label('Delete All Teachers')
                                                ->color('danger')
                                                ->icon('heroicon-o-user-minus')
                                                ->requiresConfirmation()
                                                ->modalHeading('Delete All Teachers')
                                                ->modalDescription('Are you sure you want to delete ALL teachers? This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Delete All')
                                                ->action(function () {
                                                    DB::table('teachers')->delete();
                                                    Notification::make()->title('All teachers deleted successfully!')->success()->send();
                                                }),
                                            
                                            Action::make('delete_all_classes')
                                                ->label('Delete All Classes')
                                                ->color('danger')
                                                ->icon('heroicon-o-academic-cap')
                                                ->requiresConfirmation()
                                                ->modalHeading('Delete All Classes')
                                                ->modalDescription('Are you sure you want to delete ALL classes? This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Delete All')
                                                ->action(function () {
                                                    DB::table('class_rooms')->delete();
                                                    Notification::make()->title('All classes deleted successfully!')->success()->send();
                                                }),
                                            
                                            Action::make('delete_all_fees')
                                                ->label('Delete All Fee Records')
                                                ->color('danger')
                                                ->icon('heroicon-o-currency-dollar')
                                                ->requiresConfirmation()
                                                ->modalHeading('Delete All Fee Records')
                                                ->modalDescription('Are you sure you want to delete ALL fee records? This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Delete All')
                                                ->action(function () {
                                                    DB::table('student_fees')->delete();
                                                    DB::table('class_fees')->delete();
                                                    Notification::make()->title('All fee records deleted successfully!')->success()->send();
                                                }),
                                            
                                            Action::make('delete_all_academic_years')
                                                ->label('Delete All Academic Years')
                                                ->color('danger')
                                                ->icon('heroicon-o-calendar')
                                                ->requiresConfirmation()
                                                ->modalHeading('Delete All Academic Years')
                                                ->modalDescription('Are you sure you want to delete ALL academic years? This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Delete All')
                                                ->action(function () {
                                                    DB::table('academic_years')->delete();
                                                    Notification::make()->title('All academic years deleted successfully!')->success()->send();
                                                }),
                                            
                                            Action::make('reset_all_data')
                                                ->label('RESET ALL DATA')
                                                ->color('danger')
                                                ->icon('heroicon-o-trash')
                                                ->requiresConfirmation()
                                                ->modalHeading('Reset ALL Data')
                                                ->modalDescription('WARNING: This will delete ALL data from ALL tables! This action cannot be undone.')
                                                ->modalSubmitActionLabel('Yes, Reset Everything')
                                                ->action(function () {
                                                    DB::statement('PRAGMA foreign_keys = OFF');
                                                    $tables = ['students', 'teachers', 'class_rooms', 'student_fees', 'class_fees', 'academic_years'];
                                                    foreach ($tables as $table) {
                                                        DB::table($table)->delete();
                                                    }
                                                    DB::statement('PRAGMA foreign_keys = ON');
                                                    Notification::make()->title('All data has been reset!')->danger()->send();
                                                }),
                                        ])->columns(2),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        
        // Apply dark mode setting
        session(['dark_mode' => $data['dark_mode']]);
        
        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action(fn () => $this->save())
                ->color('primary'),
        ];
    }
}