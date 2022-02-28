<?php

declare(strict_types=1);

namespace MTK\Releaser\Change;

use MTK\Releaser\Shared\ChangeDTO;

class Change
{
    private ChangeType $type;
    private Message $message;
    private Author $author;
    private ChangeId $changeId;

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

    public function getChangeDTO(): ChangeDTO
    {
        return new ChangeDTO(
            (string) $this->type,
            (string) $this->message,
            (string) $this->author,
            (string) $this->changeId
        );
    }
}
