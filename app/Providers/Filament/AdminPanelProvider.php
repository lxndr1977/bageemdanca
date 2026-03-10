<?php

namespace App\Providers\Filament;

use App\Models\SystemConfiguration;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->colors(fn () => (function (): array {
                $defaultPrimary = '#b21653';
                $defaultSecondary = '#1f2937';

                if (! Schema::hasTable('system_configurations')) {
                    return [
                        'primary' => Color::hex($defaultPrimary),
                        'secondary' => Color::hex($defaultSecondary),
                    ];
                }

                $config = SystemConfiguration::first();

                $primary = $config?->button_color ?? $defaultPrimary;
                $button = $config?->button_color ?? '#e04feb';
                $secondary = $config?->secondary_color ?? $defaultSecondary;

                return [
                    'primary' => Color::hex($primary),
                    'button' => Color::hex($button),
                    'secondary' => Color::hex($secondary),
                ];
            })())
            ->brandLogo(function () {
                if (! Schema::hasTable('system_configurations')) {
                    return asset('logo-vds-2025-colorido.jpg');
                }

                $config = SystemConfiguration::first();

                return $config?->logo_url ?? asset('logo-vds-2025-colorido.jpg');
            })
            ->brandLogoHeight('2.5rem')
            ->favicon(function () {
                if (! Schema::hasTable('system_configurations')) {
                    return asset('apple-touch-icon.png');
                }

                $config = SystemConfiguration::first();

                return $config?->favicon_url ?? asset('apple-touch-icon.png');
            })
            ->darkMode(false);
    }
}
