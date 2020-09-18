<?php


namespace MTK\Releaser\Common;

use Symfony\Component\Console\Output\StreamOutput;

trait OutputTestUtils
{
    public static function getStreamOutput(): StreamOutput
    {
        return new StreamOutput(fopen('php://memory', 'w', false));
    }

    public static function getDisplay(StreamOutput $output): string
    {
        rewind($output->getStream());
        return stream_get_contents($output->getStream());
    }
}
