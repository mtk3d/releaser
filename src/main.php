<?php

use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\ReleaseCommand;
use MTK\Releaser\Kernel;

$app = new Kernel("Releaser", "0.1.0");

$app->command('new [type] [message] [changeId] [author]', ChangeCommand::class)
    ->descriptions(
        'Create new changelog entry',
        [
            'type' => 'Type of entry [fix|feature|deprecation|security|performance|other]',
            'message' => 'Information what was changed',
            'changeId' => 'Identity of change in your workflow (ex. canban ticket ID)'
        ]
    );

$app->command('release [--ver=] [type]', ReleaseCommand::class)
    ->descriptions(
        'Create and publish new release',
        [
            'type' => 'Type of release [patch|major|minor|rc]',
            '--ver' => 'Version of next release (optional)',
        ]
    );

$app->run();
