<?php

namespace MTK\Releaser\Shared;

use Noodlehaus\AbstractConfig;

class AppConfig extends AbstractConfig
{
    /**
     * @return array<string|array>
     */
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
