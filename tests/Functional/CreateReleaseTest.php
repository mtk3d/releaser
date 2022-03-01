<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Functional;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Shared\Common\OutputTestUtils;
use Symfony\Component\Filesystem\Filesystem;

class CreateReleaseTest extends BaseTestCase
{
    use OutputTestUtils;

    private AppConfig $config;

    public function setUp(): void
    {
        parent::setUp();

        $this->config = $this->container->get(AppConfig::class);
    }

    public function testCreateRelease(): void
    {
        /* 01 ADD FIX CHANGE */

        $fixChangeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123 "Foo Bar"',
            $fixChangeOutput
        );

        $this->assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   Foo Bar
            ChangeID: ID-123
            
            Change created successfully
            
            EOF,
            self::getDisplay($fixChangeOutput)
        );

        /* 02 ADD FEATURE CHANGE */

        $featureChangeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new feature "Add article draft functionality" ID-456 "John Doe"',
            $featureChangeOutput
        );

        $this->assertEquals(
            <<<EOF
            Changes to release:
            ---
            Type:     fix
            Message:  Fix article validation
            Author:   Foo Bar
            ChangeID: ID-123
            ---
            Type:     feature
            Message:  Add article draft functionality
            Author:   John Doe
            ChangeID: ID-456
            
            Change created successfully
            
            EOF,
            self::getDisplay($featureChangeOutput)
        );

        /* 03 RELEASE CHANGES */

        $releaseOutput = self::getStreamOutput();

        $this->app->runCommand(
            'release minor',
            $releaseOutput
        );

        $this->assertEquals(
            <<<EOF
            Release details:
            Version: 0.1.0
            Release notes:
            ### Fix (1)
            - Fix article validation ID-123
            ### Feature (1)
            - Add article draft functionality ID-456
            
            Release created successfully

            EOF,
            self::getDisplay($releaseOutput)
        );
    }

    public function testWrongVersion(): void
    {
        /* 01 ADD FIX CHANGE */

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123 "Foo Bar"',
            self::getStreamOutput()
        );

        /* 02 RELEASE CHANGES WITH WRONG VERSION */

        $releaseOutput = self::getStreamOutput();

        $this->app->runCommand(
            'release --ver=10-01-2022',
            $releaseOutput
        );

        $this->assertEquals(
            "Version format error\n",
            self::getDisplay($releaseOutput)
        );
    }

    public function tearDown(): void
    {
        $changeFacade = $this->container->get(ChangeFacade::class);
        $changeFacade->clearChanges();

        $filesystem = $this->container->get(Filesystem::class);
        $filesystem->dumpFile($this->config->get('changelogName'), '');
    }
}
