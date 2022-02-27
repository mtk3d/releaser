<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Fixtures;

use MTK\Releaser\Shared\ChangeDTO;

function aFixChange(string $message = "Fix article validation", string $id = "ID-123"): ChangeDTO
{
    return new ChangeDTO("fix", $message, "John Doe", $id);
}
