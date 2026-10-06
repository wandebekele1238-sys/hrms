<?php

namespace App\Filament\Resources\LeaveBalances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class LeaveBalanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
    ->label('Employee')
    ->relationship('user', 'name')
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(function (Get $get, Set $set): void {
        $userId = $get('user_id');
        $leaveTypeId = $get('leave_type_id');

        if (! $userId || ! $leaveTypeId) {
            $set('used_days', 0);
            $set('pending_days', 0);
            $set('remaining_days', 0);
            return;
        }

        $leaveRequests = \App\Models\LeaveRequest::query()
            ->where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId);

        $usedDays = (clone $leaveRequests)
            ->where('status', 'approved')
            ->sum('days');

        $pendingDays = (clone $leaveRequests)
            ->where('status', 'pending')
            ->sum('days');

        $entitledDays = (float) ($get('entitled_days') ?? 0);
        $carriedForwardDays = (float) ($get('carried_forward_days') ?? 0);

        $remainingDays = max(
            0,
            $entitledDays + $carriedForwardDays - $usedDays - $pendingDays
        );

        $set('used_days', $usedDays);
        $set('pending_days', $pendingDays);
        $set('remaining_days', $remainingDays);
    })
    ->required(),

                Select::make('leave_type_id')
    ->label('Leave Type')
    ->relationship('leaveType', 'name')
    ->searchable()
    ->preload()
    ->live()
    ->afterStateUpdated(function (Get $get, Set $set): void {
        $leaveTypeId = $get('leave_type_id');

        if (! $leaveTypeId) {
            $set('entitled_days', 0);
            $set('used_days', 0);
            $set('pending_days', 0);
            $set('remaining_days', 0);
            return;
        }

        $leaveType = \App\Models\LeaveType::find($leaveTypeId);

        $entitledDays = (float) ($leaveType?->days_per_year ?? 0);

        $set('entitled_days', $entitledDays);

        $userId = $get('user_id');

        if (! $userId) {
            $set('used_days', 0);
            $set('pending_days', 0);
            $set(
                'remaining_days',
                $entitledDays + (float) ($get('carried_forward_days') ?? 0)
            );

            return;
        }

        $leaveRequests = \App\Models\LeaveRequest::query()
            ->where('user_id', $userId)
            ->where('leave_type_id', $leaveTypeId);

        $usedDays = (clone $leaveRequests)
            ->where('status', 'approved')
            ->sum('days');

        $pendingDays = (clone $leaveRequests)
            ->where('status', 'pending')
            ->sum('days');

        $carriedForwardDays = (float) ($get('carried_forward_days') ?? 0);

        $remainingDays = max(
            0,
            $entitledDays + $carriedForwardDays - $usedDays - $pendingDays
        );

        $set('used_days', $usedDays);
        $set('pending_days', $pendingDays);
        $set('remaining_days', $remainingDays);
    })
    ->required(),

                TextInput::make('year')
                    ->label('Year')
                    ->numeric()
                    ->minValue(2020)
                    ->maxValue(2100)
                    ->default(now()->year)
                    ->required(),

                TextInput::make('entitled_days')
                   ->label('Entitled Days')
                   ->numeric()
                   ->minValue(0)
                   ->disabled()
                  ->dehydrated()
                  ->default(0)
                  ->required(),

                TextInput::make('carried_forward_days')
                    ->label('Carried Forward Days')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),

                TextInput::make('used_days')
    ->label('Used Days')
    ->numeric()
    ->minValue(0)
    ->disabled()
    ->dehydrated()
    ->default(0),

               TextInput::make('pending_days')
    ->label('Pending Days')
    ->numeric()
    ->minValue(0)
    ->disabled()
    ->dehydrated()
    ->default(0),

                TextInput::make('remaining_days')
    ->label('Remaining Days')
    ->numeric()
    ->minValue(0)
    ->disabled()
    ->dehydrated()
    ->default(0),
            ]);
    }
}