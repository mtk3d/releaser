<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Functional;

use DI\Container;
use DI\ContainerBuilder;
use MTK\Releaser\Application;
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

        $app = new Application($this->container);
        $this->app = $app->app();
    }
}
