<?php

namespace App\Filament\Resources\SystemConfigurations;

use App\Filament\Resources\SystemConfigurations\Pages\ManageSystemConfiguration;
use App\Filament\Resources\SystemConfigurations\Schemas\SystemConfigurationForm;
use App\Models\SystemConfiguration;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;


class SystemConfigurationResource extends Resource
{
    protected static ?string $model = SystemConfiguration::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string | UnitEnum | null $navigationGroup = 'Configurações';

    protected static ?string $navigationLabel = 'Sistema';

    protected static ?string $modelLabel = 'Sistema';

    public static function form(Schema $schema): Schema
    {
        return SystemConfigurationForm::configure($schema);
    }


    public static function getPages(): array
    {
        return [
            'index' => ManageSystemConfiguration::route('/'),
        ];
    }
}
