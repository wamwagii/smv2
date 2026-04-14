<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-server';

    
    protected static ?string $navigationLabel = 'Database Management';
    
    protected static ?int $navigationSort = 100;
    
    protected string $view = 'filament.pages.settings';

    public function mount(): void
    {
        // No form data needed since we removed settings
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Database Management')
                    ->description('Manage your database: backup, export, or delete data')
                    ->schema([
                        Actions::make([
                            // Export Database as SQL
                            Action::make('export_database')
                                ->label('Export Database (SQL)')
                                ->color('success')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->action(function () {
                                    return $this->exportDatabase();
                                }),
                            
                            // Backup Database
                            Action::make('backup_database')
                                ->label('Create Backup')
                                ->color('primary')
                                ->icon('heroicon-o-cloud-arrow-up')
                                ->requiresConfirmation()
                                ->modalHeading('Create Database Backup')
                                ->modalDescription('This will create a compressed backup of your entire database. The backup will be stored in storage/backups.')
                                ->modalSubmitActionLabel('Create Backup')
                                ->action(function () {
                                    $this->backupDatabase();
                                }),
                            
                            // Download Latest Backup
                            Action::make('download_backup')
                                ->label('Download Latest Backup')
                                ->color('info')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->action(function () {
                                    return $this->downloadLatestBackup();
                                }),
                        ])->columns(3),
                    ]),
                
                Section::make('Data Deletion')
                    ->description('⚠️ Warning: These actions will permanently delete data!')
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
                                    $tables = ['students', 'teachers', 'class_rooms', 'student_fees', 'class_fees', 'academic_years', 'receipts', 'notifications'];
                                    foreach ($tables as $table) {
                                        if (DB::table($table)->exists()) {
                                            DB::table($table)->delete();
                                        }
                                    }
                                    DB::statement('PRAGMA foreign_keys = ON');
                                    Notification::make()->title('All data has been reset!')->danger()->send();
                                }),
                        ])->columns(2),
                    ]),
                
                Section::make('Database Information')
                    ->description('Current database statistics')
                    ->schema([
                        Actions::make([
                            Action::make('show_stats')
                                ->label('Show Database Stats')
                                ->color('info')
                                ->icon('heroicon-o-chart-bar')
                                ->action(function () {
                                    $stats = [
                                        'Students' => DB::table('students')->count(),
                                        'Teachers' => DB::table('teachers')->count(),
                                        'Classes' => DB::table('class_rooms')->count(),
                                        'Fee Records' => DB::table('student_fees')->count(),
                                        'Academic Years' => DB::table('academic_years')->count(),
                                    ];
                                    $message = "Database Statistics:\n\n" . collect($stats)->map(fn($count, $table) => "• {$table}: {$count}")->join("\n");
                                    Notification::make()->title('Database Statistics')->body($message)->info()->send();
                                }),
                            
                            Action::make('optimize_db')
                                ->label('Optimize Database')
                                ->color('success')
                                ->icon('heroicon-o-sparkles')
                                ->action(function () {
                                    DB::statement('VACUUM');
                                    Notification::make()->title('Database optimized successfully!')->success()->send();
                                }),
                        ])->columns(2),
                    ]),
            ]);
    }

    protected function exportDatabase()
    {
        $databasePath = database_path('database.sqlite');
        
        if (!File::exists($databasePath)) {
            Notification::make()
                ->title('Database file not found!')
                ->danger()
                ->send();
            return;
        }
        
        // Get all tables
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
        
        $sql = "-- Database Export\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        foreach ($tables as $table) {
            $tableName = $table->name;
            
            // Skip system tables
            if (in_array($tableName, ['sqlite_sequence', 'migrations'])) {
                continue;
            }
            
            // Get create table syntax
            $createTable = DB::select("SELECT sql FROM sqlite_master WHERE type='table' AND name=?", [$tableName]);
            if (!empty($createTable)) {
                $sql .= $createTable[0]->sql . ";\n\n";
            }
            
            // Get data
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                foreach ($rows as $row) {
                    $columns = [];
                    $values = [];
                    foreach ((array)$row as $key => $value) {
                        $columns[] = $key;
                        $values[] = is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }
                    $sql .= "INSERT INTO \"{$tableName}\" (\"" . implode('","', $columns) . "\") VALUES (" . implode(',', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }
        
        // Create exports directory if it doesn't exist
        $exportPath = storage_path('app/exports');
        if (!File::exists($exportPath)) {
            File::makeDirectory($exportPath, 0755, true);
        }
        
        // Save file
        $filename = 'database_export_' . date('Y-m-d_His') . '.sql';
        $filePath = $exportPath . '/' . $filename;
        File::put($filePath, $sql);
        
        // Download file
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    
    protected function backupDatabase()
    {
        $databasePath = database_path('database.sqlite');
        
        if (!File::exists($databasePath)) {
            Notification::make()
                ->title('Database file not found!')
                ->danger()
                ->send();
            return;
        }
        
        // Create backups directory
        $backupPath = storage_path('app/backups');
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }
        
        // Create backup filename
        $filename = 'backup_' . date('Y-m-d_His') . '.sqlite';
        $backupFile = $backupPath . '/' . $filename;
        
        // Copy database file
        File::copy($databasePath, $backupFile);
        
        // Create zip archive
        $zip = new ZipArchive();
        $zipFilename = $backupPath . '/backup_' . date('Y-m-d_His') . '.zip';
        
        if ($zip->open($zipFilename, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($backupFile, $filename);
            $zip->close();
            
            // Delete the original backup file
            File::delete($backupFile);
            
            // Clean old backups (keep only last 10)
            $this->cleanOldBackups($backupPath);
            
            Notification::make()
                ->title('Backup created successfully!')
                ->body('Backup saved to: ' . $zipFilename)
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to create backup!')
                ->danger()
                ->send();
        }
    }
    
    protected function downloadLatestBackup()
    {
        $backupPath = storage_path('app/backups');
        
        if (!File::exists($backupPath)) {
            Notification::make()
                ->title('No backups found!')
                ->warning()
                ->send();
            return;
        }
        
        // Get all backup files
        $backups = File::glob($backupPath . '/backup_*.zip');
        
        if (empty($backups)) {
            Notification::make()
                ->title('No backup files found!')
                ->warning()
                ->send();
            return;
        }
        
        // Get the latest backup
        $latestBackup = collect($backups)->sortDesc()->first();
        
        return response()->download($latestBackup);
    }
    
    protected function cleanOldBackups($backupPath)
    {
        $backups = File::glob($backupPath . '/backup_*.zip');
        
        // Keep only last 10 backups
        if (count($backups) > 10) {
            $backupsToDelete = collect($backups)->sort()->take(count($backups) - 10);
            foreach ($backupsToDelete as $backup) {
                File::delete($backup);
            }
        }
    }

    protected function getFormActions(): array
    {
        // No form actions since we removed the settings form
        return [];
    }
}