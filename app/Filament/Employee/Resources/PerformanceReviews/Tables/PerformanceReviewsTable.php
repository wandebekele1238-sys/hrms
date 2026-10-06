<?php

namespace App\Filament\Employee\Resources\PerformanceReviews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PerformanceReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(function(Builder $query){
            return $query->where('user_id', auth()->user()->id);
        })
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('approver.name')
                    ->searchable(),
                TextColumn::make('review_period')
                    ->searchable(),
                TextColumn::make('quality_of_work')
                    ->numeric()
                    ->suffix('/10')
                    ->sortable(),
                TextColumn::make('productivity')
                    ->numeric()
                    ->sortable()
                    ->suffix('/10'),
                TextColumn::make('communication')
                    ->numeric()
                    ->sortable()
                    ->suffix('/10'),
                TextColumn::make('teamwork')
                    ->numeric()
                    ->sortable()
                    ->suffix('/10'),
                TextColumn::make('leadership')
                    ->numeric()
                    ->sortable()
                    ->suffix('/10'),
                TextColumn::make('overall_rating')
                    ->badge()
                    ->colors([
                        'success' => fn ($state): bool => $state >= 7,
                        'warning' => fn ($state): bool => $state >= 5 && $state < 7,
                        'danger' => fn ($state): bool => $state < 5,
                    ])
                    ->sortable()
                    ->suffix('/10'),
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
                ViewAction::make(),
                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                
                ]),
            ]);
    }
}
