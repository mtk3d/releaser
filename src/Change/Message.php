<?php


namespace MTK\Releaser\Change;

use Webmozart\Assert\Assert;

class Message
{
    /**
     * @var string
     */
    private string $message;

    /**
     * Message constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        Assert::stringNotEmpty($message, "Message should be not empty string");
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->message;
    }
}
