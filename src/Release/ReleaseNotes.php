<?php

declare(strict_types=1);


namespace MTK\Releaser\Release;

use MTK\Releaser\Release\ReleaseNotes\ReleaseNotesFormatter;
use MTK\Releaser\Shared\ChangeDTO;
use Munus\Collection\GenericList;
use Munus\Collection\Map;

class ReleaseNotes
{
    /**
     * @var Map<string, GenericList<ChangeDTO>>
     */
    private Map $changes;

    /**
     * ReleaseNotes constructor.
     * @param Map<string, GenericList<ChangeDTO>> $changes
     */
    public function __construct(Map $changes)
    {
        $this->changes = $changes;
    }

    public static function empty(): ReleaseNotes
    {
        return new ReleaseNotes(Map::empty());
    }

    public function put(ChangeDTO $change): void
    {
        /** @var GenericList<ChangeDTO> $typeChanges */
        $typeChanges = $this->changes
            ->get($change->getType())
            ->getOrElseTry(fn () => GenericList::empty());

        $this->changes = $this->changes->put(
            $change->getType(),
            $typeChanges->append($change)
        );
    }

    public function __toString(): string
    {
        return ReleaseNotesFormatter::getInstance()->format($this->changes);
    }
}
