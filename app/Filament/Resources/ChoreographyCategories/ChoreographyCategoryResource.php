<?php

namespace App\Filament\Resources\ChoreographyCategories;

use App\Filament\Resources\ChoreographyCategories\Pages\ManageChoreographyCategories;
use App\Models\ChoreographyCategory;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class ChoreographyCategoryResource extends Resource
{
    protected static ?string $model = ChoreographyCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Configurações';

    protected static ?string $navigationLabel = 'Categorias de Coreografia';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $label = 'Categoria';

    protected static ?string $pluralLabel = 'Categorias';

    protected static ?string $pluralModelLabel = 'Categorias';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->color('gray'),
                    DeleteAction::make()
                        ->before(function (ChoreographyCategory $record, DeleteAction $action) {
                            if ($record->choreographies()->exists()) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Existem coreografias associadas a esta categoria.')
                                    ->warning()
                                    ->send();

                                $action->halt();
                            }
                        }),
                ])
                    ->label('Ações')
                    ->button()
                    ->color('gray')
                    ->size(Size::Small),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->before(function (Collection $records, DeleteBulkAction $action) {
                            if ($records->some(fn($record) => $record->choreographies()->exists())) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Algumas categorias selecionadas possuem coreografias associadas.')
                                    ->warning()
                                    ->send();

                                $action->halt();
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageChoreographyCategories::route('/'),
        ];
    }
}
