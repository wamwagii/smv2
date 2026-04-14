<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Remove or comment out these static properties if they cause issues
    // protected static ?string $navigationIcon = 'heroicon-o-home';
    // protected static ?string $navigationLabel = 'Dashboard';
    // protected static ?int $navigationSort = 1;
    
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\SchoolStats::class,
        ];
    }
    
    protected function getFooterWidgets(): array
    {
        return [];
    }
    
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\FeeTrendChart::class,
            \App\Filament\Widgets\PaymentMethodsDonut::class,
            \App\Filament\Widgets\RecentTransactions::class,
        ];
    }
    
    public function getColumns(): array|int
    {
        return 2;
    }
    
    public function getTitle(): string
    {
        return 'School Management Dashboard';
    }
    
    public function getHeading(): string
    {
        return 'Dashboard';
    }
    
    public function getSubheading(): string
    {
        return 'Welcome back! Here\'s an overview of your school management system.';
    }
}