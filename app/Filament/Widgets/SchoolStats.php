<?php

namespace App\Filament\Widgets;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\StudentFee;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SchoolStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        $totalStudents = Student::count();
        $activeStudents = Student::where('is_active', true)->count();
        $totalTeachers = Teacher::count();
        $activeTeachers = Teacher::where('is_active', true)->count();
        $totalClasses = ClassRoom::count();
        $totalCollected = StudentFee::sum('paid_amount');
        $outstandingBalance = StudentFee::sum('balance');
        
        return [
            Stat::make('Total Students', number_format($totalStudents))
                ->description($activeStudents . ' Active')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
            
            Stat::make('Total Teachers', number_format($totalTeachers))
                ->description($activeTeachers . ' Active')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),
            
            Stat::make('Total Classes', number_format($totalClasses))
                ->description('Active Classes')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('warning'),
            
            Stat::make('Fees Collected', 'KES ' . number_format($totalCollected, 2))
                ->description('Total Revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            
            Stat::make('Outstanding Balance', 'KES ' . number_format($outstandingBalance, 2))
                ->description('Pending Payments')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($outstandingBalance > 0 ? 'danger' : 'success'),
        ];
    }
}