<?php

declare(strict_types=1);


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use PHPUnit\Framework\TestCase;

class ChangelogTest extends TestCase
{
    private ChangelogFacade $changelogFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->changelogFacade = (new ChangelogConfiguration())->changelogFacade();
    }

    public function testAppendNewRelease(): void
    {
        $this->changelogFacade->appendRelease(aRelease());

        $release = aRelease("2.0.0");
        $this->changelogFacade->appendRelease($release);

        $latestRelease = $this->changelogFacade->getLatestRelease()->get();

        self::assertEquals($release, $latestRelease);
    }

    public function testGetLatestReleaseFromEmptyChangelog(): void
    {
        $releaseNotExist = $this->changelogFacade
            ->getLatestRelease()
            ->isEmpty();

        self::assertTrue($releaseNotExist);
    }
}
