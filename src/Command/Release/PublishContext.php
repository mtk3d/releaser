<?php

namespace MTK\Releaser\Command\Release;

use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Shared\ReleaseDTO;
use MTK\Releaser\Git\GitFacade;
use MTK\Releaser\Publisher\PublisherFacade;

class PublishContext
{
    private ChangelogFacade $changelogFacade;
    private GitFacade $gitFacade;
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

    public function publish(ReleaseDTO $release): void
    {
        $this->changelogFacade->appendRelease($release);
        $this->gitFacade->createRelease($release);
        $this->publisherFacade->publish($release);
    }

    public function hasUncommittedChanges(): bool
    {
        return $this->gitFacade->hasUncommittedChanges();
    }
}
