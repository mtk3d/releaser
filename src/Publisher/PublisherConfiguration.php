<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Publisher\Client\ClientFactory;

class PublisherConfiguration
{
    public function publisherFacade(?ClientFactory $clientFactory = null): PublisherFacade
    {
        if (!$clientFactory) {
            $clientFactory = new ClientFactory(new AppConfig([]));
        }

        return new PublisherFacade($clientFactory);
    }
}
