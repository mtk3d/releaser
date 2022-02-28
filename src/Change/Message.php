<?php

declare(strict_types=1);


namespace MTK\Releaser\Change;

use Webmozart\Assert\Assert;

class Message
{
    private string $message;

    public function __construct(string $message)
    {
        Assert::stringNotEmpty($message, "Message should be not empty string");
        $this->message = $message;
    }

    public function __toString(): string
    {
        return $this->message;
    }
}
