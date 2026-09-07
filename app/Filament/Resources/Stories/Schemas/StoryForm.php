<?php

namespace App\Filament\Resources\Stories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('story_content')
                    ->required()
                    ->rows(10)
                    ->columnSpanFull(),
                // TextInput::make('status')
                //     ->required()
                //     ->default('waiting for review'),
                // TextInput::make('author_id')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('reviewer_id')
                //     ->numeric()
                //     ->default(null),
                // Textarea::make('feedback')
                //     ->default(null)
                //     ->columnSpanFull(),
            ]);
    }
}
