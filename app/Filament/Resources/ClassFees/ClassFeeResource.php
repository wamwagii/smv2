<?php

namespace App\Filament\Resources\ClassFees;

use App\Filament\Resources\ClassFees\Pages\CreateClassFee;
use App\Filament\Resources\ClassFees\Pages\EditClassFee;
use App\Filament\Resources\ClassFees\Pages\ListClassFees;
use App\Filament\Resources\ClassFees\Pages\ViewClassFee;
use App\Filament\Resources\ClassFees\Schemas\ClassFeeForm;
use App\Filament\Resources\ClassFees\Schemas\ClassFeeInfolist;
use App\Filament\Resources\ClassFees\Tables\ClassFeesTable;
use App\Models\ClassFee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ClassFeeResource extends Resource
{
    protected static ?string $model = ClassFee::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return ClassFeeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClassFeeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassFeesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClassFees::route('/'),
            'create' => CreateClassFee::route('/create'),
            'view' => ViewClassFee::route('/{record}'),
            'edit' => EditClassFee::route('/{record}/edit'),
        ];
    }
}