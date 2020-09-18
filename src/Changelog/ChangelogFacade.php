<?php


namespace MTK\Releaser\Changelog;

use MTK\Releaser\Shared\ReleaseDTO;
use Munus\Control\Option;

final class ChangelogFacade
{
    /**
     * @var ChangelogManager
     */
    private ChangelogManager $changelogManager;

    public function __construct(ChangelogManager $changelogManager)
    {
        $this->changelogManager = $changelogManager;
    }

    public function appendRelease(ReleaseDTO $releaseDTO): void
    {
        $changelog = $this->changelogManager->getChangelog();
        $changelog->append($releaseDTO);

        $this->changelogManager->save($changelog);
    }

    /**
     * @return Option<ReleaseDTO>
     */
    public function getLatestRelease(): Option
    {
        /** @var Changelog $changelog */
        $changelog = $this->changelogManager->getChangelog();

        if ($changelog->getListReleaseDTO()->isEmpty()) {
            return Option::none();
        }

        return Option::of($changelog->getListReleaseDTO()->head());
    }
}
