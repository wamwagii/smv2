<?php

namespace App\Filament\Resources\Pages;

use App\Filament\Resources\SchoolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSchools extends ListRecords
{
    protected static string $resource = SchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New School')
                ->icon('heroicon-o-plus')
                ->createAnother(false),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add widgets here later if needed
        ];
    }
}