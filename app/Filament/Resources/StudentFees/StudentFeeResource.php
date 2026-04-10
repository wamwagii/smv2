<?php

namespace App\Filament\Resources\StudentFees;

use App\Filament\Resources\StudentFees\Pages\CreateStudentFee;
use App\Filament\Resources\StudentFees\Pages\EditStudentFee;
use App\Filament\Resources\StudentFees\Pages\ListStudentFees;
use App\Filament\Resources\StudentFees\Pages\ViewStudentFee;
use App\Filament\Resources\StudentFees\Schemas\StudentFeeForm;
use App\Filament\Resources\StudentFees\Schemas\StudentFeeInfolist;
use App\Filament\Resources\StudentFees\Tables\StudentFeesTable;
use App\Models\StudentFee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class StudentFeeResource extends Resource
{
    protected static ?string $model = StudentFee::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return StudentFeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StudentFeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentFeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentFees::route('/'),
            'create' => CreateStudentFee::route('/create'),
            'view' => ViewStudentFee::route('/{record}'),
            'edit' => EditStudentFee::route('/{record}/edit'),
        ];
    }
}