<?php

declare(strict_types=1);

namespace MTK\Releaser\Test\Unit;

use MTK\Releaser\Release\ReleaseConfiguration;
use MTK\Releaser\Release\ReleaseFacade;
use function MTK\Releaser\Test\Fixture\aFeatureChange;
use function MTK\Releaser\Test\Fixture\aFixChange;
use function MTK\Releaser\Test\Fixture\aRelease;
use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;

class ReleaseTest extends TestCase
{
    private ReleaseFacade $releaseFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->releaseFacade = (new ReleaseConfiguration())->releaseFacade();
    }

    public function testCreateRelease(): void
    {
        $changes = GenericList::of(
            aFeatureChange("Add article draft functionality"),
            aFixChange("Fix article validation", "ID-456"),
            aFixChange("Fix category tree building", "ID-789"),
        );
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        $expectedRelease = aRelease(
            "2.0.0",
            <<<EOL
            ### Feature (1)
            - Add article draft functionality ID-123
            ### Fix (2)
            - Fix article validation ID-456
            - Fix category tree building ID-789

            EOL
        );

        self::assertEquals($expectedRelease, $release);
    }

    public function releaseWithoutChanges(): void
    {
        $changes = GenericList::empty();
        $release = $this->releaseFacade
            ->createNextRelease("major", $changes, "1.0.0");

        self::assertEquals(aRelease("2.0.0", ""), $release);
    }
}
