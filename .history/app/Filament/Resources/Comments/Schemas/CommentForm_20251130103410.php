<?php

namespace App\Filament\Resources\Comments\Schemas;

use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('User'),
                TextInput::make('comment')
                    ->label('Comment')
                    ->required()
                    ->maxLength(1000),
                MorphToSelect::make('commentable')
                
            ]);
    }
}
