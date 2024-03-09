<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;
use Wahlemedia\StatamicMaintenanceMode\ServiceProvider as MaintenanceModeServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            StatamicServiceProvider::class,
            MaintenanceModeServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'wahlemedia/statamic-maintenance-mode' => [
                'id' => 'wahlemedia/statamic-maintenance-mode',
                'namespace' => 'Wahlemedia\\StatamicMaintenanceMode\\',
            ],
        ];
    }

    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'routes', 'static_caching',
            'sites', 'stache', 'system', 'users',
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require (__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        // Set the users repository to flat file
        $app['config']->set('statamic.users.repository', 'file');

        $app['config']->set('statamic.users.repository', 'file');

        $app['config']->set('statamic.maintenance-mode', require (__DIR__.'/../config/maintainance-mode.php'));
    }
}
