<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Shared\ReleaseDTO;

interface PublisherClient
{
    /**
     * @param ReleaseDTO $release
     */
    public function publish(ReleaseDTO $release): void;
}
