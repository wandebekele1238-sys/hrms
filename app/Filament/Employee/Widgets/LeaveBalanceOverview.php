<?php

namespace App\Filament\Employee\Widgets;

use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Filament\Widgets\Widget;
use Illuminate\Support\Collection;

class LeaveBalanceOverview extends Widget
{
    protected string $view = 'filament.employee.widgets.leave-balance-overview';

    protected int|string|array $columnSpan = 'full';

    public function getLeaveBalances(): Collection
    {
        $userId = auth()->id();
        $year = now()->year;

        return LeaveType::query()
            ->orderBy('name')
            ->get()
            ->map(function (LeaveType $leaveType) use ($userId, $year) {

                /*
                 * Entitled days come directly from Leave Type.
                 */
                $entitledDays = (float) $leaveType->days_per_year;

                /*
                 * Approved leave = used days.
                 */
                $usedDays = (float) (
                    LeaveRequest::query()
                        ->where('user_id', $userId)
                        ->where('leave_type_id', $leaveType->id)
                        ->where('status', 'approved')
                        ->whereYear('start_date', $year)
                        ->sum('days')
                );

                /*
                 * Pending leave is temporarily reserved.
                 */
                $pendingDays = (float) (
                    LeaveRequest::query()
                        ->where('user_id', $userId)
                        ->where('leave_type_id', $leaveType->id)
                        ->where('status', 'pending')
                        ->whereYear('start_date', $year)
                        ->sum('days')
                );

                /*
                 * Remaining balance.
                 */
                $remainingDays = max(
                    0,
                    $entitledDays
                    - $usedDays
                    - $pendingDays
                );

                return [
                    'id' => $leaveType->id,
                    'name' => $leaveType->name,
                    'entitled_days' => $entitledDays,
                    'used_days' => $usedDays,
                    'pending_days' => $pendingDays,
                    'remaining_days' => $remainingDays,
                ];
            });
    }
}