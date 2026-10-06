<?php

namespace App\Filament\Hr\Resources\LeaveBalances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeaveBalancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('leaveType.name')
                    ->searchable(),
                TextColumn::make('year'),
                TextColumn::make('entitled_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carried_forward_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('used_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pending_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('remaining_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
