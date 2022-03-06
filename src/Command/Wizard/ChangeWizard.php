<?php

declare(strict_types=1);

namespace MTK\Releaser\Command\Wizard;

use Exception;
use MTK\Releaser\Change\ChangeType;
use MTK\Releaser\Command\Change\AuthorProvider;
use MTK\Releaser\Shared\ChangeDTO;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeWizard
{
    private AuthorProvider $authorProvider;

    public function __construct(AuthorProvider $authorProvider)
    {
        $this->authorProvider = $authorProvider;
    }

    public function run(SymfonyStyle $io): ChangeDTO
    {
        $type = $io->ask(
            "What's the type of your change? [fix|feature|deprecation|security|performance|other]",
            null,
            function (string $value) {
                if (!ChangeType::isValid($value)) {
                    throw new Exception('Change type is invalid');
                }
                return $value;
            }
        );
        $message = $io->ask("What is your change about?");
        $changeId = $io->ask("What's the ID of the change? Ex. Jira ID");
        $author = $io->ask("Who made the change? Leave empty to get from git config");

        $author = $author ?: $this->authorProvider->getAuthor();

        return new ChangeDTO($type, $message, $author, $changeId);
    }
}
