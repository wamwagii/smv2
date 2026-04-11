<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Header widgets - these appear at the top
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\SchoolStats::class,
        ];
    }
    
    // Main widgets - these appear in the main content area
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\FeeTrendChart::class,
            \App\Filament\Widgets\PaymentMethodsDonut::class,
            \App\Filament\Widgets\RecentTransactions::class,
        ];
    }
    
    // Override to ensure header widgets are shown
    public function hasHeaderWidgets(): bool
    {
        return true;
    }
    
    // Set columns for the main content area (2 columns for charts)
    public function getColumns(): int | array
    {
        return 2;
    }
    
    // Set custom title
    public function getTitle(): string
    {
        return 'School Management Dashboard';
    }
}