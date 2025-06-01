<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelSettings\SettingsContainer;
use App\Settings\AppSettings;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->get(SettingsContainer::class);
    }
}
