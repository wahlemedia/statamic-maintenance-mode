<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Facades\Utility;
use Statamic\Providers\AddonServiceProvider;
use Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP\MaintainanceModeController;
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
        Utility::register('maintenance-mode')
            ->action([MaintainanceModeController::class, 'index'])
            ->title(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode'))
            ->icon('cog')
            ->navTitle(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode'))
            ->description(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode_description'))
            ->routes(function ($router) {
                $router->post('/', [MaintainanceModeController::class, 'update'])->name('wahlemedia.maintenance.settings.update');
            });
    }

    protected function bootAddonConfig(): self
    {
        $this->publishes([
            __DIR__.'/../config/maintainance-mode.php' => config_path('statamic-maintenance-mode.php'),
        ], "{$this->namespace}-config");

        return $this;
    }

    protected function bootTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', "{$this->namespace}-translations");

        return $this;
    }

    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', "{$this->namespace}-views");

        return $this;
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/maintainance-mode.php', $this->namespace);

        parent::register();
    }
}
