<?php


namespace MTK\Releaser\Release;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 * @method static ReleaseType MAJOR()
 * @method static ReleaseType MINOR()
 * @method static ReleaseType PATCH()
 */
class ReleaseType extends Enum
{
    private const PATCH = 'major';
    private const MAJOR = 'minor';
    private const MINOR = 'patch';
}
