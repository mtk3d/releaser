<?php

declare(strict_types=1);

namespace MTK\Releaser\Command;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Command\Change\AuthorProvider;
use MTK\Releaser\Command\Wizard\ChangeWizard;
use MTK\Releaser\Shared\ChangeDTO;
use Silly\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ChangeCommand extends Command
{
    private ChangeFacade $changeFacade;
    private AuthorProvider $authorProvider;
    private ChangeWizard $changeWizard;

    public function __construct(
        ChangeFacade $changeFacade,
        AuthorProvider $authorProvider,
        ChangeWizard $changeWizard
    ) {
        parent::__construct('change');
        $this->changeFacade = $changeFacade;
        $this->authorProvider = $authorProvider;
        $this->changeWizard = $changeWizard;
    }

    public function __invoke(
        ?string $type,
        ?string $message,
        ?string $changeId,
        ?string $author,
        InputInterface $input,
        OutputInterface $output
    ): int {
        if (empty($type) || empty($message)) {
            $changeDto = $this->changeWizard->run(new SymfonyStyle($input, $output));
        } else {
            $changeId = $changeId ?: "";
            $author = $author ?: $this->authorProvider->getAuthor();

            $changeDto = new ChangeDTO($type, $message, $author, $changeId);
        }

        $this->changeFacade->create($changeDto);

        $output->writeln("Changes to release:");
        $this->changeFacade->getAllChanges()->forEach(function (ChangeDTO $change) use ($output): void {
            $output->write((string)$change);
        });
        $output->write("", true);
        $output->write("Change created successfully", true);

        return 0;
    }
}
