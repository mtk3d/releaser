<?php


namespace MTK\Releaser\Publisher;

use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;
use MTK\Releaser\Common\ReleaseDTO;
use MTK\Releaser\Publisher\Client\ClientFactory;

class PublisherTest extends TestCase
{
    public function testPublishRelease(): void
    {
        $release = new ReleaseDTO("2.0.0", "### Feature (1)\n- Something new PJ-789\n### Fix (2)\n- Fixed something PJ-123\n- Fixed something else PJ-456\n");

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
