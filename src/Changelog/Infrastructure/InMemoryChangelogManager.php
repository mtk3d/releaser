<?php

namespace MTK\Releaser\Changelog\Infrastructure;

use MTK\Releaser\Changelog\Changelog;
use MTK\Releaser\Changelog\ChangelogManager;

class InMemoryChangelogManager implements ChangelogManager
{
    private Changelog $changelog;

    public function __construct()
    {
        $this->changelog = Changelog::empty();
    }

    public function save(Changelog $changelog): void
    {
        $this->changelog = $changelog;
    }

    public function getChangelog(): Changelog
    {
        return $this->changelog;
    }
}
