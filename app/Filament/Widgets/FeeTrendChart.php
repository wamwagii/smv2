<?php

namespace App\Filament\Widgets;

use App\Models\StudentFee;
use Filament\Widgets\ChartWidget;

class FeeTrendChart extends ChartWidget
{
    protected int | string | array $columnSpan = 1;
    
    protected function getData(): array
    {
        $months = collect();
        $collected = collect();
        $expected = collect();
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months->push($month->format('M Y'));
            
            $collectedAmount = StudentFee::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('paid_amount');
            $collected->push($collectedAmount);
            
            $expectedAmount = StudentFee::whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_payable');
            $expected->push($expectedAmount);
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Collected (KES)',
                    'data' => $collected->toArray(),
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => '#10b981',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'fill' => true,
                    'pointBackgroundColor' => '#10b981',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
                [
                    'label' => 'Expected (KES)',
                    'data' => $expected->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                    'borderDash' => [5, 5],
                    'tension' => 0.4,
                    'fill' => false,
                    'pointBackgroundColor' => '#3b82f6',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 10,
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'callbacks' => [
                        'label' => 'function(context) {
                            let label = context.dataset.label || "";
                            let value = context.raw || 0;
                            return label + ": KES " + value.toLocaleString();
                        }',
                    ],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) {
                            return "KES " + value.toLocaleString();
                        }',
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Amount (KES)',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Month',
                    ],
                ],
            ],
        ];
    }
    
    public function getHeading(): string
    {
        return 'Fee Collection Trend - Last 6 Months';
    }
}