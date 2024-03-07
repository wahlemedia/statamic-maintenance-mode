<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode\Blueprints;

class Fields
{
    public static function get()
    {
        return [
            [
                'handle' => 'maintenance_enabled',
                'field' => [
                    'type' => 'toggle',
                    'display' => __('statamic-maintenance-mode::messages.cp.maintenance_mode'),
                    'instructions' => __('statamic-maintenance-mode::messages.cp.maintenance_mode_instructions'),
                    'default' => false,
                    'width' => 100,
                    'validate' => 'required|boolean',
                ],
            ],
            [
                'handle' => 'maintenance_site',
                'field' => [
                    'type' => 'entries',
                    'max_items' => 1,
                    'display' => __('statamic-maintenance-mode::messages.cp.maintenance_site'),
                    'instructions' => __('statamic-maintenance-mode::messages.cp.maintenance_site_instructions'),
                    'width' => 100,
                    'mode' => 'default',
                    'validate' => '',
                    'collection' => config('statamic-maintenance-mode.collection'),
                    'create' => true,
                ],
            ],
        ];
    }
}
