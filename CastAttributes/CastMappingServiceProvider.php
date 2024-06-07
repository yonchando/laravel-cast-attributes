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

    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [CastAttributes::class];
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {

    }
}
