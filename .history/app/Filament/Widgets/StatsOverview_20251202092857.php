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
        $thisMonthCount = Post::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $trend = $thisMonthCount > 0 ? "+{$thisMonthCount}" : '0';

        return Stat::make('Posts', number_format($count))
            ->label('Total Posts')
            ->description("{$publishedCount} published ({$publishedPercent}%) — {$trend} this month")
            ->descriptionIcon('heroicon-o-document-text')
            ->color('info')
            ->url(route('filament.admin.resources.posts.index'))
            ->chart(self::getPostTrend());
    }

    private static function categoriesCard(): Stat
    {
        $count = Category::count();
        $postsPerCategory = $count > 0 ? round(Post::count() / $count) : 0;

        return Stat::make('Categories', number_format($count))
            ->label('Total Categories')
            ->description("~{$postsPerCategory} posts per category")
            ->descriptionIcon('heroicon-o-folder')
            ->color('primary')
            ->url(route('filament.admin.resources.categories.index'))
            ->chart(self::getCategoryTrend());
    }

    private static function usersCard(): Stat
    {
        $count = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $adminPercent = $count > 0 ? round(($adminCount / $count) * 100) : 0;
        $thisMonthCount = User::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $trend = $thisMonthCount > 0 ? "+{$thisMonthCount}" : '0';

        return Stat::make('Users', number_format($count))
            ->label('Total Users')
            ->description("{$adminCount} admin(s) ({$adminPercent}%) — {$trend} this month")
            ->descriptionIcon('heroicon-o-users')
            ->color('success')
            ->url(route('filament.admin.resources.users.index'))
            ->chart(self::getUserTrend());
    }

    private static function commentsCard(): Stat
    {
        $count = Comment::count();
        $pendingCount = Comment::where('status', 'pending')->count();
        $pendingPercent = $count > 0 ? round(($pendingCount / $count) * 100) : 0;
        $approvedCount = Comment::where('status', 'approved')->count();

        return Stat::make('Comments', number_format($count))
            ->label('Total Comments')
            ->description("{$approvedCount} approved, {$pendingCount} pending ({$pendingPercent}%)")
            ->descriptionIcon('heroicon-o-chat-bubble-bottom-center-text')
            ->color('warning')
            ->url(route('filament.admin.resources.comments.index'))
            ->chart(self::getCommentTrend());
    }

    /**
     * Get posts trend for the last 10 months
     */
    private static function getPostTrend(): array
    {
        $data = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Post::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    /**
     * Get categories trend for the last 10 months
     */
    private static function getCategoryTrend(): array
    {
        $data = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Category::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    /**
     * Get users trend for the last 10 months
     */
    private static function getUserTrend(): array
    {
        $data = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }

    /**
     * Get comments trend for the last 10 months
     */
    private static function getCommentTrend(): array
    {
        $data = [];
        for ($i = 9; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Comment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $data[] = $count;
        }
        return $data;
    }
