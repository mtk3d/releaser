<?php

declare(strict_types=1);

use MTK\Releaser\Shared\ReleaseDTO;

function aRelease(string $version = "1.0.0"): ReleaseDTO
{
    $releaseNotes = <<<EOL
        ### Fix (1)
        - Fix article validation
        EOL;

    return new ReleaseDTO($version, $releaseNotes);
}
