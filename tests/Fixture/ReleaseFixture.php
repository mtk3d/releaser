<?php

declare(strict_types=1);

use MTK\Releaser\Shared\ReleaseDTO;

function aRelease(string $version = "1.0.0", string $releaseNotes = null): ReleaseDTO
{
    if ($releaseNotes === null) {
        $releaseNotes = <<<EOL
            ### Feature (1)
            - Add article draft functionality ID-123
            ### Fix (2)
            - Fix article validation ID-456
            - Fix category tree building ID-789
            EOL;
    }

    return new ReleaseDTO($version, $releaseNotes);
}
