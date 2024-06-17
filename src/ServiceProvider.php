<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Providers\AddonServiceProvider;
use Wahlemedia\StatamicMaintenanceMode\Http\Middleware\HandleMaintenanceMode;

class ServiceProvider extends AddonServiceProvider
{
    protected $namespace = 'statamic-maintenance-mode';

    protected $middlewareGroups = [
        'web' => [
            HandleMaintenanceMode::class,
        ],
    ];

    protected $config;

    public function bootAddon()
    {
        $this->app->singleton('maintenance-mode', function () {
            return MaintenanceMode::instance();
        });
    }

    // protected function bootTranslations(): self
    // {
    //     parent::bootTranslations();

    //     $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', "{$this->namespace}-translations");

    //     return $this;
    // }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/maintenance-mode.php', $this->namespace);

        parent::register();
    }
}
