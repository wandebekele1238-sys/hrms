<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
 use Filament\Forms\Components\Select;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->unique(ignoreRecord: true)
                    ->default(null),
                TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->default(null),
                Select::make('manager_id')
                    ->relationship('manager', 'name')
                    ->searchable()
                    ->preload()
                    ->default(null),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
                
            ]);
    }
}
