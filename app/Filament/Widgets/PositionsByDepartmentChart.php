<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\User;
use Filament\Widgets\ChartWidget;

class PositionsByDepartmentChart extends ChartWidget
{
    protected ?string $heading = 'Positions by Department';

    protected int|string|array $columnSpan = 'half';

    protected function getData(): array
    {
        $departments = Department::with('positions')->get();

        $labels = $departments
            ->pluck('name')
            ->toArray();

        $positions = $departments
            ->flatMap(fn ($department) => $department->positions)
            ->unique('id')
            ->values();

        $colors = [
            '#2563EB',
            '#16A34A',
            '#F59E0B',
            '#DC2626',
            '#7C3AED',
            '#0891B2',
            '#DB2777',
            '#EA580C',
            '#4F46E5',
            '#65A30D',
        ];

        $datasets = $positions->map(function ($position, $index) use ($departments, $colors) {
            return [
                'label' => $position->title,

                'data' => $departments->map(function ($department) use ($position) {
                    return User::where('department_id', $department->id)
                        ->where('position_id', $position->id)
                        ->where('status', 'active')
                        ->count();
                })->toArray(),

                'backgroundColor' => $colors[$index % count($colors)],

                'borderColor' => $colors[$index % count($colors)],

                'borderWidth' => 1,
            ];
        })->values()->toArray();

        return [
            'datasets' => $datasets,
            'labels' => $labels,
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