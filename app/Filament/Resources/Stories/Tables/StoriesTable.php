<?php

namespace App\Filament\Resources\Stories\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use App\Models\Story;
use App\Filament\Resources\Stories\StoryResource;

class StoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('author.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('reviewer.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn() => auth()->user()->hasRole('Admin'))
                    ->requiresConfirmation()
                    ->successNotificationTitle('Story deleted succesfully')
                    ->failureNotificationTitle('Failed to delete story'),
                Action::make('review')
                    ->label('review')
                    ->icon('heroicon-o-pencil-square')
                    ->visible(fn(Story $record) => auth()->user()->hasRole('Reviewer') && $record->status === 'waiting for review')
                    ->requiresConfirmation()
                    ->action(function (Story $record) {
                        $record->update(['status' => 'in review']);
                        return redirect(StoryResource::getUrl('view', ['record' => $record]));
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ])
                    ->visible(fn() => auth()->user()->hasRole('Admin')),
            ]);
    }
}
