<?php

namespace App\Filament\Resources\Posts\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use Carbon\Carbon;

class PostOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $count = Post::count();
        $publishedCount = Post::where('published', true)->count();
        $publishedPercent = $count > 0 ? round(($publishedCount / $count) * 100) : 0;

        $thisMonthCount = Post::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $trend = $thisMonthCount > 0 ? "+{$thisMonthCount}" : '0';

        return [
            Stat::make('Posts', number_format($count))
                ->label('Total Posts')
                ->description("{$publishedCount} published ({$publishedPercent}%) — {$trend} this month")
                ->descriptionIcon('heroicon-o-document-text')
                ->color('info')
                // You don't need the URL action here since you are already on the page
                ->chart($this->getPostTrend()),
        ];
    }

    /**
     * Get posts trend for the last 10 months
     */
    private function getPostTrend(): array
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

    public static function canView(): bool
{
    /** @var \App\Models\User $user */
    $user = auth()->user();

    return $user->isAdmin() || $user->isEditor();
}
}
