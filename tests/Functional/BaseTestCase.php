<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Functional;

use DI\Container;
use DI\ContainerBuilder;
use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\ReleaseCommand;
use MTK\Releaser\Kernel;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    protected const TEST_DIR = 'test-env';
    protected Container $container;
    protected Kernel $app;

    public function setUp(): void
    {
        if (!file_exists(self::TEST_DIR)) {
            mkdir(self::TEST_DIR, 0777, true);
        }
        chdir(self::TEST_DIR);

        $builder = new ContainerBuilder();
        $builder->addDefinitions(services());
        $builder->addDefinitions(dev_services());
        $this->container = $builder->build();

        $this->app = new Kernel("Releaser", "0.1.0", $this->container);

        $this->app->command('new [type] [message] [changeId] [author]', ChangeCommand::class)
            ->descriptions(
                'Create new changelog entry',
                [
                    'type' => 'Type of entry [fix|feature|deprecation|security|performance|other]',
                    'message' => 'Information what was changed',
                    'changeId' => 'Identity of change in your workflow (ex. canban ticket ID)'
                ]
            );

        $this->app->command('release [--ver=] [type]', ReleaseCommand::class)
            ->descriptions(
                'Create and publish new release',
                [
                    'type' => 'Type of release [patch|major|minor|rc]',
                    '--ver' => 'Version of next release (optional)',
                ]
            );
    }
}
