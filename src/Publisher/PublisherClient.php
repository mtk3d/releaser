<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Common\ReleaseDTO;

interface PublisherClient
{
    /**
     * @param ReleaseDTO $release
     */
    public function publish(ReleaseDTO $release): void;
}
