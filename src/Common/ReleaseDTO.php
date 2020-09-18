<?php


namespace MTK\Releaser\Common;

use Webmozart\Assert\Assert;

class ReleaseDTO
{
    /**
     * @var string
     */
    private string $version;
    /**
     * @var string
     */
    private string $releaseNotes;

    /**
     * ReleaseDTO constructor.
     * @param string $version
     * @param string $releaseNotes
     */
    public function __construct(string $version, string $releaseNotes)
    {
        Assert::stringNotEmpty($version, "Version must be not empty in " . __CLASS__);

        $this->version = $version;
        $this->releaseNotes = $releaseNotes;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getReleaseNotes(): string
    {
        return trim($this->releaseNotes) . PHP_EOL;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return <<<EOL
            Version: $this->version
            Release notes:
            $this->releaseNotes\n
            EOL;
    }
}
