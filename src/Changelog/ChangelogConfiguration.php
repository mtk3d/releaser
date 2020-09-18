<?php


namespace MTK\Releaser\Changelog;

use MTK\Releaser\Changelog\Infrastructure\InMemoryChangelogManager;

class ChangelogConfiguration
{
    public function changelogFacade(?ChangelogManager $changelogManager = null): ChangelogFacade
    {
        if (!$changelogManager) {
            $changelogManager = new InMemoryChangelogManager();
        }
        return new ChangelogFacade($changelogManager);
    }
}
