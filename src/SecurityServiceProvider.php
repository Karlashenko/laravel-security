<?php

declare(strict_types=1);

namespace Phrantiques\Security;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Phrantiques\Security\Services\Security;
use Phrantiques\Security\Contracts\SecurityServiceAware;

class SecurityServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('security', function ($app) {
            return $app->make(Security::class);
        });

        $this->app->resolving(SecurityServiceAware::class, function (SecurityServiceAware $object, Application $app) {
            $object->setSecurityService($app->make('security'));
        });
    }

    /**
     * Boot service provider.
     *
     * @return void
     */
    public function boot(): void
    {
        require __DIR__ . '/../routes/routes.php';

        $this->publishes([__DIR__ . '/../config/security.php' => config_path('security.php')]);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'security');
        $this->mergeConfigFrom(__DIR__ . '/../config/security.php', 'security');
    }
}
