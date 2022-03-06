<?php

declare(strict_types=1);

use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Shared\AppConfig;
use function DI\value;

function test_services(): array
{
    $gitConfig = [
        "enabled" => false,
        "useAuthor" => true,
        "push" => true,
        "commitMessage" => "Update changelog",
    ];

    return [
        AppConfig::class => value(new AppConfig(["git" => $gitConfig])),
        GitClient::class => value(null)
    ];
}
