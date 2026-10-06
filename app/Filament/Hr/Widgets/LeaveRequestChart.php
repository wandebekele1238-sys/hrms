<?php

namespace App\Filament\Hr\Widgets;

use App\Models\LeaveRequest;
use Filament\Widgets\ChartWidget;

class LeaveRequestChart extends ChartWidget
{
    protected ?string $heading = 'Leave Requests';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $pending = LeaveRequest::where('status', 'pending')->count();

        $approved = LeaveRequest::where('status', 'approved')->count();

        $rejected = LeaveRequest::where('status', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Leave Requests',

                    'data' => [
                        $pending,
                        $approved,
                        $rejected,
                    ],

                    'backgroundColor' => [
                        '#f59e0b',
                        '#22c55e',
                        '#ef4444',
                    ],

                    'borderWidth' => 2,
                ],
            ],

            'labels' => [
                'Pending',
                'Approved',
                'Rejected',
            ],
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
            ],

            'cutout' => '60%',
        ];
    }
}