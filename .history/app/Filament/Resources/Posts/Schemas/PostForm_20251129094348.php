<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Create a Post')
                    ->description('create posts over here.')
                    // ->icon('')
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        Select::make('category_id')
                            ->label('Category')
                            ->options(Category::query()->pluck('name', 'id'))
                            ->searchable(),
                        ColorPicker::make('color')
                            ->required(),
                        MarkdownEditor::make('content')
                            ->default(null)
                            ->columnSpanFull(),
                    ])->columnSpan(1),

                Section::make()
                    ->description()
                    ->schema([
                        FileUpload::make('thumbnail')
                    ->disk('public')
                    ->directory('thumbnails')
                    ->default(null),
                TagsInput::make('tags')
                    ->required()
                    ->default(null),
                Checkbox::make('published')
                    ->required(),
                    ]),

                
            ]);
    }
}
