<?php

declare(strict_types=1);

namespace MTK\Releaser\Change\Infrastructure;

use MTK\Releaser\Change\Change;
use MTK\Releaser\Change\ChangeManager;
use Munus\Collection\GenericList;

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

    public function save(Change $change): void
    {
        $this->changes = $this->changes->append($change);
    }

    public function get(): GenericList
    {
        return $this->changes;
    }

    public function clearAll(): void
    {
        $this->changes = GenericList::empty();
    }
}
