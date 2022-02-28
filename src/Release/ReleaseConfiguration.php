<?php

declare(strict_types=1);


namespace MTK\Releaser\Release;

class ReleaseConfiguration
{
    public function releaseFacade(): ReleaseFacade
    {
        return new ReleaseFacade();
    }
}
