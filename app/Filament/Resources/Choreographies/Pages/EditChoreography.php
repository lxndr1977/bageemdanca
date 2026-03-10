<?php

namespace App\Filament\Resources\Choreographies\Pages;

use App\Filament\Resources\Choreographies\ChoreographyResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChoreography extends EditRecord
{
    protected static string $resource = ChoreographyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Voltar')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),

            ActionGroup::make(
                [
                    DeleteAction::make(),

                ]
            )
        ];
    }
}
