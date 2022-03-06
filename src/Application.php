<?php

declare(strict_types=1);

namespace MTK\Releaser;

use DI\Container;
use Exception;
use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\ReleaseCommand;

class Application
{
    private Kernel $app;

    public function __construct(Container $container = null)
    {
        $this->app = new Kernel("Releaser", "0.1.0", $container);

        $this->app->command('new [type] [message] [changeId] [author]', ChangeCommand::class)
            ->descriptions(
                'Create new changelog entry',
                [
                    'type' => 'Type of entry [fix|feature|deprecation|security|performance|other]',
                    'message' => 'Information what was changed',
                    'changeId' => 'Identity of change in your workflow (ex. canban ticket ID)',
                    'author' => 'Change author if different than git user',
                ]
            );

        $this->app->command('release [--start-version=] [semverPart]', ReleaseCommand::class)
            ->descriptions(
                'Create and publish new release',
                [
                    'semverPart' => 'Semver part to update [patch|major|minor|rc]',
                    '--start-version' => 'Version of next release (optional)',
                ]
            );
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->app->run();
    }

    public function app(): Kernel
    {
        return $this->app;
    }
}
