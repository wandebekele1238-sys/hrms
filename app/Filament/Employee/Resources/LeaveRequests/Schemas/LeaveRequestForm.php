<?php

namespace App\Filament\Employee\Resources\LeaveRequests\Schemas;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class LeaveRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->user()->id)
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Select::make('leave_type_id')
                    ->relationship('leaveType', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get): void {
                        self::calculateDays($set, $get);
                    })
                    ->required(),

                TextInput::make('available_days')
                    ->label('Available Leave Days')
                    ->disabled()
                    ->dehydrated(false)
                    ->numeric()
                    ->default(0),

                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->default(auth()->user()->branch_id)
                    ->disabled()
                    ->dehydrated(),

                DatePicker::make('start_date')
                    ->minDate(now()->subDay())
                    ->live()
                    ->required()
                    ->afterStateUpdated(
                        fn ($state, Set $set, Get $get) =>
                            self::calculateDays($set, $get)
                    ),

                DatePicker::make('end_date')
                    ->minDate(now())
                    ->live()
                    ->required()
                    ->afterStateUpdated(
                        fn ($state, Set $set, Get $get) =>
                            self::calculateDays($set, $get)
                    ),

                TextInput::make('days')
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->readOnly(),

                Textarea::make('reason')
                    ->required()
                    ->columnSpanFull(),

                Hidden::make('status')
                    ->default('pending'),
            ]);
    }

    protected static function calculateDays(Set $set, Get $get): void
    {
        $start = $get('start_date');
        $end = $get('end_date');
        $leaveTypeId = $get('leave_type_id');

        /*
         * Calculate requested days.
         */
        if ($start && $end) {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);

            if ($endDate->lt($startDate)) {
                $set('days', null);
            } else {
                $days = $startDate->diffInDays($endDate) + 1;

                $set('days', $days);
            }
        } else {
            $set('days', null);
        }

        /*
         * Calculate available leave balance.
         */
        if (! $leaveTypeId) {
            $set('available_days', 0);
            return;
        }

        $userId = auth()->id();
        $year = now()->year;

        $leaveType = LeaveType::find($leaveTypeId);

        if (! $leaveType) {
            $set('available_days', 0);
            return;
        }

        $entitledDays = (float) $leaveType->days_per_year;

        $carriedForwardDays = (float) (
            LeaveBalance::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveTypeId)
                ->where('year', $year)
                ->value('carried_forward_days') ?? 0
        );

        $usedDays = (float) (
            LeaveRequest::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveTypeId)
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->sum('days')
        );

        $pendingDays = (float) (
            LeaveRequest::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveTypeId)
                ->where('status', 'pending')
                ->whereYear('start_date', $year)
                ->sum('days')
        );

        $availableDays = max(
            0,
            $entitledDays
            + $carriedForwardDays
            - $usedDays
            - $pendingDays
        );

        $set('available_days', $availableDays);
    }
}