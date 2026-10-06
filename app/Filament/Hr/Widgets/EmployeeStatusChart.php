<?php

namespace App\Filament\Hr\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class EmployeeStatusChart extends ChartWidget
{
    protected ?string $heading = 'Employee Status';

    protected int|string|array $columnSpan = 0;

    protected function getData(): array
    {
        $active = User::where('status', 'active')->count();
        $inactive = User::where('status', 'inactive')->count();
        $onLeave = User::where('status', 'on-leave')->count();
        $terminated = User::where('status', 'terminated')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Employees',
                    'data' => [$active, $inactive, $onLeave, $terminated],

                    // Active = green, Inactive = red, On Leave = blue, Terminated = gray
                    'backgroundColor' => [
                        '#22c55e',
                        '#ef4444',
                        '#3b82f6',
                        '#6b7280',
                    ],

                    'borderColor' => [
                        '#16a34a',
                        '#dc2626',
                        '#2563EB',
                        '#4b5563',
                    ],

                    'borderWidth' => 2,
                ],
            ],

            'labels' => [
                'Active',
                'Inactive',
                'On Leave',
                'Terminated',
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

            'cutout' => '65%',
        ];
    }
}