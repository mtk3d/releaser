<?php


namespace MTK\Releaser\Git;

use MTK\Releaser\Git\Client\GitCliClient;
use MTK\Releaser\Shared\AppConfig;

class GitConfiguration
{
    /**
     * @param GitClient $gitClient
     * @param AppConfig|null $appConfig
     * @return GitFacade
     */
    public function gitFacade(?GitClient $gitClient = null, ?AppConfig $appConfig = null): GitFacade
    {
        if (!$gitClient) {
            $gitClient = new GitCliClient();
        }

        if (!$appConfig) {
            $appConfig = new AppConfig([]);
        }

        return new GitFacade($gitClient, $appConfig);
    }
}
