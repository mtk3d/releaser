<?php

declare(strict_types=1);


namespace MTK\Releaser\Change;

class ChangeId
{
    private string $changeId;

    public function __construct(string $changeId)
    {
        $this->changeId = $changeId;
    }

    public function __toString(): string
    {
        return $this->changeId;
    }
}
