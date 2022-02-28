<?php

declare(strict_types=1);


namespace MTK\Releaser\Shared\Common;

use Symfony\Component\Console\Output\StreamOutput;

trait OutputTestUtils
{
    public static function getStreamOutput(): StreamOutput
    {
        $resource = fopen('php://memory', 'w', false);
        if (!$resource) {
            throw new \RuntimeException("Cannot open in memory resource");
        }

        return new StreamOutput($resource);
    }

    public static function getDisplay(StreamOutput $output): string
    {
        rewind($output->getStream());
        return stream_get_contents($output->getStream()) ?: '';
    }
}
