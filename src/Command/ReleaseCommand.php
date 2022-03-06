<?php

declare(strict_types=1);

namespace MTK\Releaser\Command;

use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use MTK\Releaser\Command\Wizard\ReleaseWizard;
use PHLAK\SemVer\Exceptions\InvalidVersionException;
use Silly\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReleaseCommand extends Command
{
    private PrepareContext $prepareContext;
    private PublishContext $publishContext;
    private ReleaseWizard $releaseWizard;

    public function __construct(
        PrepareContext $prepareContext,
        PublishContext $publishContext,
        ReleaseWizard $releaseWizard
    ) {
        parent::__construct('release');
        $this->prepareContext = $prepareContext;
        $this->publishContext = $publishContext;
        $this->releaseWizard = $releaseWizard;
    }

    public function __invoke(
        ?string $startVersion,
        ?string $semverPart,
        InputInterface $input,
        OutputInterface $output
    ): int {
        if (empty($semverPart)) {
            list($startVersion, $semverPart) = $this->releaseWizard->run(new SymfonyStyle($input, $output));
        }

        if ($this->publishContext->hasUncommittedChanges()) {
            $output->write("You have uncommitted changes in your repository", true);
            return 1;
        }

        try {
            $release = $this->prepareContext->prepareRelease($semverPart, $startVersion);
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
