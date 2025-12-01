<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TagsInput;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('thumbnail')
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                ColorPicker::make('color')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                MarkdownEditor::make('content')
                    ->default(null)
                    ->columnSpanFull(),
                TagsInput::make('tags')
                    ->required()
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('published')
                    ->required(),
            ]);
    }
}
