<?php

declare(strict_types=1);

namespace Wahlemedia\StatamicMaintenanceMode;

use Statamic\Facades\Entry;
use Statamic\Facades\YAML;
use Wahlemedia\MaintenanceMode\Exceptions\MissingMaintenancePageException;

class MaintenanceMode
{
    protected string $path;

    protected array $values = [];

    public function __construct()
    {
        $this->path = config('statamic-maintenance-mode.path');

        $this->values = $this->parseConfig();
    }

    public static function instance(): self
    {
        return new self();
    }

    protected function parseConfig(): array
    {
        return file_exists($this->path) ? YAML::file($this->path)->parse() : [];
    }

    public function getPageUri(): string
    {
        $page = $this->values['maintenance_site'] ?? null;

        if (! $page) {
            throw new MissingMaintenancePageException();
        }

        return Entry::find($page)->uri();
    }

    public function isActivated(): bool
    {
        return $this->values['maintenance_enabled'] ?? false;
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

        foreach ($whitelist as $page) {
            $uri = Entry::find($page)->uri();
            if ($url === $uri) {
                return true;
            }
        }

        return false;
    }

    protected function getWhitelistedPages(): array
    {
        return $this->values['maintenance_whitelist_sites'] ?? [];
    }
}
