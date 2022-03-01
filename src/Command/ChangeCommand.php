<?php

declare(strict_types=1);

namespace MTK\Releaser\Command;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Shared\ChangeDTO;
use Silly\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeCommand extends Command
{
    private ChangeFacade $changeFacade;

    public function __construct(
        ChangeFacade $changeFacade
    ) {
        parent::__construct('change');
        $this->changeFacade = $changeFacade;
    }

    public function __invoke(
        string $type,
        string $message,
        ?string $changeId,
        ?string $author,
        OutputInterface $output
    ): int {
        $changeId = $changeId ?: "";

        if ($author === null) {
            // @TODO Take author from git or config or something else
            $author = "John Doe";
        }

        $this->changeFacade->create(new ChangeDTO($type, $message, $author, $changeId));

        $output->writeln("Changes to release:");
        $this->changeFacade->getAllChanges()->forEach(function (ChangeDTO $change) use ($output): void {
            $output->write((string)$change);
        });
        $output->write("", true);
        $output->write("Change created successfully", true);

        return 0;
    }
}
