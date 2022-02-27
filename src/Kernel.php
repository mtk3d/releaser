<?php

namespace MTK\Releaser;

use DI\ContainerBuilder;
use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Change\ChangeManager;
use MTK\Releaser\Change\Infrastructure\FileChangeManager;
use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Changelog\ChangelogManager;
use MTK\Releaser\Changelog\Infrastructure\FileChangelogManager;
use MTK\Releaser\Git\Client\GitCliClient;
use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Git\GitConfiguration;
use MTK\Releaser\Git\GitFacade;
use MTK\Releaser\Publisher\Client\ClientFactory;
use MTK\Releaser\Publisher\PublisherConfiguration;
use MTK\Releaser\Publisher\PublisherFacade;
use MTK\Releaser\Release\ReleaseConfiguration;
use MTK\Releaser\Release\ReleaseFacade;
use MTK\Releaser\Shared\AppConfig;
use Noodlehaus\Config;
use Noodlehaus\Parser\Yaml;
use Silly\Edition\PhpDi\Application;
use Symfony\Component\Filesystem\Filesystem;
use function DI\autowire;
use function DI\factory;

class Kernel extends Application
{
    public const CONFIG_FILE = 'releaser.yaml';

    protected function createContainer()
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            // Config
            AppConfig::class => fn (): AppConfig => new AppConfig(Config::load(self::CONFIG_FILE, new Yaml())->all()),
            // Facades
            ChangeFacade::class => factory([ChangeConfiguration::class, 'changeFacade']),
            ChangelogFacade::class => factory([ChangelogConfiguration::class, 'changelogFacade']),
            GitFacade::class => factory([GitConfiguration::class, 'gitFacade']),
            PublisherFacade::class => factory([PublisherConfiguration::class, 'publisherFacade']),
            ReleaseFacade::class => factory([ReleaseConfiguration::class, 'releaseFacade']),
            // Dependencies
            ChangeManager::class => autowire(FileChangeManager::class),
            ChangelogManager::class => autowire(FileChangelogManager::class),
            ClientFactory::class => autowire(ClientFactory::class),
            GitClient::class => autowire(GitCliClient::class),
            Filesystem::class => autowire(Filesystem::class),
        ]);

        return $builder->build(); // return the customized container
    }
}
