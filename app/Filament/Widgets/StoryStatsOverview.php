<?php

namespace App\Filament\Widgets;

use App\Models\Story;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoryStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Waiting for Review', Story::where('status', 'waiting for review')->when(auth()->user()->hasRole('Writer'), function ($query) {
                $query->where('author_id', auth()->user()->id);
            })->count()),
            Stat::make('in review', Story::where('status', 'in review')->when(auth()->user()->hasRole('Writer'), function ($query) {
                $query->where('author_id', auth()->user()->id);
            })->count()),
            Stat::make('approved', Story::where('status', 'approved')->when(auth()->user()->hasRole('Writer'), function ($query) {
                $query->where('author_id', auth()->user()->id);
            })->count()),
            Stat::make('canceled', Story::where('status', 'canceled')->when(auth()->user()->hasRole('Writer'), function ($query) {
                $query->where('author_id', auth()->user()->id);
            })->count()),
            Stat::make('rework', Story::where('status', 'rework')->when(auth()->user()->hasRole('Writer'), function ($query) {
                $query->where('author_id', auth()->user()->id);
            })->count()),
        ];
    }
}
