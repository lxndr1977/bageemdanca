<?php

namespace App\Filament\Resources\Registrations\RelationManagers;

use App\Filament\Resources\Choreographies\ChoreographyResource;
use App\Filament\Resources\Choreographies\Schemas\ChoreographyForm;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ChoreographiesRelationManager extends RelationManager
{
    protected static string $relationship = 'choreographies';

    protected static ?string $title = 'Coreografias';

    public function form(Schema $form): Schema
    {
        return ChoreographyForm::configure($form, hideSchool: true, schoolId: $this->getOwnerRecord()->school_id);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modelLabel('Coreografia')
            ->pluralModelLabel('Coreografias')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('choreographyType.name')
                    ->label('Formação')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('choreographyCategory.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('danceStyle.name')
                    ->label('Gênero')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Duração')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['school_id'] = $this->getOwnerRecord()->school_id;

                        return $data;
                    })
                    ->slideOver(),

            ])
            ->actions([
                EditAction::make('edit')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->slideOver(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'asc');
    }
}
