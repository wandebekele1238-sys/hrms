<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Department;
use App\Models\Branch;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\LeaveRequest;
class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '60s';
    protected function getStats(): array
    {
        return [
            Stat::make('Active Employees', User::where('status', 'active')->count())
              ->description('Currently active employees')
              ->descriptionIcon('heroicon-o-users')
              ->color('success'),

            Stat::make('Inactive Employees', User::where('status', 'inactive')->count())
             ->description('Currently inactive employees')
             ->descriptionIcon('heroicon-o-user-minus')
             ->color('danger'),
             Stat::make('Branches', Branch::count())
            ->description('Total Branches')
            ->descriptionIcon('heroicon-o-building-office')
            ->color('info'),
            Stat::make('Departments', Department::count())
            ->description('Total Departments')
            ->descriptionIcon('heroicon-o-building-office')
            ->color('info'),
             Stat::make('Positions', Position::count())
            ->description('Total Positions')
            ->descriptionIcon('heroicon-o-briefcase')
            ->color('info'),
            Stat::make('Pending Leave Requests', LeaveRequest::where('status', 'pending')->count())
            ->description('Awaiting Approvals')
            ->descriptionIcon('heroicon-o-calendar-days')
            ->color('warning'),
            Stat::make('Today\'s Attendance', Attendance::whereDate('date', today())->count())
            ->description('Checked in today')
            ->descriptionIcon('heroicon-o-clock')
            ->color('primary'),
        ];
    }
}
