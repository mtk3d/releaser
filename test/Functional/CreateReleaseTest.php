<?php

declare(strict_types=1);

namespace MTK\Releaser\Test\Functional;

use MTK\Releaser\Test\Common\OutputTestUtils;

class CreateReleaseTest extends BaseTestCase
{
    use OutputTestUtils;

    public function testCreateRelease(): void
    {
        /* 01 ADD FIX CHANGE */

        $fixChangeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new fix "Fix article validation" ID-123 "Foo Bar"',
            $fixChangeOutput
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
            self::getDisplay($fixChangeOutput)
        );

        /* 02 ADD FEATURE CHANGE */

        $featureChangeOutput = self::getStreamOutput();

        $this->app->runCommand(
            'new feature "Add article draft functionality" ID-456 "John Doe"',
            $featureChangeOutput
        );

        self::assertEquals(
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

        self::assertEquals(
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

        self::assertEquals(
            "Version format error\n",
            self::getDisplay($releaseOutput)
        );
    }
}
