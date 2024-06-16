<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Facades\Utility;
use Statamic\Facades\GlobalSet;
use Statamic\Providers\AddonServiceProvider;
use Wahlemedia\StatamicMaintenanceMode\Http\Middleware\HandleMaintenanceMode;
use Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP\MaintenanceModeController;

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


        return;

        Utility::register('maintenance-mode')
            ->action([MaintenanceModeController::class, 'index'])
            ->title(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode'))
            ->icon('<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
            </svg>')
            ->navTitle(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode'))
            ->description(__('statamic-maintenance-mode-translations::messages.cp.maintenance_mode_description'))
            ->routes(function ($router) {
                $router->post('/', [MaintenanceModeController::class, 'update'])->name('wahlemedia.maintenance.settings.update');
            });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/maintenance-mode.php', $this->namespace);

        parent::register();
    }
}
