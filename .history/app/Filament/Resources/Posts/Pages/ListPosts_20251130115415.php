<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All posts')
                ->count($this->getResource()::getEloquentQuery()->count()),
            'published' => Tab::make('Published')
                ->count($this->getResource()::getEloquentQuery()->whereNotNull('published_at')->count()),
            'drafts' => Tab::make('Drafts')
                ->count($this->getResource()::getEloquentQuery()->whereNull('published_at')->count()),
        ];
    }
}
