<?php

namespace MTK\Releaser\Release;

use MTK\Releaser\Shared\ChangeDTO;
use MTK\Releaser\Shared\ReleaseDTO;
use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;

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
            new ChangeDTO("feature", "Add article draft functionality", "John Doe", "ID-123"),
            new ChangeDTO("fix", "Fix article validation", "Jane Doe", "ID-456"),
            new ChangeDTO("fix", "Fix category tree building", "Foo Bar", "ID-789")
        );
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        $releaseNotes = <<<EOL
            ### Feature (1)
            - Add article draft functionality ID-123
            ### Fix (2)
            - Fix article validation ID-456
            - Fix category tree building ID-789

            EOL;

        $this->assertEquals(new ReleaseDTO("2.0.0", $releaseNotes), $release);
    }

    public function releaseWithoutChanges(): void
    {
        $changes = GenericList::empty();
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        $this->assertEquals(new ReleaseDTO("2.0.0", ""), $release);
    }
}
