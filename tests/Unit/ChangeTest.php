<?php


namespace MTK\Releaser\Release;

use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Common\ChangeDTO;
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
        $change = new ChangeDTO("fix", "Something fixed", "John Doe", "PJ-123");
        $this->changeFacade->create($change);

        $this->assertEquals($change, $this->changeFacade->getAllChanges()->head());
    }

    public function testClearChanges(): void
    {
        $change = new ChangeDTO("fix", "Something fixed", "John Doe", "PJ-123");
        $this->changeFacade->create($change);

        $this->changeFacade->clearChanges();

        $this->assertTrue($this->changeFacade->getAllChanges()->isEmpty());
    }
}
