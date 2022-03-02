<?php

declare(strict_types=1);

use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Shared\AppConfig;
use function DI\value;

function dev_services(): array
{
    $gitConfig = [
        "enabled" => false,
        "push" => true,
        "commitMessage" => "Update changelog",
        "useAuthor" => true,
    ];

    return [
        AppConfig::class => value(new AppConfig(["git" => $gitConfig])),
        GitClient::class => value(null)
    ];
}
