<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                self::contentSection(),
                self::publishingSection(),
            ]);
    }

    private static function contentSection(): Section
    {
        return Section::make('Post Details')
            ->description('Configure your post content and metadata.')
            ->schema([
                Tabs::make('Create New Post')
                    ->tabs([
                        self::contentTab(),
                        self::bodyTab(),
                        self::mediaTab(),
                    ])->pre,
            ])
            ->columnSpan(1)
            ->collapsible();
    }

    private static function contentTab(): Tab
    {
        return Tab::make('Content')
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->minLength(4)
                    ->maxLength(255)
                    ->placeholder('Enter post title'),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
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
            ]);
    }

    private static function bodyTab(): Tab
    {
        return Tab::make('Body')
            ->schema([
                MarkdownEditor::make('content')
                    ->label('Content')
                    ->columnSpanFull(),
            ]);
    }

    private static function mediaTab(): Tab
    {
        return Tab::make('Media')
            ->schema([
                FileUpload::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->directory('thumbnails')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9')
                    ->maxSize(5120)
                    ->placeholder('Upload a thumbnail image (max 5MB)'),
            ]);
    }

    private static function publishingSection(): Group
    {
        return Group::make()
            ->schema([
                Section::make('Publishing Options')
                    ->description('Configure publishing details and metadata.')
                    ->schema([
                        TagsInput::make('tags')
                            ->label('Tags')
                            ->required()
                            ->placeholder('Add tags separated by commas'),
                        self::authorsSection(),
                        Checkbox::make('published')
                            ->label('Publish this post')
                            ->default(false),
                    ]),
            ]);
    }

    private static function authorsSection(): Section
    {
        return Section::make('Authors')
            ->collapsible()
            ->schema([
                Select::make('authors')
                    ->label('Select Authors')
                    ->multiple()
                    ->relationship('authors', 'name')
                    ->preload()
                    ->required(),
            ]);
    }
}
