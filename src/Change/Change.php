<?php

namespace MTK\Releaser\Change;

use MTK\Releaser\Shared\ChangeDTO;

class Change
{
    /**
     * @var ChangeType
     */
    private ChangeType $type;
    /**
     * @var Message
     */
    private Message $message;
    /**
     * @var Author
     */
    private Author $author;
    /**
     * @var ChangeId
     */
    private ChangeId $changeId;

    /**
     * Change constructor.
     * @param ChangeType $type
     * @param Message $message
     * @param Author $author
     * @param ChangeId $changeId
     */
    public function __construct(ChangeType $type, Message $message, Author $author, ChangeId $changeId)
    {
        $this->type = $type;
        $this->message = $message;
        $this->author = $author;
        $this->changeId = $changeId;
    }

    public static function fromDto(ChangeDTO $changeDto): Change
    {
        return new Change(
            new ChangeType($changeDto->getType()),
            new Message($changeDto->getMessage()),
            new Author($changeDto->getAuthor()),
            new ChangeId($changeDto->getChangeId())
        );
    }

    /**
     * @return ChangeDTO
     */
    public function getChangeDTO(): ChangeDTO
    {
        return new ChangeDTO($this->type, $this->message, $this->author, $this->changeId);
    }
}
