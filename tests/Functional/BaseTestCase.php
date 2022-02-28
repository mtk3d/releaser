<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Functional;

use DI\Container;
use DI\ContainerBuilder;
use MTK\Releaser\Kernel;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    protected Container $container;
    protected Kernel $app;

    public function setUp(): void
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(services());
        $builder->addDefinitions(dev_services());
        $this->container = $builder->build();

        $this->app = new Kernel("Releaser", "0.1.0", $this->container);
    }
}