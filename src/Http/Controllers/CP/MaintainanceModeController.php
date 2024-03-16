<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode\Http\Controllers\CP;

use Illuminate\Http\Request;
use Statamic\Facades\Blueprint as BlueprintFacace;
use Statamic\Facades\File;
use Statamic\Facades\Path;
use Statamic\Facades\YAML;
use Statamic\Fields\Blueprint;
use Statamic\Http\Controllers\CP\CpController;

class MaintainanceModeController extends CpController
{
    protected string $valuePath;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->valuePath = config('statamic-maintenance-mode.path');
    }

    public function index()
    {
        $values = file_exists($this->valuePath) ? YAML::file($this->valuePath)->parse() : [];

        $fields = $this->buildBlueprint()
            ->fields()
            ->addValues($values)
            ->preProcess();

        return view('statamic-maintenance-mode-views::cp.settings.index', [
            'title' => __('statamic-maintenance-mode-translations::messages.cp.maintenance_title'),
            'action' => cp_route('utilities.maintenance-mode'),
            'blueprint' => $this->buildBlueprint()->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function update(Request $request)
    {
        $fields = $this->buildBlueprint()
            ->fields()
            ->addValues($request->all());

        $fields->validate();

        File::put($this->valuePath, YAML::dump($fields->process()->values()->all()));
    }

    protected function buildBlueprint(): Blueprint
    {
        $path = Path::assemble(__DIR__.'/../../../../', 'resources', 'blueprints', 'maintainance.yaml');

        $yaml = YAML::file($path)->parse();

        return BlueprintFacace::make()->setContents($yaml);
    }
}
