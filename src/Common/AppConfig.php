<?php

namespace MTK\Releaser\Common;

use Noodlehaus\AbstractConfig;

class AppConfig extends AbstractConfig
{
    protected function getDefaults(): array
    {
        return [
            "changesDirectory" => ".unreleased",
            "changelogName" => "CHANGELOG.md",
            "git" => [
                "enabled" => true,
                "push" => true,
                "commitMessage" => "Update changelog"
            ],
            "publishers" => []
        ];
    }
}
