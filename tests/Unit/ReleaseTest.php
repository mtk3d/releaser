<?php

namespace MTK\Releaser\Release;

use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;
use MTK\Releaser\Common\ChangeDTO;
use MTK\Releaser\Common\ReleaseDTO;

class ReleaseTest extends TestCase
{
    /**
     * @var ReleaseFacade
     */
    private ReleaseFacade $releaseFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->releaseFacade = (new ReleaseConfiguration())->releaseFacade();
    }

    public function testCreateRelease(): void
    {
        $changes = GenericList::of(
            new ChangeDTO("feature", "Something new", "Mateusz Cholewka", "PJ-789"),
            new ChangeDTO("fix", "Fixed something", "Mateusz Cholewka", "PJ-123"),
            new ChangeDTO("fix", "Fixed something else", "Mateusz Cholewka", "PJ-456")
        );
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        $this->assertEquals(new ReleaseDTO("2.0.0", "### Feature (1)\n- Something new PJ-789\n### Fix (2)\n- Fixed something PJ-123\n- Fixed something else PJ-456\n"), $release);
    }

    public function releaseWithoutChanges(): void
    {
        $changes = GenericList::empty();
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        $this->assertEquals(new ReleaseDTO("2.0.0", ""), $release);
    }
}
