<?php

declare(strict_types=1);


namespace MTK\Releaser\Change;

use MTK\Releaser\Shared\ChangeDTO;
use Munus\Collection\GenericList;

final class ChangeFacade
{
    private ChangeManager $changeManager;

    public function __construct(ChangeManager $changeManager)
    {
        $this->changeManager = $changeManager;
    }

    public function create(ChangeDTO $changeDto): void
    {
        $this->changeManager->save(Change::fromDto($changeDto));
    }

    /**
     * @return GenericList<ChangeDTO>
     */
    public function getAllChanges(): GenericList
    {
        return $this->changeManager->get()
            ->map(fn (Change $change): ChangeDTO => $change->getChangeDTO());
    }

    public function clearChanges(): void
    {
        $this->changeManager->clearAll();
    }
}
