<?php

namespace App\Filament\Hr\Resources\LeaveBalances;

use App\Filament\Hr\Resources\LeaveBalances\Pages\CreateLeaveBalance;
use App\Filament\Hr\Resources\LeaveBalances\Pages\EditLeaveBalance;
use App\Filament\Hr\Resources\LeaveBalances\Pages\ListLeaveBalances;
use App\Filament\Hr\Resources\LeaveBalances\Schemas\LeaveBalanceForm;
use App\Filament\Hr\Resources\LeaveBalances\Tables\LeaveBalancesTable;
use App\Models\LeaveBalance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeaveBalanceResource extends Resource
{
    protected static ?string $model = LeaveBalance::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return LeaveBalanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeaveBalancesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeaveBalances::route('/'),
            'create' => CreateLeaveBalance::route('/create'),
            'edit' => EditLeaveBalance::route('/{record}/edit'),
        ];
    }
}
