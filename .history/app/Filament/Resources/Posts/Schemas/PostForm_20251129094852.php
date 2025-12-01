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
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;


class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make('Post Details')
                    ->description('Configure your post content and metadata.')
                    ->schema([
                        Group
                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter post title'),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('URL-friendly title')
                            ->hint('Leave blank to auto-generate from title'),
                        Select::make('category_id')
                            ->label('Category')
                            ->options(Category::query()->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        ColorPicker::make('color')
                            ->label('Post Color')
                            ->required(),
                        MarkdownEditor::make('content')
                            ->label('Content')
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),

                Section::make('Media & Publishing')
                    ->description('Upload thumbnail and configure publishing options.')
                    ->schema([
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->disk('public')
                            ->directory('thumbnails')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->maxSize(5120)
                            ->placeholder('Upload a thumbnail image'),
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->required()
                            ->placeholder('Add tags separated by commas'),
                        Checkbox::make('published')
                            ->label('Publish')
                            ->default(false),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
