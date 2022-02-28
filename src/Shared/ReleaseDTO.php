<?php


namespace MTK\Releaser\Shared;

use Webmozart\Assert\Assert;

class ReleaseDTO
{
    private string $version;
    private string $releaseNotes;

    public function __construct(string $version, string $releaseNotes)
    {
        Assert::stringNotEmpty($version, "Version must be not empty in " . __CLASS__);

        $this->version = $version;
        $this->releaseNotes = $releaseNotes;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getReleaseNotes(): string
    {
        return trim($this->releaseNotes) . PHP_EOL;
    }

    public function __toString(): string
    {
        return <<<EOL
            Version: $this->version
            Release notes:
            $this->releaseNotes\n
            EOL;
    }
}
