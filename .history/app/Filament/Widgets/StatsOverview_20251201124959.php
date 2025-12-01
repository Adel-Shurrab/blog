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
                ->charts([
                    'type' => 'bar',
                    'data' => [
                        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        'datasets' => [
                            [
                                'label' => 'Posts Created',
                                'data' => [5, 10, 8, 12, 15, 20, 18, 22, 25, 30, 28, 35],
                                'backgroundColor' => 'rgba(59, 130, 246, 0.7)',
                            ],
                        ],
                    ],
                ]),
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
