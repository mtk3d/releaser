<?php


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Publisher\PublisherClient;
use MTK\Releaser\Publisher\PublisherConfiguration;
use MTK\Releaser\Shared\ReleaseDTO;
use MTK\Releaser\Publisher\Client\ClientFactory;
use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;

class PublisherTest extends TestCase
{
    public function testPublishRelease(): void
    {
        $release = aRelease();

        $publisher = $this->createMock(PublisherClient::class);
        $publisher->expects($this->exactly(2))
            ->method('publish')
            ->with($release);

        $clientFactory = $this->createMock(ClientFactory::class);
        $clientFactory->method('getPublishers')
            ->willReturn(GenericList::of($publisher, $publisher));

        $publisher = (new PublisherConfiguration())->publisherFacade($clientFactory);

        $publisher->publish($release);
    }
}
