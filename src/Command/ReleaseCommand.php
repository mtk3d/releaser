<?php

namespace MTK\Releaser\Command;

use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use Silly\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class ReleaseCommand extends Command
{
    public function __invoke(
        ?string $version,
        ?string $type,
        PrepareContext $prepareContext,
        PublishContext $publishContext,
        OutputInterface $output
    ): int {
        if ($publishContext->hasUncommittedChanges()) {
            $output->write("You have uncommitted changes in your repository", true);
            return 1;
        }

        try {
            $release = $prepareContext->prepareRelease($type, $version);
        } catch (InvalidVersionException $e) {
            $output->write("Version format error", true);
            return 1;
        }

        $publishContext->publish($release);

        $output->write("Release details:", true);
        $output->write((string)$release);
        $output->write("Release created successfully", true);

        $prepareContext->clearChanges();

        return 0;
    }
}
