<?php


namespace MTK\Releaser\Change;

use MTK\Releaser\Change\Infrastructure\InMemoryChangeManager;

class ChangeConfiguration
{
    public function changeFacade(?ChangeManager $changeManager = null): ChangeFacade
    {
        if (!$changeManager) {
            $changeManager = new InMemoryChangeManager();
        }
        return new ChangeFacade($changeManager);
    }
}
