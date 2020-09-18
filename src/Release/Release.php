<?php

namespace MTK\Releaser\Release;

use MTK\Releaser\Common\ReleaseDTO;

class Release
{
    /**
     * @var Version
     */
    private Version $version;
    /**
     * @var ReleaseNotes
     */
    private ReleaseNotes $releaseNotes;

    /**
     * Release constructor.
     * @param Version $version
     * @param ReleaseNotes $releaseNotes
     */
    public function __construct(Version $version, ReleaseNotes $releaseNotes)
    {
        $this->version = $version;
        $this->releaseNotes = $releaseNotes;
    }

    /**
     * @return ReleaseDTO
     */
    public function getReleaseDTO(): ReleaseDTO
    {
        return new ReleaseDTO((string)$this->version, (string)$this->releaseNotes);
    }
}
