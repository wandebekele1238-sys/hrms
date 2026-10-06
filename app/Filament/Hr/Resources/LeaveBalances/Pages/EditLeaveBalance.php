<?php

namespace App\Filament\Hr\Resources\LeaveBalances\Pages;

use App\Filament\Hr\Resources\LeaveBalances\LeaveBalanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeaveBalance extends EditRecord
{
    protected static string $resource = LeaveBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
