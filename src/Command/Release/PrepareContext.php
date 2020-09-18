<?php

namespace MTK\Releaser\Command\Release;

use PHLAK\SemVer\Exceptions\InvalidVersionException;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Common\ReleaseDTO;
use MTK\Releaser\Release\ReleaseFacade;

class PrepareContext
{
    /**
     * @var ChangelogFacade
     */
    private ChangelogFacade $changelogFacade;
    /**
     * @var ChangeFacade
     */
    private ChangeFacade $changeFacade;
    /**
     * @var ReleaseFacade
     */
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
     * @param $type
     * @param $version
     * @return ReleaseDTO
     * @throws InvalidVersionException
     */
    public function prepareRelease($type, $version): ReleaseDTO
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