<?php

namespace App\Filament\Resources\Stories\Pages;

use App\Filament\Resources\Stories\StoryResource;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewStory extends ViewRecord
{
    protected static string $resource = StoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('approve')
                ->color('success')
                ->label('Approve')
                ->visible(fn() => auth()->user()->hasRole('Reviewer') && $this->record->status === 'in review' && $this->record->reviewer_id === auth()->id())
                ->form([
                    \Filament\Forms\Components\TextArea::make('feedback')
                        ->label('feedback')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => 'approved', 'feedback' => $data['feedback']]);
                    // $this->notify('success', 'Story approved successfully');
                }),
            Action::make('cancel')
                ->color('danger')
                ->label('Cancel')
                ->visible(fn() => auth()->user()->hasRole('Reviewer') && $this->record->status === 'in review' && $this->record->reviewer_id === auth()->id())
                ->form([
                    \Filament\Forms\Components\TextArea::make('feedback')
                        ->label('feedback')
                        ->required()
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => 'cancel', 'feedback' => $data['feedback']]);
                    // $this->notify('success', 'Story cancel successfully');
                }),

            Action::make('rework')
                ->color('info')
                ->label('Rework')
                ->visible(fn() => auth()->user()->hasRole('Reviewer') && $this->record->status === 'in review' && $this->record->reviewer_id === auth()->id())
                ->form([
                    \Filament\Forms\Components\TextArea::make('feedback')
                        ->label('feedback')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => 'rework', 'feedback' => $data['feedback']]);
                    // $this->notify('success', 'Story rework successfully');
                }),
        ];
    }
}
