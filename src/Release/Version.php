<?php

declare(strict_types=1);


namespace MTK\Releaser\Release;

use PHLAK\SemVer;
use PHLAK\SemVer\Exceptions\InvalidVersionException;

class Version
{
    private SemVer\Version $version;

    public function __construct(SemVer\Version $version)
    {
        $this->version = $version;
    }

    /**
     * @throws InvalidVersionException
     */
    public static function of(string $version): Version
    {
        return new Version(SemVer\Version::parse($version));
    }

    public function next(ReleaseType $release): Version
    {
        $version = clone $this->version; // keep immutable
        $method = "increment" . ucfirst($release->getValue());
        $version->$method();

        return new Version($version);
    }

    public function __toString(): string
    {
        return (string)$this->version;
    }
}
