<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Widgets\StatsOverview;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostOverview::class, // Use the specific widget class here
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All posts')
                ->badge($this->getResource()::getEloquentQuery()->count()),
            'published' => Tab::make('Published')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('published', true))
                ->badge($this->getResource()::getEloquentQuery()->where('published', true)->count()),
            'drafts' => Tab::make('Drafts')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('published', false))
                ->badge($this->getResource()::getEloquentQuery()->where('published', false)->count()),
        ];
    }
}
