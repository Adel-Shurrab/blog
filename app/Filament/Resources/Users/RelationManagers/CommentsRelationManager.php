<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('comment')
                    ->label('Comment')
                    ->required()
                    ->maxLength(1000),
                MorphToSelect::make('commentable')
                    ->label('Commented On')
                    ->types([
                        Type::make(Post::class)->titleAttribute('title'),
                        Type::make(User::class)->titleAttribute('email'),
                        Type::make(Comment::class)->titleAttribute('id'),
                    ])
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50)
                    ->wrap()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('commentable_type')
                    ->label('Commented On')
                    ->formatStateUsing(function ($record) {
                        $commentable = $record->commentable;
                        
                        if ($commentable instanceof Post) {
                            return $commentable->title;
                        } elseif ($commentable instanceof User) {
                            return $commentable->email;
                        } elseif ($commentable instanceof Comment) {
                            return 'Comment #' . $commentable->id;
                        }
                        
                        return 'Unknown';
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Commented At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
