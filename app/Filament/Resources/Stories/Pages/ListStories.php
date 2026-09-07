<?php

namespace App\Filament\Resources\Stories\Pages;

use App\Filament\Resources\Stories\StoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStories extends ListRecords
{
    protected static string $resource = StoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'waiting for review' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'waiting for review')),
            'in review' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'in review')),
            'approved' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'approved')),
            'canceled' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'canceled')),
            'rework' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'rework')),
        ];
    }
}
