<?php

namespace App\Filament\Resources\Stories\Schemas;

use App\Models\Story;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('story_content')
                    ->columnSpanFull(),
                TextEntry::make('status'),
                TextEntry::make('author_id')
                    ->numeric(),
                TextEntry::make('reviewer_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('feedback')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Story $record): bool => $record->trashed()),
            ]);
    }
}
