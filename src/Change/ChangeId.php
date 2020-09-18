<?php


namespace MTK\Releaser\Change;

class ChangeId
{
    /**
     * @var string
     */
    private string $changeId;

    public function __construct(string $changeId)
    {
        $this->changeId = $changeId;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->changeId;
    }
}
