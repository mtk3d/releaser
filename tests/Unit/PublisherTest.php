<?php


namespace MTK\Releaser\Publisher;

use MTK\Releaser\Shared\ReleaseDTO;
use MTK\Releaser\Publisher\Client\ClientFactory;
use Munus\Collection\GenericList;
use PHPUnit\Framework\TestCase;

class PublisherTest extends TestCase
{
    public function testPublishRelease(): void
    {
        $releaseNotes = <<<EOL
            ### Feature (1)
            - Add article draft functionality ID-123
            ### Fix (2)
            - Fix article validation ID-456
            - Fix category tree building ID-789
            EOL;

        $release = new ReleaseDTO("2.0.0", $releaseNotes);

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
