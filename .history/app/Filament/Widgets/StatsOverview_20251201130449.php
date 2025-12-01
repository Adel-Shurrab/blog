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
        $count = Post::count();
        $publishedCount = Post::where('published', true)->count();

        return Stat::make('Posts', $count)
            ->label('Total Posts')
            ->description(sprintf('%d published', $publishedCount))
            ->descriptionIcon('heroicon-m-document-text')
            ->color('primary')
            ->url(route('filament.admin.resources.posts.index'))
            ->chart([1, 3, 5, 7, 9, 8, 6, 4, 2, 0]);
    }

    private static function categoriesCard(): Stat
    {
        $count = Category::count();

        return Stat::make('Categories', $count)
            ->label('Total Categories')
            ->description('Content organization')
            ->descriptionIcon('heroicon-m-folder')
            ->color('secondary')
            ->url(route('filament.admin.resources.categories.index'));
    }

    private static function usersCard(): Stat
    {
        $count = User::count();
        $adminCount = User::where('role', 'admin')->count();

        return Stat::make('Users', $count)
            ->label('Total Users')
            ->description(sprintf('%d admin(s)', $adminCount))
            ->descriptionIcon('heroicon-m-users')
            ->color('success')
            ->url(route('filament.admin.resources.users.index'));
    }

    private static function commentsCard(): Stat
    {
        $count = Comment::count();
        $pendingCount = Comment::where('status', 'pending')->count();

        return Stat::make('Comments', $count)
            ->label('Total Comments')
            ->description(sprintf('%d pending moderation', $pendingCount))
            ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
            ->color('warning')
            ->url(route('filament.admin.resources.comments.index'));
    }
}
