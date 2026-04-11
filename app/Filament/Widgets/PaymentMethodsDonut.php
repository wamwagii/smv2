<?php

namespace App\Filament\Widgets;

use App\Models\FeePayment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PaymentMethodsDonut extends ChartWidget
{
    protected int | string | array $columnSpan = 1;
    
    protected function getData(): array
    {
        // Get current month data
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $data = FeePayment::select('payment_method', DB::raw('SUM(amount) as total'))
            ->whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->groupBy('payment_method')
            ->get();
        
        // If no data this month, get all time data
        if ($data->isEmpty()) {
            $data = FeePayment::select('payment_method', DB::raw('SUM(amount) as total'))
                ->groupBy('payment_method')
                ->get();
        }
        
        $labels = [];
        $totals = [];
        $colors = [
            '#10b981', // M-PESA - green
            '#3b82f6', // Equity Bank - blue
            '#f59e0b', // Co-op Bank - orange
            '#ef4444', // Cash - red
            '#8b5cf6', // Other - purple
        ];
        
        $totalAmount = 0;
        foreach ($data as $item) {
            $totalAmount += $item->total;
        }
        
        foreach ($data as $index => $item) {
            $methodName = match($item->payment_method) {
                'mpesa' => 'M-PESA',
                'bank_equity' => 'Equity Bank',
                'bank_coop' => 'Co-op Bank',
                'cash' => 'Cash',
                default => ucfirst($item->payment_method),
            };
            
            $percentage = $totalAmount > 0 ? round(($item->total / $totalAmount) * 100, 1) : 0;
            $labels[] = $methodName . ' (' . $percentage . '%)';
            $totals[] = $item->total;
        }
        
        if ($data->isEmpty()) {
            $labels = ['No Payment Data'];
            $totals = [1];
            $colors = ['#9ca3af'];
        }
        
        return [
            'datasets' => [
                [
                    'data' => $totals,
                    'backgroundColor' => $colors,
                    'borderWidth' => 0,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'doughnut';
    }
    
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            const label = context.label || "";
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ": KES " + value.toLocaleString() + " (" + percentage + "%)";
                        }',
                    ],
                ],
            ],
            'cutout' => '60%',
        ];
    }
    
    public function getHeading(): string
    {
        return 'Payment Methods Distribution - ' . now()->format('F Y');
    }
}