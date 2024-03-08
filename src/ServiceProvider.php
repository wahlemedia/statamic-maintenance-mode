<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\Utility;
use Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP\MaintainanceModeController;

class ServiceProvider extends AddonServiceProvider
{

    protected $namespace = 'statamic-maintenance-mode';

    protected $routes = [
        'cp' => __DIR__ . '/../routes/cp.php',
        'web' => __DIR__ . '/../routes/web.php',
    ];

    protected $config;

    public function bootAddon()
    {
        Utility::register('maintenance-mode')
            ->action([MaintainanceModeController::class, 'index'])
            ->title(__('statamic-maintenance-mode::messages.cp.maintenance_mode'))
            ->icon('cog')
            ->navTitle(__('statamic-maintenance-mode::messages.cp.maintenance_mode'))
            ->description(__('statamic-maintenance-mode::messages.cp.maintenance_mode_description'))
            // ->routes(function ($router) {
            //     $router->post('/', [MaintainanceModeController::class, 'update'])->name('wahlemedia.maintenance.settings.update');
            // });
            ;
    }

    protected function bootAddonConfig(): self
    {
        $this->publishes([
            __DIR__ . '/../config/maintainance-mode.php' => config_path('statamic-maintenance-mode.php'),
        ], $this->namespace);

        return $this;
    }

    protected function bootTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', $this->namespace);

        return $this;
    }

    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->namespace);

        return $this;
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maintainance-mode.php', $this->namespace);

        parent::register();
    }
}
