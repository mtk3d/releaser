<?php

namespace MTK\Releaser\Git\Client;

use MrRio\ShellWrap as sh;
use MrRio\ShellWrapException;
use MTK\Releaser\Git\GitClient;

class GitCliClient implements GitClient
{
    /**
     * @inheritDoc
     */
    public function add(string $path): void
    {
        sh::git('add', $path);
    }

    /**
     * @inheritDoc
     */
    public function commit(string $message): void
    {
        sh::git('commit', "-m", "\"$message\"");
    }

    /**
     * @inheritDoc
     */
    public function tag(string $version): void
    {
        sh::git('tag', '-a', $version, '-m', 'Release');
    }

    public function push(): void
    {
        sh::git('push', '--no-verify');
    }

    public function hasUncommittedChanges(): bool
    {
        try {
            sh::git('git', 'status', '--porcelain');
        } catch (ShellWrapException $e) {
            return true;
        }

        return false;
    }
}
