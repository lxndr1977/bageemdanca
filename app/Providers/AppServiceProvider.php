<?php

namespace App\Providers;

use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }

    $config = null;

    if (Schema::hasTable('system_configurations')) {
        $config = SystemConfiguration::current();

        if ($config) {
            config(['app.name' => $config->festival_name ?? config('app.name')]);
        }
    }

    view()->share('systemConfig', $config);
}
}
