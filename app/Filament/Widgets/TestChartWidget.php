<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TestChartWidget extends ChartWidget
{
    protected ?string $heading = 'Test Chart Widget';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
