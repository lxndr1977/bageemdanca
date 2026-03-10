<?php

namespace App\Filament\Resources\SystemConfigurations\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SystemConfigurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Festival')
                    ->schema([
                        TextInput::make('festival_name')
                            ->label('Nome do Festival')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            DateTimePicker::make('registration_start_date')
                                ->label('Data de Início das Inscrições')
                                ->nullable()
                                ->native(false)
                                ->displayFormat('d/m/Y H:i')
                                ->seconds(false),

                            DateTimePicker::make('registration_end_date')
                                ->label('Data de Fim das Inscrições')
                                ->nullable()
                                ->native(false)
                                ->displayFormat('d/m/Y H:i')
                                ->seconds(false),
                        ]),
                    ])->columnSpanFull(),

                Section::make('Identidade Visual')
                    ->schema([
                        FileUpload::make('logo_path')
                            ->label('Logo')
                            ->image()
                            ->imageEditor()
                            ->directory('logos')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpan(2),

                        FileUpload::make('favicon_path')
                            ->label('Favicon')
                            ->image()
                            ->directory('favicons')
                            ->disk('public')
                            ->visibility('public')
                            ->imagePreviewHeight('48')
                            ->helperText('Icone do site (48x48 recomendado).')
                            ->columnSpan(2),

                        Grid::make(3)->schema([
                            ColorPicker::make('primary_color')
                                ->label('Cor Principal'),

                            ColorPicker::make('secondary_color')
                                ->label('Cor Secundária'),

                            ColorPicker::make('tertiary_color')
                                ->label('Cor Terciária'),

                            ColorPicker::make('text_color')
                                ->label('Cor dos Textos'),

                            ColorPicker::make('button_color')
                                ->label('Cor do Botão'),

                            ColorPicker::make('button_text_color')
                                ->label('Cor do Texto do Botão'),
                        ])->columnSpan(4),
                    ])->columns(4)->columnSpanFull(),

                Section::make('Configurações de Inscrição')
                    ->schema([
                        Toggle::make('allow_edit_after_submit')
                            ->label('Permitir edição após envio')
                            ->helperText('Permite que os usuários editem suas inscrições após o envio inicial')
                            ->inline(false),
                    ])->columnSpanFull(),

                Section::make('Configurações de Envio de Email')
                    ->schema([
                        TextInput::make('notification_sender_email')
                            ->label('Email que enviará notificações')
                            ->helperText('Email que enviará notificações')
                            ->email()
                            ->required(),
                        TextInput::make('notification_cc_email')
                            ->label('Email que receberá cópia das notificações')
                            ->helperText('Email que receberá cópia das notificações')
                            ->email()
                            ->nullable(),
                        TextInput::make('notification_whatsapp')
                            ->label('WhatsApp de contato (com código do país, sem sinais)')
                            ->helperText('Número para contato/pagamento, ex: 5551993120404')
                            ->nullable(),
                    ])->columnSpanFull(),
            ]);
    }
}
