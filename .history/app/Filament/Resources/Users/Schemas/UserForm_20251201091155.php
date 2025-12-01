<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                self::nameField(),
                self::emailField(),
                self::roleField(),
                self::passwordField(),
            ]);
    }

    private static function nameField(): TextInput
    {
        return TextInput::make('name')
            ->required();
    }

    private static function emailField(): TextInput
    {
        return TextInput::make('email')
            ->label('Email Address')
            ->email()
            ->required();
    }

    private static function roleField(): Select
    {
        return Select::make('role')
            ->label('Role')
            ->options([
                User::ROLE_ADMIN => 'Admin',
                User::ROLE_EDITOR => 'Editor',
                User::ROLE_AUTHOR => 'Author',
            ])
            ->required()
            ->default(User::ROLE_AUTHOR);
    }

    private static function passwordField(): TextInput
    {
        return TextInput::make('password')
            ->password()
            ->required()
            ->visibleOn('create');
    }
}
