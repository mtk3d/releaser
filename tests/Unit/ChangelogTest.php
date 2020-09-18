<?php


namespace MTK\Releaser\Release;

use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Common\ReleaseDTO;
use PHPUnit\Framework\TestCase;

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
        $releaseNotes = <<<EOL
            ### Fix (1)
            - Fix article validation
            EOL;

        $release = new ReleaseDTO("1.0.0", $releaseNotes);
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
