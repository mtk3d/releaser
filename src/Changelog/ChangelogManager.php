<?php


namespace MTK\Releaser\Changelog;

interface ChangelogManager
{
    public function save(Changelog $changelog): void;

    public function getChangelog(): Changelog;
}
