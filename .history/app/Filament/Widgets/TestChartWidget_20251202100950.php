<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Post;

class TestChartWidget extends ChartWidget
{
    protected ?string $heading = 'Test Chart Widget';

    protected function getData(): array
    {

        $data = Post::model(Post::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June'],
            'datasets' => [
                [
                    'label' => 'Test Data',
                    'data' => [10, 20, 15, 30, 25, 40],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
