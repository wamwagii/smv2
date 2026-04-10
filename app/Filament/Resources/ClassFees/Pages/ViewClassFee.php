<?php

namespace App\Filament\Resources\ClassFees\Pages;

use App\Filament\Resources\ClassFees\ClassFeeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewClassFee extends ViewRecord
{
    protected static string $resource = ClassFeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
