<?php

namespace MTK\Releaser\Change\Infrastructure;

use Munus\Collection\GenericList;
use MTK\Releaser\Change\Change;
use MTK\Releaser\Change\ChangeManager;

class InMemoryChangeManager implements ChangeManager
{
    /**
     * @var GenericList<Change>
     */
    private GenericList $changes;

    public function __construct()
    {
        $this->changes = GenericList::empty();
    }

    /**
     * @inheritDoc
     */
    public function save(Change $change): void
    {
        $this->changes = $this->changes->append($change);
    }

    /**
     * @inheritDoc
     */
    public function get(): GenericList
    {
        return $this->changes;
    }

    /**
     * @inheritDoc
     */
    public function clearAll(): void
    {
        $this->changes = GenericList::empty();
    }
}
