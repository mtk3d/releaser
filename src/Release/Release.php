<?php

declare(strict_types=1);

namespace MTK\Releaser\Release;

use MTK\Releaser\Shared\ReleaseDTO;

class Release
{
    private Version $version;
    private ReleaseNotes $releaseNotes;

    public function __construct(Version $version, ReleaseNotes $releaseNotes)
    {
        $this->version = $version;
        $this->releaseNotes = $releaseNotes;
    }

    public function getReleaseDTO(): ReleaseDTO
    {
        return new ReleaseDTO((string)$this->version, (string)$this->releaseNotes);
    }
}
