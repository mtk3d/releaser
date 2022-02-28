<?php

declare(strict_types=1);

namespace MTK\Releaser;

use DI\Container;
use DI\ContainerBuilder;
use Silly\Edition\PhpDi\Application;

class Kernel extends Application
{
    public const CONFIG_FILE = 'releaser.yaml';

    protected function createContainer(): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(services(self::CONFIG_FILE));

        return $builder->build(); // return the customized container
    }
}
