<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Exports\UserExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\Exports\Enums\ExportFormat;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(self::getColumns())
            ->filters(self::getFilters())
            ->recordActions(self::getRecordActions())
            ->toolbarActions(self::getToolbarActions())
            ->headerActions([
                ExportAction::make('export')
                    ->exporter(UserExporter::class),
            ]);
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
            self::roleFilter(),
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
            ExportBulkAction::make()
                ->exporter(UserExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ]),
        ];
    }

    private static function roleFilter(): SelectFilter
    {
        return SelectFilter::make('role')
            ->label('Filter by Role')
            ->options([
                'admin' => 'Admin',
                'editor' => 'Editor',
                'author' => 'Author',
            ]);
    }
}
