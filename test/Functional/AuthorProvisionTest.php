<?php

declare(strict_types=1);

namespace MTK\Releaser\Test\Functional;

use MTK\Releaser\Git\GitClient;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Test\Common\OutputTestUtils;

class AuthorProvisionTest extends BaseTestCase
{
    use OutputTestUtils;

    public function testProvideCommandAuthor(): void
    {
        $changeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123 "Foo Bar"',
            $changeOutput
        );

        self::assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   Foo Bar
            ChangeID: ID-123
            
            Change created successfully
            
            EOF,
            self::getDisplay($changeOutput)
        );
    }

    public function testProvideSettingsAuthor(): void
    {
        $appConfig = $this->container->get(AppConfig::class);
        $appConfig->set('defaultAuthor', 'Jane Doe');

        $changeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123',
            $changeOutput
        );

        self::assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   Jane Doe
            ChangeID: ID-123
            
            Change created successfully
            
            EOF,
            self::getDisplay($changeOutput)
        );
    }

    public function testProvideGitConfigAuthor(): void
    {
        $gitClientMock = self::createMock(GitClient::class);
        $gitClientMock->method('getUsername')
            ->willReturn('Hello World');

        $this->container->set(GitClient::class, $gitClientMock);

        $changeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123',
            $changeOutput
        );

        self::assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   Hello World
            ChangeID: ID-123
            
            Change created successfully
            
            EOF,
            self::getDisplay($changeOutput)
        );
    }

    public function testNotAllowUsingGitUsername(): void
    {
        $appConfig = $this->container->get(AppConfig::class);
        $appConfig->set('git.useAuthor', false);

        $changeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123',
            $changeOutput
        );

        self::assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   
            ChangeID: ID-123
            
            Change created successfully
            
            EOF,
            self::getDisplay($changeOutput)
        );
    }
}
