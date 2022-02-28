<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Shared\ReleaseDTO;

interface PublisherClient
{
    public function publish(ReleaseDTO $release): void;
}
