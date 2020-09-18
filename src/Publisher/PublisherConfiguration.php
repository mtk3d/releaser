<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Common\AppConfig;
use MTK\Releaser\Publisher\Client\ClientFactory;

class PublisherConfiguration
{
    /**
     * @param ClientFactory|null $clientFactory
     * @return PublisherFacade
     */
    public function publisherFacade(?ClientFactory $clientFactory = null): PublisherFacade
    {
        if (!$clientFactory) {
            $clientFactory = new ClientFactory(new AppConfig([]));
        }

        return new PublisherFacade($clientFactory);
    }
}
