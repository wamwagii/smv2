<?php

namespace App\Filament\Resources\StudentFees\Pages;

use App\Filament\Resources\StudentFees\StudentFeeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudentFee extends ViewRecord
{
    protected static string $resource = StudentFeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
