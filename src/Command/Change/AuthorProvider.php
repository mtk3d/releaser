<?php

declare(strict_types=1);

namespace MTK\Releaser\Command\Change;

use MTK\Releaser\Git\GitFacade;
use MTK\Releaser\Shared\AppConfig;

class AuthorProvider
{
    private GitFacade $gitFacade;
    private AppConfig $appConfig;

    public function __construct(
        GitFacade $gitFacade,
        AppConfig $appConfig
    ) {
        $this->gitFacade = $gitFacade;
        $this->appConfig = $appConfig;
    }

    public function getAuthor(): string
    {
        $defaultAuthor = $this->appConfig->get('defaultAuthor');
        if ($defaultAuthor) {
            return $defaultAuthor;
        }

        if ($this->appConfig->get('git.useAuthor')) {
            return $this->gitFacade->getUsername();
        }

        return '';
    }
}
