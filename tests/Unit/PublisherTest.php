<?php

declare(strict_types=1);


namespace MTK\Releaser\Tests\Unit;

use MTK\Releaser\Publisher\Client\ClientFactory;
use MTK\Releaser\Publisher\PublisherClient;
use MTK\Releaser\Publisher\PublisherConfiguration;
use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;

class PublisherTest extends TestCase
{
    private PublisherConfiguration $publisherConfig;

    public function setUp(): void
    {
        $this->publisherConfig = new PublisherConfiguration();
    }

    public function testPublishRelease(): void
    {
        $release = aRelease();

        $publisher = self::createMock(PublisherClient::class);
        $publisher->expects(self::exactly(2))
            ->method('publish')
            ->with($release);

        $clientFactory = self::createMock(ClientFactory::class);
        $clientFactory->method('getPublishers')
            ->willReturn(GenericList::of($publisher, $publisher));

        $publisher = $this->publisherConfig->publisherFacade($clientFactory);
        $publisher->publish($release);
    }
}
