<?php


namespace MTK\Releaser\Release;

use Munus\Collection\GenericList;
use Munus\Collection\Map;
use MTK\Releaser\Common\ChangeDTO;
use MTK\Releaser\Release\ReleaseNotes\ReleaseNotesFormatter;

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

    /**
     * @return ReleaseNotes
     */
    public static function empty(): ReleaseNotes
    {
        return new ReleaseNotes(Map::empty());
    }

    /**
     * @param ChangeDTO $change
     */
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return ReleaseNotesFormatter::getInstance()->format($this->changes);
    }
}
