<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Posts', Post::count())
                ->label('Total Posts'),
            Stat::make('Categories',Category::count())
                ->label('Total Categories'),
            Stat::make('Users',User::count())
                ->label('Total Users'),
            Stat::make('Comments', Comment::count())
                ->label('Total Comments'),
        ];
    }
}
