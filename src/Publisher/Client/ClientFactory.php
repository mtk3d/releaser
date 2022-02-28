<?php


namespace MTK\Releaser\Publisher\Client;

use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Publisher\PublisherClient;
use Munus\Collection\GenericList;
use Webmozart\Assert\Assert;

class ClientFactory
{
    private AppConfig $config;

    public function __construct(AppConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return GenericList<PublisherClient>
     */
    public function getPublishers(): GenericList
    {
        /** @var array<string> $publishers */
        $publishers = $this->config->get('publishers');

        /** @var GenericList<array<string>> $publishersConfig */
        $publishersConfig = GenericList::ofAll($publishers);

        return $publishersConfig
            ->map(function (array $config): PublisherClient {
                Assert::true(isset($config['class']), "Publisher config error");
                return new $config['class']($config);
            });
    }
}
