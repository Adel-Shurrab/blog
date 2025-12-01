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
                ->label('Total Posts')
                ->description('All time')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary')
                ->url(route('filament.admin.resources.posts.index'))
                ->charts,
            Stat::make('Categories', Category::count())
                ->label('Total Categories')
                ->description('All time')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('secondary')
                ->url(route('filament.admin.resources.categories.index')),
            Stat::make('Users', User::count())
                ->label('Total Users')
                ->description('All time')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('success')
                ->url(route('filament.admin.resources.users.index')),
            Stat::make('Comments', Comment::count())
                ->label('Total Comments')
                ->description('All time')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('warning')
                ->url(route('filament.admin.resources.comments.index')),
        ];
    }
}
