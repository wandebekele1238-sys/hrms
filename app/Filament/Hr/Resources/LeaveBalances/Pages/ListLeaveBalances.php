<?php

namespace App\Filament\Hr\Resources\LeaveBalances\Pages;

use App\Filament\Hr\Resources\LeaveBalances\LeaveBalanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeaveBalances extends ListRecords
{
    protected static string $resource = LeaveBalanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
