<?php


namespace MTK\Releaser\Release;

use PHPUnit\Framework\TestCase;
use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Common\ReleaseDTO;

class ChangelogTest extends TestCase
{
    /**
     * @var ChangelogFacade
     */
    private ChangelogFacade $changelogFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->changelogFacade = (new ChangelogConfiguration())->changelogFacade();
    }

    public function testAppendNewRelease(): void
    {
        $release = new ReleaseDTO("1.0.0", "## Fix:\n* Something fixed\n");
        $this->changelogFacade->appendRelease($release);

        $latestRelease = $this->changelogFacade->getLatestRelease()->get();

        $this->assertEquals($release, $latestRelease);
    }

    public function testGetLatestReleaseFromEmptyChangelog(): void
    {
        $releaseNotExist = $this->changelogFacade
            ->getLatestRelease()
            ->isEmpty();

        $this->assertTrue($releaseNotExist);
    }
}
