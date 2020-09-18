<?php


namespace MTK\Releaser\Release;

use PHLAK\SemVer;
use PHLAK\SemVer\Exceptions\InvalidVersionException;

class Version
{
    /**
     * @var SemVer\Version
     */
    private SemVer\Version $version;

    /**
     * Version constructor.
     * @param SemVer\Version $version
     */
    public function __construct(SemVer\Version $version)
    {
        $this->version = $version;
    }

    /**
     * @param string $version
     * @return Version
     * @throws InvalidVersionException
     */
    public static function of(string $version): Version
    {
        return new Version(SemVer\Version::parse($version));
    }

    /**
     * @param ReleaseType $release
     * @return Version
     */
    public function next(ReleaseType $release)
    {
        $version = clone $this->version; // immutable
        $method = "increment" . ucfirst($release->getValue());
        $version->$method();

        return new Version($version);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->version;
    }
}
