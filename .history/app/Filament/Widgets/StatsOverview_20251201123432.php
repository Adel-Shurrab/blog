<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Posts')
                ->label('Total Posts')
                ->value(\App\Models\Post::count()),
            Stat::make('Categories')
                ->label('Total Categories')
                ->value(\App\Models\Category::count()),
            Stat::make('Users')
                ->label('Total Users')
                ->value(\App\Models\User::count()),
            Stat::make('Comments')
                ->label('Total Comments')
                ->value(\App\Models\Comment::count()),
        ];
    }
}
