<?php

declare(strict_types=1);

namespace MTK\Releaser\Command\Release;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Release\ReleaseFacade;
use MTK\Releaser\Shared\ReleaseDTO;
use PHLAK\SemVer\Exceptions\InvalidVersionException;

class PrepareContext
{
    private ChangelogFacade $changelogFacade;
    private ChangeFacade $changeFacade;
    private ReleaseFacade $releaseFacade;

    public function __construct(
        ChangelogFacade $changelogFacade,
        ChangeFacade $changeFacade,
        ReleaseFacade $releaseFacade
    ) {
        $this->changelogFacade = $changelogFacade;
        $this->changeFacade = $changeFacade;
        $this->releaseFacade = $releaseFacade;
    }

    /**
     * @throws InvalidVersionException
     */
    public function prepareRelease(?string $type, ?string $version): ReleaseDTO
    {
        $releaseType = $type ?: 'minor';

        $latestVersion = $version ?: $this->changelogFacade->getLatestRelease()
            ->map(fn (ReleaseDTO $release): string => $release->getVersion())
            ->getOrElse('0.0.0');

        $changes = $this->changeFacade->getAllChanges();

        return $this->releaseFacade->createNextRelease($releaseType, $changes, $latestVersion);
    }

    public function clearChanges(): void
    {
        $this->changeFacade->clearChanges();
    }
}
