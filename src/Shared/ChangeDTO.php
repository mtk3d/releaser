<?php

declare(strict_types=1);


namespace MTK\Releaser\Shared;

use Webmozart\Assert\Assert;

class ChangeDTO
{
    private string $type;
    private string $message;
    private string $author;
    private string $changeId;

    public function __construct(string $type, string $message, string $author, string $changeId = "")
    {
        Assert::stringNotEmpty($type, "Type must be not empty in " . __CLASS__);
        Assert::stringNotEmpty($message, "Message must be not empty in " . __CLASS__);
        Assert::stringNotEmpty($author, "Author must be not empty in " . __CLASS__);

        $this->type = $type;
        $this->message = $message;
        $this->author = $author;
        $this->changeId = $changeId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getChangeId(): string
    {
        return $this->changeId;
    }

    public function __toString(): string
    {
        return <<<EOL
            ---
            Type:     $this->type
            Message:  $this->message
            Author:   $this->author
            ChangeID: $this->changeId\n
            EOL;
    }
}
