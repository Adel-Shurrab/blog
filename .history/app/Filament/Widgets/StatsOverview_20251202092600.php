<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
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
        $publishedPercent = $count > 0 ? round(($publishedCount / $count) * 100) : 0;

        return Stat::make('Posts', number_format($count))
            ->label('Total Posts')
            ->description("{$publishedCount} published ({$publishedPercent}%)")
            ->descriptionIcon('heroicon-o-document-text')
            ->color('info')
            ->url(route('filament.admin.resources.posts.index'))
            ->chart(self::generateChart($count));
    }

    private static function categoriesCard(): Stat
    {
        $count = Category::count();

        return Stat::make('Categories', number_format($count))
            ->label('Total Categories')
            ->description('Organize your content')
            ->descriptionIcon('heroicon-o-folder')
            ->color('primary')
            ->url(route('filament.admin.resources.categories.index'))
            ->chart(self::generateChart($count));
    }

    private static function usersCard(): Stat
    {
        $count = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $adminPercent = $count > 0 ? round(($adminCount / $count) * 100) : 0;

        return Stat::make('Users', number_format($count))
            ->label('Total Users')
            ->description("{$adminCount} admin(s) ({$adminPercent}%)")
            ->descriptionIcon('heroicon-o-users')
            ->color('success')
            ->url(route('filament.admin.resources.users.index'))
            ->chart(self::generateChart($count));
    }

    private static function commentsCard(): Stat
    {
        $count = Comment::count();
        $pendingCount = Comment::where('status', 'pending')->count();
        $pendingPercent = $count > 0 ? round(($pendingCount / $count) * 100) : 0;

        return Stat::make('Comments', number_format($count))
            ->label('Total Comments')
            ->description("{$pendingCount} pending ({$pendingPercent}%)")
            ->descriptionIcon('heroicon-o-chat-bubble-bottom-center-text')
            ->color('warning')
            ->url(route('filament.admin.resources.comments.index'))
            ->chart(self::generateChart($count));
    }

    /**
     * Generate chart data for stats cards
     */
    private static function generateChart(int $count): array
    {
        // Simulate a trend chart with random but smooth data
        $base = max(1, $count - 5);
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = $base + rand(0, 5);
        }
        return $data;
    }
}
