<?php

namespace App\Filament\Resources\Comments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['commentable']))
            ->columns([
                self::commentColumn(),
                self::userColumn(),
                self::commentableColumn(),
                self::statusColumn(),
                self::createdAtColumn(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Dele
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    private static function commentColumn(): TextColumn
    {
        return TextColumn::make('comment')
            ->label('Comment')
            ->limit(50)
            ->wrap()
            ->sortable()
            ->searchable();
    }

    private static function userColumn(): TextColumn
    {
        return TextColumn::make('user.name')
            ->label('User')
            ->sortable()
            ->searchable();
    }

    private static function commentableColumn(): TextColumn
    {
        return TextColumn::make('commentable_type')
            ->label('Commented On')
            ->formatStateUsing(function ($record) {
                $commentable = $record->commentable;

                if ($commentable instanceof \App\Models\Post) {
                    return $commentable->title;
                } elseif ($commentable instanceof \App\Models\User) {
                    return $commentable->email;
                } elseif ($commentable instanceof \App\Models\Comment) {
                    return 'Comment #' . $commentable->id;
                }

                return 'Unknown';
            })
            ->sortable()
            ->searchable();
    }

    private static function createdAtColumn(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label('Commented At')
            ->dateTime('Y-m-d H:i')
            ->sortable();
    }

    private static function statusColumn(): TextColumn
    {
        return TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->color(fn(string $state) => match ($state) {
                'pending' => 'warning',
                'approved' => 'success',
                'rejected' => 'danger',
                default => 'gray',
            })
            ->formatStateUsing(fn(string $state) => ucfirst($state))
            ->sortable();
    }
}
