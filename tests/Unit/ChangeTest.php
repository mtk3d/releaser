<?php


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use PHPUnit\Framework\TestCase;
use function MTK\Releaser\Tests\Fixtures\aFixChange;

class ChangeTest extends TestCase
{
    private ChangeFacade $changeFacade;

    public function setUp(): void
    {
        parent::setUp();
        $this->changeFacade = (new ChangeConfiguration())->changeFacade();
    }

    public function testCreateChange(): void
    {
        $change = aFixChange();
        $this->changeFacade->create($change);

        $this->assertEquals($change, $this->changeFacade->getAllChanges()->head());
    }

    public function testClearChanges(): void
    {
        $change = aFixChange();
        $this->changeFacade->create($change);

        $this->changeFacade->clearChanges();

        $this->assertTrue($this->changeFacade->getAllChanges()->isEmpty());
    }
}
