<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['authors', 'category', 'tags']))
            ->columns(self::getColumns())
            ->filters(self::getFilters())
            ->recordActions(self::getRecordActions())
            ->toolbarActions(self::getToolbarActions())
            ->emptyStateHeading('No posts found')
            ->emptyStateDescription('Get started by creating your first blog post.')
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    private static function getColumns(): array
    {
        return [
            self::thumbnailColumn(),
            self::colorColumn(),
            self::titleColumn(),
            self::slugColumn(),
            self::authorsColumn(),
            self::categoryColumn(),
            self::tagsColumn(),
            self::publishedColumn(),
            self::createdAtColumn(),
            self::updatedAtColumn(),
            self::deletedAtColumn(),
        ];
    }

    private static function thumbnailColumn(): ImageColumn
    {
        return ImageColumn::make('thumbnail')
            ->disk('public')
            ->label('Thumbnail')
            ->size(40)
            ->toggleable();
    }

    private static function colorColumn(): ColorColumn
    {
        return ColorColumn::make('color')
            ->toggleable();
    }

    private static function titleColumn(): TextColumn
    {
        return TextColumn::make('title')
            ->searchable()
            ->sortable()
            ->toggleable();
    }

    private static function slugColumn(): TextColumn
    {
        return TextColumn::make('slug')
            ->searchable()
            ->sortable()
            ->toggleable();
    }

    private static function authorsColumn(): TextColumn
    {
        return TextColumn::make('authors.name')
            ->label('Authors')
            ->toggleable();
    }

    private static function categoryColumn(): TextColumn
    {
        return TextColumn::make('category.name')
            ->label('Category')
            ->badge()
            ->sortable()
            ->searchable()
            ->toggleable();
    }

    private static function tagsColumn(): TextColumn
    {
        return TextColumn::make('tags')
            ->label('Tags')
            ->formatStateUsing(function ($state) {
                if (!is_array($state) || empty($state)) {
                    return '—';
                }
                return implode(', ', $state);
            })
            ->toggleable();
    }

    private static function publishedColumn(): CheckboxColumn
    {
        return CheckboxColumn::make('published')
            ->toggleable();
    }

    private static function createdAtColumn(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label('Published on')
            ->date()
            ->sortable()
            ->searchable()
            ->toggleable();
    }

    private static function updatedAtColumn(): TextColumn
    {
        return TextColumn::make('updated_at')
            ->label('Updated at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    private static function deletedAtColumn(): TextColumn
    {
        return TextColumn::make('deleted_at')
            ->label('Deleted at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    private static function getFilters(): array
    {
        return [
            TernaryFilter::make('published'),
            SelectFilter::make('category_id')
                ->relationship('category', 'name')
                ->label('Category')
                ->multiple()
                ->searchable()
                ->preload(),
        ];
    }

    private static function getRecordActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    private static function getToolbarActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ])->label('Actions'),
        ];
    }
}
