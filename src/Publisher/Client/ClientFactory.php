<?php


namespace MTK\Releaser\Publisher\Client;


use Munus\Collection\GenericList;
use MTK\Releaser\Common\AppConfig;
use MTK\Releaser\Publisher\PublisherClient;
use Webmozart\Assert\Assert;

class ClientFactory
{
    /**
     * @var AppConfig
     */
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
        return GenericList::ofAll($this->config->get('publishers'))
            ->map(function (array $config): PublisherClient {
                Assert::true(isset($config['class']), "Publisher config error");
                return new $config['class']($config);
            });
    }
}