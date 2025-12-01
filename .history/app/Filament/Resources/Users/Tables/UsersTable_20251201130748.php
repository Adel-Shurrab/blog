<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
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
            self::emailColumn(),
            self::roleColumn(),
            self::emailVerifiedAtColumn(),
            self::createdAtColumn(),
            self::updatedAtColumn(),
        ];
    }

    private static function nameColumn(): TextColumn
    {
        return TextColumn::make('name')
            ->searchable()
            ->sortable();
    }

    private static function emailColumn(): TextColumn
    {
        return TextColumn::make('email')
            ->label('Email Address')
            ->searchable()
            ->sortable();
    }

    private static function roleColumn(): TextColumn
    {
        return TextColumn::make('role')
            ->label('Role')
            ->formatStateUsing(fn(string $state) => ucfirst($state))
            ->badge()
            ->color(fn(string $state) => match ($state) {
                'admin' => 'danger',
                'editor' => 'warning',
                'author' => 'info',
                default => 'gray',
            })
            ->searchable();
    }

    private static function emailVerifiedAtColumn(): TextColumn
    {
        return TextColumn::make('email_verified_at')
            ->label('Email Verified At')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
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
