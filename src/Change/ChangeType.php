<?php


namespace MTK\Releaser\Change;

use MyCLabs\Enum\Enum;

/**
 * @extends Enum<string>
 * @method static ChangeType FIX()
 * @method static ChangeType FEATURE()
 * @method static ChangeType DEPRECATION()
 * @method static ChangeType SECURITY()
 * @method static ChangeType PERFORMANCE()
 * @method static ChangeType OTHER()
 */
class ChangeType extends Enum
{
    private const FIX = 'fix';
    private const FEATURE = 'feature';
    private const DEPRECATION = 'deprecation';
    private const SECURITY = 'security';
    private const PERFORMANCE = 'performance';
    private const OTHER = 'other';
}
