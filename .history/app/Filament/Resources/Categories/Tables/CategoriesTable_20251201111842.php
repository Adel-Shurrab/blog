<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->filters(self::getFilters())
            ->recordActions(self::getRecordActions())
            ->toolbarActions(self::getToolbarActions());
    }

    private static function getColumns(): array
    {
        return [
            self::nameColumn(),
            self::slugColumn(),
            self::createdAtColumn(),
            self::updatedAtColumn(),
            self::deletedAtColumn(),
        ];
    }

    private static function nameColumn(): TextColumn
    {
        return TextColumn::make('name')
            ->searchable()
            ->sortable();
    }

    private static function slugColumn(): TextColumn
    {
        return TextColumn::make('slug')
            ->searchable()
            ->sortable();
    }

    private static function createdAtColumn(): TextColumn
    {
        return TextColumn::make('created_at')
            ->label('Created At')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    private static function updatedAtColumn(): TextColumn
    {
        return TextColumn::make('updated_at')
            ->label('Updated At')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    private static function deletedAtColumn(): TextColumn
    {
        return TextColumn::make('deleted_at')
            ->label('Deleted At')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
    }

    private static function getFilters(): array
    {
        return [
            //
        ];
    }

    private static function getRecordActions(): array
    {
        return [
            EditAction::make(),
            De
        ];
    }

    private static function getToolbarActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
