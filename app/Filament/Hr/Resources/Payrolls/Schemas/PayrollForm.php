<?php

namespace App\Filament\Hr\Resources\Payrolls\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\User;

class PayrollForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->afterStateUpdated( function($state, Set $set){
                        $user = User::find($state);
                        if($user){
                            $set('basic_salary', $user->salary);
                        }
                    }),
                Select::make('month')
                    ->options([
                        'January'=> 'January',
                        'February'=> 'February',
                        'March'=> 'March',
                        'April'=> 'April',
                        'May'=> 'May',
                        'June'=> 'June',
                        'July'=> 'July',
                        'August'=> 'August',
                        'September'=> 'September',
                        'October'=> 'October',
                        'November'=> 'November',
                        'December' =>'December',
                    ])
                    ->required(),
                TextInput::make('year')
                    ->required()
                    ->default(date('Y'))
                    ->numeric(),
                TextInput::make('basic_salary')
                    ->required()
                    ->prefix('ETB')
                    ->live()
                    ->numeric()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateNetSalary($set, $get)
                    ),
                TextInput::make('allowances')
                    ->required()
                    ->prefix('ETB')
                    ->live(onBlur: true)
                    ->numeric()
                    ->default(0.0)
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateNetSalary($set, $get)
                    ),
                TextInput::make('deductions')
                    ->required()
                    ->numeric()
                    ->prefix('ETB')
                    ->live(onBlur: true)
                    ->default(0.0)
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateNetSalary($set, $get)
                    ),
                TextInput::make('bonus')
                    ->required()
                    ->numeric()
                    ->prefix('ETB')
                    ->live(onBlur: true)
                    ->default(0.0)
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateNetSalary($set, $get)
                    ),
                TextInput::make('net_salary')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->prefix('ETB')
                    ->numeric(),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'processed' => 'Processed', 'paid' => 'Paid'])
                    ->default('draft')
                    ->required(),
                DatePicker::make('paid_at'),
            ]);
    }
     protected static function calculateNetSalary(Set $set, Get $get){
        $basic = (float)($get('basic_salary')?? 0);
         $allowances = (float)($get('allowances')?? 0);
          $deductions = (float)($get('deductions')?? 0);
           $bonus = (float)($get('bonus')?? 0);

       $netSalary = $basic+$allowances+$bonus-$deductions;

       $set('net_salary', $netSalary);
    }
}
