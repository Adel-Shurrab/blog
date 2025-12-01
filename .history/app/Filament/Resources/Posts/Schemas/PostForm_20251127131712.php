<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                MarkdownEditor::make('content')
                    ->default(null)
                    ->columnSpanFull(),
                    
                ColorPicker::make('color')
                    ->required(),
                TagsInput::make('tags')
                    ->required()
                    ->default(null)
                    ->columnSpanFull(),
                Checkbox::make('published')
                    ->required(),
                TextInput::make('thumbnail')
                    ->default(null),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
