<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\CP\Navigation\NavItem;
use Statamic\Facades\CP\Nav;
use Statamic\Providers\AddonServiceProvider;

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
        Nav::extend(function (\Statamic\CP\Navigation\Nav $nav) {
            /** @var \Statamic\CP\Navigation\NavItem $utils */
            $utils = $nav->find('Tools', 'Utilities');

            if (!$utils) {
                $utils = $nav->create('Utilities')->section('Tools');
            }

            $item = (new NavItem())
                ->display(__('statamic-maintenance-mode::messages.cp.maintenance_mode_button'))
                ->section('Tools')
                ->route('wahlemedia.maintenance.settings.index')
                ->icon('cog')
                ->active('utilities/maintenance(/(.*)?|$)')
                ->id('tools:utilities:maintenance');

            $utils->children([...$utils->children(), $item]);
        });
    }

    protected function bootAddonConfig(): self
    {
        // Todo: implement bootAddonConfig

        return $this;
    }

    protected function bootTranslations(): self
    {
        // Todo: implement bootTranslations

        return $this;
    }

    public function bootViews(): self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->namespace);

        return $this;
    }
}
