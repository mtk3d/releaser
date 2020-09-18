<?php


namespace MTK\Releaser\Release;

use MTK\Releaser\Shared\ChangeDTO;
use MTK\Releaser\Shared\ReleaseDTO;
use Munus\Collection\GenericList;
use PHLAK\SemVer\Exceptions\InvalidVersionException;

final class ReleaseFacade
{
    /**
     * @param string $type
     * @param GenericList<ChangeDTO> $changes
     * @param string $previousVersion
     * @return ReleaseDTO
     * @throws InvalidVersionException
     */
    public function createNextRelease(string $type, GenericList $changes, string $previousVersion): ReleaseDTO
    {
        $nextVersion = Version::of($previousVersion)
            ->next(new ReleaseType($type));

        $releaseNotes = ReleaseNotes::empty();

        $changes->forEach(
            function (ChangeDTO $change) use ($releaseNotes): void {
                $releaseNotes->put($change);
            }
        );

        return (new Release($nextVersion, $releaseNotes))->getReleaseDTO();
    }
}
