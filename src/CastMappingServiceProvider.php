<?php

namespace Yonchando\CastAttributes;

use Illuminate\Support\ServiceProvider;

class CastMappingServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {

    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->app->singleton(CastAttributes::class, function () {
            return new CastAttributes();
        });
    }
}
