<?php

declare(strict_types=1);


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Publisher\Client\ClientFactory;
use MTK\Releaser\Shared\AppConfig;

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
