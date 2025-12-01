<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('slug'),
                CheckboxColumn::make('published'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                BulkActionGroup([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Post Details')
                    ->description('Configure your post content and metadata.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->minLength(4)
                            ->maxLength(30)
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter post title'),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255)
                            ->placeholder('URL-friendly title')
                            ->hint('Leave blank to auto-generate from title'),
                        ColorPicker::make('color')
                            ->label('Post Color')
                            ->required(),
                        MarkdownEditor::make('content')
                            ->label('Content')
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1)->collapsible(),

                Group::make()->schema([
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
                        ])->collapsible(),
                    TagsInput::make('tags')
                        ->label('Tags')
                        ->required()
                        ->placeholder('Add tags separated by commas'),
                    Checkbox::make('published')
                        ->label('Publish')
                        ->default(false)
                        ->columnSpan(1),
                ]),

            ]);
    }
}
