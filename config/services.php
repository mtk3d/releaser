<?php

declare(strict_types=1);

use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Change\ChangeManager;
use MTK\Releaser\Change\Infrastructure\FileChangeManager;
use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Changelog\ChangelogManager;
use MTK\Releaser\Changelog\Infrastructure\FileChangelogManager;
use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\ReleaseCommand;
use MTK\Releaser\Command\Wizard\ChangeWizard;
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
use Symfony\Component\Filesystem\Filesystem;
use function DI\autowire;
use function DI\factory;

/**
 * @return array<string, mixed>
 */
function services(string $configFile = 'releaser.yaml'): array
{
    return [
        // Config
        AppConfig::class => fn (): AppConfig => new AppConfig(Config::load($configFile, new Yaml())->all()),
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
        // Commands
        ChangeCommand::class => autowire(ChangeCommand::class),
        ReleaseCommand::class => autowire(ReleaseCommand::class),
        ChangeWizard::class => autowire(ChangeWizard::class),
    ];
}
