<?php

namespace App\Filament\Resources\DanceStyles;

use App\Filament\Resources\DanceStyles\Pages\ManageDanceStyles;
use App\Models\DanceStyle;
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

class DanceStyleResource extends Resource
{
    protected static ?string $model = DanceStyle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Configurações';

    protected static ?string $navigationLabel = 'Modalidades';

    protected static ?string $label = 'Modalidade';

    protected static ?string $pluralLabel = 'Modalidades';

    protected static ?string $pluralModelLabel = 'Modalidades';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome da modalidade')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nome da modalidade')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
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
                        ->before(function (DanceStyle $record, DeleteAction $action) {
                            if ($record->choreographies()->exists()) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Esta modalidade possui coreografias associadas.')
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
                            if ($records->some(fn ($record) => $record->choreographies()->exists())) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Algumas modalidades selecionadas possuem coreografias associadas.')
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
            'index' => ManageDanceStyles::route('/'),
        ];
    }
}
