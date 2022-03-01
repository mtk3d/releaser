<?php

declare(strict_types=1);

namespace MTK\Releaser\Command;

use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use Silly\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class ReleaseCommand extends Command
{
    private PrepareContext $prepareContext;
    private PublishContext $publishContext;

    public function __construct(PrepareContext $prepareContext, PublishContext $publishContext)
    {
        parent::__construct('release');
        $this->prepareContext = $prepareContext;
        $this->publishContext = $publishContext;
    }

    public function __invoke(
        ?string $ver,
        ?string $type,
        OutputInterface $output
    ): int {
        if ($this->publishContext->hasUncommittedChanges()) {
            $output->write("You have uncommitted changes in your repository", true);
            return 1;
        }

        try {
            $release = $this->prepareContext->prepareRelease($type, $ver);
        } catch (InvalidVersionException $e) {
            $output->write("Version format error", true);
            return 1;
        }

        $this->publishContext->publish($release);

        $output->write("Release details:", true);
        $output->write((string)$release);
        $output->write("Release created successfully", true);

        $this->prepareContext->clearChanges();

        return 0;
    }
}
