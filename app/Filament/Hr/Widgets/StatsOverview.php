<?php

namespace App\Filament\Hr\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\Payroll;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Employees', User::where('status', 'active')->count())
                ->description('Currently Active')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),
                Stat::make('Inactive Employees', User::where('status', 'inactive')->count())
                ->description('Currently Inactive')
                ->descriptionIcon('heroicon-o-users')
                ->color('danger'),
            Stat::make('Pending Leaves', LeaveRequest::where('status', 'pending')->count())
                ->description('Requires Action')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('warning'),
            Stat::make('Today\'s Attendance', Attendance::wheredate('date', today())->where('status', 'present')->count())
                ->description('Present Today')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary'),
            Stat::make('This Month Payroll', Payroll::where('month', date('F'))
                ->where('year', date('Y'))
                ->where('status', 'paid')
                ->count()
            )
                ->description('Processed this month')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }
}
