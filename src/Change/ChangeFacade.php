<?php


namespace MTK\Releaser\Change;

use MTK\Releaser\Common\ChangeDTO;
use Munus\Collection\GenericList;

final class ChangeFacade
{
    /**
     * @var ChangeManager
     */
    private ChangeManager $changeManager;

    /**
     * ChangeFacade constructor.
     * @param ChangeManager $changeManager
     */
    public function __construct(ChangeManager $changeManager)
    {
        $this->changeManager = $changeManager;
    }

    /**
     * @param ChangeDTO $changeDto
     */
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
