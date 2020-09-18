<?php

namespace MTK\Releaser\Command\Release;

use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Common\ReleaseDTO;
use MTK\Releaser\Git\GitFacade;
use MTK\Releaser\Publisher\PublisherFacade;

class PublishContext
{
    /**
     * @var ChangelogFacade
     */
    private ChangelogFacade $changelogFacade;
    /**
     * @var GitFacade
     */
    private GitFacade $gitFacade;
    /**
     * @var PublisherFacade
     */
    private PublisherFacade $publisherFacade;

    public function __construct(
        ChangelogFacade $changelogFacade,
        GitFacade $gitFacade,
        PublisherFacade $publisherFacade
    ) {
        $this->changelogFacade = $changelogFacade;
        $this->gitFacade = $gitFacade;
        $this->publisherFacade = $publisherFacade;
    }

    /**
     * @param ReleaseDTO $release
     */
    public function publish(ReleaseDTO $release): void
    {
        $this->changelogFacade->appendRelease($release);
        $this->gitFacade->createRelease($release);
        $this->publisherFacade->publish($release);
    }

    /**
     * @return bool
     */
    public function hasUncommittedChanges(): bool
    {
        return $this->gitFacade->hasUncommittedChanges();
    }
}