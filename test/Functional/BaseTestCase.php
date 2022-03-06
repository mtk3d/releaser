<?php

declare(strict_types=1);

namespace MTK\Releaser\Test\Functional;

use DI\Container;
use DI\ContainerBuilder;
use MTK\Releaser\Application;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Kernel;
use MTK\Releaser\Shared\AppConfig;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

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
        $builder->addDefinitions(test_services());
        $this->container = $builder->build();

        $app = new Application($this->container);
        $this->app = $app->app();
    }

    public function tearDown(): void
    {
        $changeFacade = $this->container->get(ChangeFacade::class);
        $changeFacade->clearChanges();

        $config = $this->container->get(AppConfig::class);
        $filesystem = $this->container->get(Filesystem::class);
        $filesystem->remove($config->get('changelogName'));
        $filesystem->remove($config->get('changesDirectory'));
    }
}
