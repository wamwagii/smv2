<?php

namespace App\Filament\Resources\ClassFees\Pages;

use App\Filament\Resources\ClassFees\ClassFeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassFees extends ListRecords
{
    protected static string $resource = ClassFeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
