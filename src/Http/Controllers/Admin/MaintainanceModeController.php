<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Fields\Blueprint as BlueprintFields;
use Statamic\Http\Controllers\CP\CpController;
use Wahlemedia\StatamicMaintenanceMode\Blueprints\Fields;

class MaintainanceModeController extends CpController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function index()
    {
        return view('statamic-maintenance-mode::cp.settings.index', [
            'title' => __('statamic-maintenance-mode::messages.cp.maintenance_title'),
            'action' => cp_route('wahlemedia.maintenance.settings.update'),
            'blueprint' => [],
            'meta' => [],
            'values' => [],
        ]);
    }

    public function update(Request $request)
    {
        
    }
 
}
