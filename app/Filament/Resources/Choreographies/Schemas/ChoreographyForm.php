<?php

namespace App\Filament\Resources\Choreographies\Schemas;

use App\Services\DancerValidationService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

final class ChoreographyForm
{
    public static function configure(Schema $schema, bool $hideSchool = false, ?int $schoolId = null): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação da Coreografia')
                    ->icon('heroicon-o-musical-note')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome da Coreografia')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),


                        Select::make('school_id')
                            ->label('Instituição')
                            ->relationship('school', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default($schoolId)
                            ->hidden($hideSchool)
                            ->dehydrated(! $hideSchool)
                            ->live()
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            Select::make('choreography_type_id')
                                ->label('Formação')
                                ->relationship('choreographyType', 'name')
                                ->required()
                                ->live(),

                            Select::make('choreography_category_id')
                                ->label('Categoria')
                                ->relationship('choreographyCategory', 'name')
                                ->required(),

                            Select::make('dance_style_id')
                                ->label('Modalidade')
                                ->relationship('danceStyle', 'name')
                                ->required(),
                        ]),

                        Grid::make(3)->schema([
                            TextInput::make('music')
                                ->label('Música')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('music_composer')
                                ->label('Compositor')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('duration')
                                ->label('Duração')
                                ->required()
                                ->placeholder('00:00')
                                ->mask('99:99')
                                ->maxLength(5),
                        ]),

                        Grid::make(3)->schema([
                            Toggle::make('is_social_project')
                                ->label('Projeto Social')
                                ->inline(false),

                            Toggle::make('is_university_project')
                                ->label('Projeto Universitário')
                                ->inline(false),
                        ]),
                    ]),

                Section::make('Participantes')
                    ->icon('heroicon-o-user-group')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('choreographers')
                                ->label('Coreógrafos')
                                ->relationship(
                                    'choreographers',
                                    'name',
                                    modifyQueryUsing: fn(Builder $query, Get $get) => $query
                                        ->where('school_id', $get('school_id') ?? $schoolId)
                                )
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->required()
                                ->noSearchResultsMessage('Nenhum coreógrafo encontrado.')
                                ->noOptionsMessage('Nenhum coreógrafo disponível.')
                                ->columnSpanFull(),

                            Select::make('dancers')
                                ->label('Bailarinos')
                                ->relationship(
                                    'dancers',
                                    'name',
                                    modifyQueryUsing: fn(Builder $query, Get $get) => $query
                                        ->where('school_id', $get('school_id') ?? $schoolId)
                                )
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->required()
                                ->noSearchResultsMessage('Nenhum bailarino encontrado.')
                                ->noOptionsMessage('Nenhum bailarino disponível.')
                                ->columnSpanFull()
                                ->rules([
                                    fn(Get $get): \Closure => function (
                                        string $attribute,
                                        mixed $value,
                                        \Closure $fail
                                    ) use ($get) {
                                        $choreographyTypeId = $get('choreography_type_id');

                                        if (! $choreographyTypeId) {
                                            return;
                                        }

                                        $validation = (new DancerValidationService)
                                            ->validateDancerCount($choreographyTypeId, is_array($value) ? $value : []);

                                        if (! $validation['valid']) {
                                            $fail($validation['message']);
                                        }
                                    },
                                ]),
                        ]),
                    ]),
            ]);
    }
}
