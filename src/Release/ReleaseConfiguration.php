<?php


namespace MTK\Releaser\Release;

class ReleaseConfiguration
{
    public function releaseFacade(): ReleaseFacade
    {
        return new ReleaseFacade();
    }
}
