<?php

declare(strict_types=1);

namespace MTK\Releaser\Git\Client;

use MrRio\ShellWrap as sh;
use MrRio\ShellWrapException;
use MTK\Releaser\Git\GitClient;

class GitCliClient implements GitClient
{
    public function add(string $path): void
    {
        /* @phpstan-ignore-next-line */
        sh::git('add', $path);
    }

    public function commit(string $message): void
    {
        /* @phpstan-ignore-next-line */
        sh::git('commit', "-m", "\"$message\"");
    }

    public function tag(string $version): void
    {
        /* @phpstan-ignore-next-line */
        sh::git('tag', '-a', $version, '-m', 'Release');
    }

    public function push(): void
    {
        /* @phpstan-ignore-next-line */
        sh::git('push', '--no-verify');
    }

    public function hasUncommittedChanges(): bool
    {
        try {
            /* @phpstan-ignore-next-line */
            sh::git('git', 'status', '--porcelain');
        } catch (ShellWrapException $e) {
            return true;
        }

        return false;
    }

    public function getUsername(): string
    {
        /* @phpstan-ignore-next-line */
        return sh::git('git', 'config', 'user.name');
    }
}
