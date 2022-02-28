<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Fixture;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use MTK\Releaser\Command\ReleaseCommand;
use Symfony\Component\Console\Output\OutputInterface;

function runFixChangeCommand(
    string $message,
    string $changeId,
    string $author,
    ChangeFacade $changeFacade,
    OutputInterface $output
): void {
    $changeCommand = new ChangeCommand();
    $changeCommand("fix", $message, $changeId, $author, $changeFacade, $output);
}

function runFeatureChangeCommand(
    string $message,
    string $changeId,
    string $author,
    ChangeFacade $changeFacade,
    OutputInterface $output
): void {
    $changeCommand = new ChangeCommand();
    $changeCommand("feature", $message, $changeId, $author, $changeFacade, $output);
}

function runReleaseMinorCommand(
    PrepareContext $prepareContext,
    PublishContext $publishContext,
    OutputInterface $output
): void {
    $releaseCommand = new ReleaseCommand();
    $releaseCommand(null, "minor", $prepareContext, $publishContext, $output);
}
