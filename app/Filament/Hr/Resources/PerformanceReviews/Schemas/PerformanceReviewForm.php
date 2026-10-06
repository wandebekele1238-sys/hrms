<?php

namespace App\Filament\Hr\Resources\PerformanceReviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PerformanceReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Reviews Informations")
                ->columns(2)
                ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('reviewer_id')
                    ->relationship('reviewer', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('review_period')
                    ->default(now()->format('Y-m-d'))
                    ->placeholder('Select review period')
                    ->required(),
                ]),
                Section::make("Performance Metrics")
                ->columns(2)
               
                ->schema([
                    TextInput::make('quality_of_work')
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->required()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateOverallRating($set, $get)
                    )
                     ->numeric(),
                    TextInput::make('productivity')
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->required()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateOverallRating($set, $get)
                    )
                     ->numeric(),
                    TextInput::make('communication')
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->required()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateOverallRating($set, $get)
                    )
                     ->numeric(),
                TextInput::make('teamwork')
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->required()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateOverallRating($set, $get)
                    )
                     ->numeric(),
                TextInput::make('leadership')
                    ->minValue(1)
                    ->maxValue(10)
                    ->live()
                    ->required()
                    ->afterStateUpdated( fn($state, Set $set, Get $get)=>
                    self::calculateOverallRating($set, $get)
                    )
                     ->numeric(),
                TextInput::make('overall_rating')
                    ->required()
                    ->suffix('/ 10')
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                
                ]),
                Section::make("Feedback and Goals")
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Textarea::make('strengths')
                    ->columnSpanFull(),
                
                    Textarea::make('areas_for_improvement')
                    ->columnSpanFull(),
                    Textarea::make('goals')
                    ->columnSpanFull(),
                    Textarea::make('comments')
                    ->columnSpanFull(),
                ]),
                
            ]);
    }
    protected static function calculateOverallRating(Set $set, Get $get){
        $qualityOfWork = (int)$get('quality_of_work');
        $productivity = (int)$get('productivity');
        $communication = (int)$get('communication');
        $teamwork = (int)$get('teamwork');
        $leadership = (int)$get('leadership');

       $overallRating = round(
        (
        $qualityOfWork + $productivity + $communication + $teamwork + $leadership) / 5 , 
       2
       );

       $set('overall_rating', $overallRating);
    }
}
