<?php

namespace MTK\Releaser\Publisher;

use MTK\Releaser\Shared\ReleaseDTO;
use MTK\Releaser\Publisher\Client\ClientFactory;
use Munus\Collection\GenericList;

class PublisherFacade
{
    /**
     * @var GenericList<PublisherClient>
     */
    private GenericList $publishers;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->publishers = $clientFactory->getPublishers();
    }

    public function publish(ReleaseDTO $release): void
    {
        $this->publishers->forEach(
            function (PublisherClient $publisher) use ($release): void {
                $publisher->publish($release);
            }
        );
    }
}
