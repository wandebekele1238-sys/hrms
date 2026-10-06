<?php

namespace App\Filament\Hr\Widgets;

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

        return [
            'datasets' => [[
    'label' => 'Present',

    'data' => $dates
        ->map(fn ($date) => Attendance::whereDate('date', $date)->count())
        ->toArray(),

    'borderColor' => 'rgb(212, 37, 235)',

    'backgroundColor' => 'hsla(54, 95%, 50%, 0.93)',

    'fill' => true,

    'tension' => 0.4,

    'borderWidth' => 2,

    'pointRadius' => 4,

    'pointHoverRadius' => 6,
]],
            'labels' => $dates
                ->map(fn ($date) => $date->format('D'))
                ->toArray(),
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
            'maintainAspectRatio' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}