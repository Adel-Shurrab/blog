<?php

namespace App\Filament\Resources\Comments\Schemas;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::userField(),
                self::commentField(),
                self::commentableField(),
            ]);
    }

    private static function userField(): Select
    {
        return Select::make('user_id')
            ->relationship('user', 'name')
            ->label('User')
            ->searchable()
            ->preload()
            ->required();
    }

    private static function commentField(): TextInput
    {
        return TextInput::make('comment')
            ->label('Comment')
            ->required()
            ->maxLength(1000);
    }

    private static function commentableField(): MorphToSelect
    {
        return MorphToSelect::make('commentable')
            ->label('Commented On')
            ->types([
                Type::make(Post::class)->titleAttribute('title'),
                Type::make(User::class)->titleAttribute('email'),
                Type::make(Comment::class)->titleAttribute('id'),
            ])
            ->searchable()
            ->preload()
            ->required();
    }
}
