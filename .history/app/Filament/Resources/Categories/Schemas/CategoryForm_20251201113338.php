<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::nameField(),
                self::slugField(),
            ]);
    }

    private static function nameField(): TextInput
    {
        return TextInput::make('name')
            ->label('Name')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn (callable $set, $state) => $set('slug', Str::slug($state)));
    }

    private static function slugField(): TextInput
    {
        return TextInput::make('slug')
            ->label('Slug')
            ->required()
            ->unique(ignoreRecord: true);
    }
}
