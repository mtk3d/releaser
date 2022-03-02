<?php

declare(strict_types=1);

namespace MTK\Releaser\Test\Functional;

use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Test\Common\OutputTestUtils;

class GitIntegrationTest extends BaseTestCase
{
    use OutputTestUtils;

    public function testReleaseWithUncommittedChanges(): void
    {
        $gitClientMock = self::createMock(GitClient::class);
        $gitClientMock->method('hasUncommittedChanges')
            ->willReturn(true);

        $this->container->set(GitClient::class, $gitClientMock);

        $appConfig = $this->container->get(AppConfig::class);
        $appConfig->set('git.enabled', true);

        $output = self::getStreamOutput();

        $this->app->runCommand(
            'release minor',
            $output
        );

        self::assertEquals(
            "You have uncommitted changes in your repository\n",
            self::getDisplay($output)
        );
    }

    public function testCommitNewChangelogVersion(): void
    {
        $gitClientMock = self::createMock(GitClient::class);
        $gitClientMock->expects(self::once())->method('add')->with('CHANGELOG.md');
        $gitClientMock->expects(self::once())->method('commit')->with('Update changelog');
        $gitClientMock->expects(self::once())->method('tag')->with('0.1.0');
        $gitClientMock->expects(self::once())->method('push');

        $this->container->set(GitClient::class, $gitClientMock);

        $appConfig = $this->container->get(AppConfig::class);
        $appConfig->set('git.enabled', true);
        $appConfig->set('git.push', true);

        $this->app->runCommand(
            'release minor',
            self::getStreamOutput()
        );
    }
}
