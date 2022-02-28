<?php

declare(strict_types=1);

use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Shared\AppConfig;
use function DI\value;

function dev_services(): array
{
    return [
        AppConfig::class => value(new AppConfig(["git" => ["enabled" => false]])),
        GitClient::class => value(null)
    ];
}
