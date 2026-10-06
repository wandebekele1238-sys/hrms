<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Filament\Widgets\ChartWidget;

class AttendanceChart extends ChartWidget
{
    protected ?string $heading = 'Attendance - Last 7 Days';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $dates = collect(range(6, 0))
            ->map(fn ($days) => now()->subDays($days));

        $present = $dates
            ->map(fn ($date) => Attendance::whereDate('date', $date)
                ->where('status', 'present')
                ->count()
            )
            ->toArray();

        $late = $dates
            ->map(fn ($date) => Attendance::whereDate('date', $date)
                ->where('status', 'late')
                ->count()
            )
            ->toArray();

        $absent = $dates
            ->map(fn ($date) => Attendance::whereDate('date', $date)
                ->where('status', 'absent')
                ->count()
            )
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Present',
                    'data' => $present,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#16a34a',
                    'borderWidth' => 1,
                ],

                [
                    'label' => 'Late',
                    'data' => $late,
                    'backgroundColor' => '#f59e0b',
                    'borderColor' => '#d97706',
                    'borderWidth' => 1,
                ],

                [
                    'label' => 'Absent',
                    'data' => $absent,
                    'backgroundColor' => '#ef4444',
                    'borderColor' => '#dc2626',
                    'borderWidth' => 1,
                ],
            ],

            'labels' => $dates
                ->map(fn ($date) => $date->format('D'))
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,

            'maintainAspectRatio' => true,

            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],

            'scales' => [
                'x' => [
                    'stacked' => false,
                ],

                'y' => [
                    'beginAtZero' => true,

                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}