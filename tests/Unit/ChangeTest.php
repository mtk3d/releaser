<?php


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Shared\ChangeDTO;
use PHPUnit\Framework\TestCase;

class ChangeTest extends TestCase
{
    /**
     * @var ChangeFacade
     */
    private ChangeFacade $changeFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->changeFacade = (new ChangeConfiguration())->changeFacade();
    }

    public function testCreateChange(): void
    {
        $change = new ChangeDTO(
            "fix",
            "Fix article validation",
            "John Doe",
            "ID-123"
        );
        $this->changeFacade->create($change);

        $this->assertEquals($change, $this->changeFacade->getAllChanges()->head());
    }

    public function testClearChanges(): void
    {
        $change = new ChangeDTO(
            "fix",
            "Fix category tree building",
            "John Doe",
            "ID-123"
        );
        $this->changeFacade->create($change);

        $this->changeFacade->clearChanges();

        $this->assertTrue($this->changeFacade->getAllChanges()->isEmpty());
    }
}
