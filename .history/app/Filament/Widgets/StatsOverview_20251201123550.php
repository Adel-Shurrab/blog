<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;


class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Posts', Post::count())
                ->label('Total Posts'),
            Stat::make('Categories', \App\Models\Category::count())
                ->label('Total Categories'),
            Stat::make('Users', \App\Models\User::count())
                ->label('Total Users'),
            Stat::make('Comments', \App\Models\Comment::count())
                ->label('Total Comments'),
        ];
    }
}
