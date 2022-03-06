<?php

declare(strict_types=1);

namespace MTK\Releaser\Git\Client;

use MTK\Releaser\Git\GitClient;

class GitCliClient implements GitClient
{
    public function add(string $path): void
    {
        shell_exec("git add $path");
    }

    public function commit(string $message): void
    {
        shell_exec("git commit -m '$message'");
    }

    public function tag(string $version): void
    {
        shell_exec("git tag -a $version -m 'Release'");
    }

    public function push(): void
    {
        shell_exec('git push --no-verify');
    }

    public function hasUncommittedChanges(): bool
    {
        $output = [];
        exec('git status --porcelain', $output);
        return count($output) > 0;
    }

    public function getUsername(): string
    {
        $username = shell_exec('git config user.name') ?: '';
        return trim($username);
    }
}
