<?php

namespace MTK\Releaser\Command;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Common\ChangeDTO;
use Silly\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeCommand extends Command
{
    /**
     * @param string $type
     * @param string $message
     * @param string|null $changeId
     * @param string|null $author
     * @param ChangeFacade $changeFacade
     * @param OutputInterface $output
     * @return int
     */
    public function __invoke(
        string $type,
        string $message,
        ?string $changeId,
        ?string $author,
        ChangeFacade $changeFacade,
        OutputInterface $output
    ): int {
        $changeId = $changeId ?: "";

        if ($author === null) {
            // @TODO Take author from git or config or something else
            $author = "John Doe";
        }

        $changeFacade->create(new ChangeDTO($type, $message, $author, $changeId));

        $output->writeln("Unreleased changes:");
        $changeFacade->getAllChanges()->forEach(function (ChangeDTO $change) use ($output): void {
            $output->write((string)$change);
        });
        $output->write("", true);
        $output->write("Change created successfully", true);

        return 0;
    }
}
