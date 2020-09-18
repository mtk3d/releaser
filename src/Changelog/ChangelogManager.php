<?php


namespace MTK\Releaser\Changelog;

interface ChangelogManager
{
    /**
     * @param Changelog $changelog
     */
    public function save(Changelog $changelog): void;

    /**
     * @return Changelog
     */
    public function getChangelog(): Changelog;
}
