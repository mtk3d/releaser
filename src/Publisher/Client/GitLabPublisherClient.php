<?php

namespace MTK\Releaser\Publisher\Client;

use GuzzleHttp;
use MTK\Releaser\Publisher\PublisherClient;
use Webmozart\Assert\Assert;
use MTK\Releaser\Shared\ReleaseDTO;

class GitLabPublisherClient implements PublisherClient
{
    private string $projectId;
    private string $privateToken;
    private GuzzleHttp\Client $client;

    /**
     * GitlabReleasePublisher constructor.
     * @param array<string> $config
     */
    public function __construct(array $config)
    {
        Assert::stringNotEmpty($config['projectId'], "Property 'projectId' of " . __CLASS__ . " is empty");
        Assert::stringNotEmpty($config['privateToken'], "Property 'privateToken' of " . __CLASS__ . " is empty");
        Assert::stringNotEmpty($config['gitlabUrl'], "Property 'gitlabUrl' of " . __CLASS__ . " is empty");

        $this->projectId = $config['projectId'];
        $this->privateToken = $config['privateToken'];
        $this->client = new GuzzleHttp\Client(['base_uri' => $config['gitlabUrl']]);
    }

    public function publish(ReleaseDTO $release): void
    {
        $this->client->request(
            'POST',
            "/projects/{$this->projectId}/releases",
            [
                'body' => [
                    'name' => 'Release',
                    'tag_name' => $release->getVersion(),
                    'description' => $release->getReleaseNotes()
                ]
            ]
        );
    }
}
