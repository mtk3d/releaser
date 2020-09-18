<?php


namespace MTK\Releaser\Git;

interface GitClient
{
    /**
     * @param string $path
     */
    public function add(string $path): void;

    /**
     * @param string $message
     */
    public function commit(string $message): void;

    /**
     * @param string $version
     */
    public function tag(string $version): void;

    public function push(): void;

    public function hasUncommittedChanges(): bool;
}
