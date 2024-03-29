<?php

declare(strict_types=1);


namespace MTK\Releaser\Git;

interface GitClient
{
    public function add(string $path): void;

    public function commit(string $message): void;

    public function tag(string $version): void;

    public function push(): void;

    public function hasUncommittedChanges(): bool;

    public function getUsername(): string;
}
