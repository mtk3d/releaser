<?php

namespace MTK\Releaser\Changelog;

use Munus\Collection\GenericList;
use MTK\Releaser\Common\ReleaseDTO;

class Changelog
{
    /**
     * @var GenericList<ReleaseDTO>
     */
    private GenericList $releases;

    /**
     * Changelog constructor.
     * @param GenericList<ReleaseDTO> $releases
     */
    public function __construct(GenericList $releases)
    {
        $this->releases = $releases;
    }

    public static function empty(): Changelog
    {
        return new Changelog(GenericList::empty());
    }

    /**
     * @param ReleaseDTO $release
     */
    public function append(ReleaseDTO $release): void
    {
        $this->releases = $this->releases->prepend($release);
    }

    /**
     * @return GenericList<ReleaseDTO>
     */
    public function getListReleaseDTO(): GenericList
    {
        return $this->releases;
    }
}