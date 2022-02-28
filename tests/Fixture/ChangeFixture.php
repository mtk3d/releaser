<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Fixture;

use MTK\Releaser\Shared\ChangeDTO;

function aFixChange(string $message = "Fix article validation", string $id = "ID-123"): ChangeDTO
{
    return aChange("fix", $message, $id);
}

function aFeatureChange(string $message = "Fix article validation", string $id = "ID-123"): ChangeDTO
{
    return aChange("feature", $message, $id);
}

function aChange(string $type, string $message = "Fix article validation", string $id = "ID-123"): ChangeDTO
{
    return new ChangeDTO($type, $message, "John Doe", $id);
}
