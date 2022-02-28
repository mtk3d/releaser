<?php

declare(strict_types=1);


namespace MTK\Releaser\Changelog;

interface ChangelogManager
{
    public function save(Changelog $changelog): void;

    public function getChangelog(): Changelog;
}
