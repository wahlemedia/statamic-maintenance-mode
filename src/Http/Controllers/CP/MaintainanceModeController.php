<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\YAML;
use Statamic\Fields\Blueprint as BlueprintFields;
use Statamic\Http\Controllers\CP\CpController;
use Wahlemedia\StatamicMaintenanceMode\Blueprints\Fields;

class MaintainanceModeController extends CpController
{
    protected string $path;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->path = config('statamic-maintenance-mode.path');
    }

    public function index()
    {
        $values = file_exists($this->path) ? YAML::file($this->path)->parse() : [];

        $fields = $this->blueprint()
            ->fields()
            ->addValues($values)
            ->preProcess();

        return view('statamic-maintenance-mode::cp.settings.index', [
            'title' => __('statamic-maintenance-mode::messages.cp.maintenance_title'),
            'action' => cp_route('wahlemedia.maintenance.settings.update'),
            'blueprint' => $this->blueprint()->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function update(Request $request)
    {
        $fields = $this->blueprint()->fields()->addValues($request->all());
        $fields->validate();

        File::put($this->path, YAML::dump($fields->process()->values()->all()));
    }

    protected function blueprint(): BlueprintFields
    {
        return Blueprint::make()->setContents([
            'fields' => Fields::get(),
        ]);
    }
}
