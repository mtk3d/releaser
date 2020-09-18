<?php


namespace MTK\Releaser\Release;

class ReleaseConfiguration
{
    /**
     * @return ReleaseFacade
     */
    public function releaseFacade(): ReleaseFacade
    {
        return new ReleaseFacade();
    }
}
