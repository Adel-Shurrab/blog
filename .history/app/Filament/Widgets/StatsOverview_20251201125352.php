<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            self::postsCard(),
            self::categoriesCard(),
            self::usersCard(),
            self::commentsCard(),
        ];
    }

    private static function postsCard(): Stat
    {
        return Stat::make('Posts', Post::count())
            ->label('Total Posts')
            ->description('All time')
            ->descriptionIcon('heroicon-o-calendar')
            ->color('primary')
            ->url(route('filament.admin.resources.posts.index'))
            ->chart([1]);
    }

    private static function categoriesCard(): Stat
    {
        return Stat::make('Categories', Category::count())
            ->label('Total Categories')
            ->description('All time')
            ->descriptionIcon('heroicon-o-folder')
            ->color('secondary')
            ->url(route('filament.admin.resources.categories.index'));
    }

    private static function usersCard(): Stat
    {
        return Stat::make('Users', User::count())
            ->label('Total Users')
            ->description('All time')
            ->descriptionIcon('heroicon-o-users')
            ->color('success')
            ->url(route('filament.admin.resources.users.index'));
    }

    private static function commentsCard(): Stat
    {
        return Stat::make('Comments', Comment::count())
            ->label('Total Comments')
            ->description('All time')
            ->descriptionIcon('heroicon-o-chat-bubble-bottom-center-text')
            ->color('warning')
            ->url(route('filament.admin.resources.comments.index'));
    }
}
