<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Posts\Widgets\PostOverview;
use App\Models\User;

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
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Only return the widget if the user is Admin or Editor
        if ($user->isAdmin() || $user->isEditor()) {
            return [
                PostOverview::class,
            ];
        }

        // Otherwise return an empty array (no widgets)
        return [];
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
