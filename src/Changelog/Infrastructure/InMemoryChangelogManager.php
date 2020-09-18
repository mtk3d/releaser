<?php

namespace MTK\Releaser\Changelog\Infrastructure;

use MTK\Releaser\Changelog\Changelog;
use MTK\Releaser\Changelog\ChangelogManager;

class InMemoryChangelogManager implements ChangelogManager
{
    /**
     * @var Changelog
     */
    private Changelog $changelog;

    public function __construct()
    {
        $this->changelog = Changelog::empty();
    }

    /**
     * @inheritDoc
     */
    public function save(Changelog $changelog): void
    {
        $this->changelog = $changelog;
    }

    /**
     * @inheritDoc
     */
    public function getChangelog(): Changelog
    {
        return $this->changelog;
    }
}
