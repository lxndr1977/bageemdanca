<?php

namespace App\Filament\Resources\MemberTypes;

use App\Filament\Resources\MemberTypes\Pages\ManageMemberTypes;
use App\Models\MemberType;
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

class MemberTypeResource extends Resource
{
    protected static ?string $model = MemberType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Configurações';

    protected static ?string $navigationLabel = 'Cargos';

    protected static ?string $label = 'Cargo';

    protected static ?string $pluralLabel = 'Cargos';

    protected static ?string $pluralModelLabel = 'Cargos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('description')
                    ->label('Descrição'),
                TextInput::make('max_limit')
                    ->label('Limite máximo')
                    ->required()
                    ->numeric()
                    ->default(1),
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
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                TextColumn::make('max_limit')
                    ->label('Limite máximo')
                    ->numeric()
                    ->sortable(),
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
                        ->before(function (MemberType $record, DeleteAction $action) {
                            if ($record->members()->exists()) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Existem membros associados a este tipo de membro.')
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
                            if ($records->some(fn($record) => $record->members()->exists())) {
                                Notification::make()
                                    ->title('Não é possível excluir')
                                    ->body('Alguns cargos selecionados possuem membros associados.')
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
            'index' => ManageMemberTypes::route('/'),
        ];
    }
}
