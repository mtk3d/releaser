<?php

declare(strict_types=1);


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use function MTK\Releaser\Tests\Fixture\aFixChange;
use PHPUnit\Framework\TestCase;

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

        self::assertEquals($change, $this->changeFacade->getAllChanges()->head());
    }

    public function testClearChanges(): void
    {
        $change = aFixChange();
        $this->changeFacade->create($change);

        $this->changeFacade->clearChanges();

        self::assertTrue($this->changeFacade->getAllChanges()->isEmpty());
    }
}
