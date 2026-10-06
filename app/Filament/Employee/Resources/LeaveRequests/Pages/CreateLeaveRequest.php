<?php

namespace App\Filament\Employee\Resources\LeaveRequests\Pages;

use App\Filament\Employee\Resources\LeaveRequests\LeaveRequestResource;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLeaveRequest extends CreateRecord
{
    protected static string $resource = LeaveRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = auth()->id();
        $year = now()->year;

        $leaveType = LeaveType::find($data['leave_type_id']);

        if (! $leaveType) {
            Notification::make()
                ->title('Invalid Leave Type')
                ->body('The selected leave type could not be found.')
                ->danger()
                ->send();

            $this->halt();
        }

        $carriedForwardDays = (float) (
            LeaveBalance::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveType->id)
                ->where('year', $year)
                ->value('carried_forward_days') ?? 0
        );

        $usedDays = (float) (
            LeaveRequest::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', 'approved')
                ->whereYear('start_date', $year)
                ->sum('days')
        );

        $pendingDays = (float) (
            LeaveRequest::query()
                ->where('user_id', $userId)
                ->where('leave_type_id', $leaveType->id)
                ->where('status', 'pending')
                ->whereYear('start_date', $year)
                ->sum('days')
        );

        $availableDays = max(
            0,
            (float) $leaveType->days_per_year
            + $carriedForwardDays
            - $usedDays
            - $pendingDays
        );

        $requestedDays = (float) ($data['days'] ?? 0);

        if ($requestedDays <= 0) {
            Notification::make()
                ->title('Invalid Leave Duration')
                ->body('Please select a valid start and end date.')
                ->danger()
                ->send();

            $this->halt();
        }

        if ($requestedDays > $availableDays) {
            Notification::make()
                ->title('Insufficient Leave Balance')
                ->body(
                    'You requested ' . $requestedDays . ' day(s), '
                    . 'but only ' . $availableDays . ' day(s) are available '
                    . 'for ' . $leaveType->name . '.'
                )
                ->danger()
                ->send();

            $this->halt();
        }

        /*
         * Never trust employee-submitted user_id or branch_id.
         * Set them from the authenticated employee.
         */
        $data['user_id'] = $userId;
        $data['branch_id'] = auth()->user()->branch_id;

        /*
         * Always create employee leave requests as pending.
         */
        $data['status'] = 'pending';

        return $data;
    }
}