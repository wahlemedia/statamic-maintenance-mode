<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Entries\EntryCollection;
use Statamic\Facades\GlobalSet;
use Statamic\Globals\Variables;
use Wahlemedia\MaintenanceMode\Exceptions\MissingMaintenancePageException;

class MaintenanceMode
{
    protected string $path;

    protected Variables $siteVariables;

    public function __construct()
    {
        $setName = config('statamic-maintenance-mode.global_set');

        $this->siteVariables = GlobalSet::find($setName)?->inCurrentSite();
    }

    public function getPageUri(): string
    {
        /** @var Statamic\Contracts\Entries\Entry|null */
        $entry = $this->siteVariables->maintenance_site ?? null;

        if (! $entry) {
            throw new MissingMaintenancePageException();
        }

        return $entry->uri();
    }

    public function isActivated(): bool
    {
        return $this->siteVariables->maintenance_enabled ?? false;
    }

    public function isNotActivated(): bool
    {
        return ! $this->isActivated();
    }

    public function isMaintenancePage(string $url): bool
    {
        return $url == $this->getPageUri();
    }

    public function isNotMaintenancePage(string $url): bool
    {
        return $url != $this->getPageUri();
    }

    public function isWhitelistedPage(string $url): bool
    {
        $whitelist = $this->getWhitelistedPages();

        foreach ($whitelist as $entry) {
            if ($url === $entry->uri()) {
                return true;
            }
        }

        return false;
    }

    protected function getWhitelistedPages(): EntryCollection
    {
        if (! $this->siteVariables->has('maintenance_whitelist_sites')) {
            return EntryCollection::make();
        }

        return $this->siteVariables->maintenance_whitelist_sites;
    }
}
