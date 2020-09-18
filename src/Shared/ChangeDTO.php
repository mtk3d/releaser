<?php


namespace MTK\Releaser\Shared;

use Webmozart\Assert\Assert;

class ChangeDTO
{
    /**
     * @var string
     */
    private string $type;
    /**
     * @var string
     */
    private string $message;
    /**
     * @var string
     */
    private string $author;
    /**
     * @var string
     */
    private string $changeId;

    /**
     * ChangeDTO constructor.
     * @param string $type
     * @param string $message
     * @param string $author
     * @param string $changeId
     */
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getChangeId(): string
    {
        return $this->changeId;
    }

    /**
     * @return string
     */
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
