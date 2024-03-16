<?php

declare(strict_types=1);

namespace Wahlemedia\MaintenanceMode\Facades;

use Illuminate\Support\Facades\Facade;

class MaintenanceMode extends Facade
{
    public static function getFacadeAccesor()
    {
        return 'maintenance-mode';
    }
}
