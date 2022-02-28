<?php


namespace MTK\Releaser\Change;

use Munus\Collection\GenericList;

interface ChangeManager
{
    public function save(Change $change): void;

    /**
     * @return GenericList<Change>
     */
    public function get(): GenericList;

    public function clearAll(): void;
}
