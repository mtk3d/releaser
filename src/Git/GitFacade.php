<?php

declare(strict_types=1);

namespace MTK\Releaser\Git;

use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Shared\ReleaseDTO;

class GitFacade
{
    private GitClient $git;
    private AppConfig $appConfig;

    public function __construct(GitClient $gitClient, AppConfig $appConfig)
    {
        $this->git = $gitClient;
        $this->appConfig = $appConfig;
    }

    public function createRelease(ReleaseDTO $release): void
    {
        if ($this->appConfig->get('git.enabled')) {
            $this->git->add('.');
            $this->git->commit($this->appConfig->get('git.commitMessage'));
            $this->git->tag($release->getVersion());

            if ($this->appConfig->get('git.push')) {
                $this->git->push();
            }
        }
    }

    public function hasUncommittedChanges(): bool
    {
        if (!$this->appConfig->get('git.enabled')) {
            return false;
        }

        return $this->git->hasUncommittedChanges();
    }
}
