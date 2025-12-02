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
        // Example data generation using Flowframe Trend package
        $data = Trend::model(Post::class)
            ->between(
                start: now()->subMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
            'datasets' => [
                [
                    'label' => 'Posts Created',
                    'data' => $data->map(fn(TrendValue $value) => $value->date),
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
