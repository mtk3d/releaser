<?php

declare(strict_types=1);

namespace MTK\Releaser\Tests\Functional;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Shared\Common\OutputTestUtils;
use function MTK\Releaser\Tests\Fixture\runFeatureChangeCommand;
use function MTK\Releaser\Tests\Fixture\runFixChangeCommand;
use function MTK\Releaser\Tests\Fixture\runReleaseMinorCommand;
use Symfony\Component\Filesystem\Filesystem;
use function MTK\Releaser\Tests\Fixture\runReleaseVersionCommand;

class CreateReleaseTest extends BaseTestCase
{
    use OutputTestUtils;

    private ChangeFacade $changeFacade;
    private AppConfig $config;
    private PrepareContext $prepareContext;
    private PublishContext $publishContext;

    public function setUp(): void
    {
        parent::setUp();

        $this->config = $this->container->get(AppConfig::class);
        $this->changeFacade = $this->container->get(ChangeFacade::class);
        $this->prepareContext = $this->container->get(PrepareContext::class);
        $this->publishContext = $this->container->get(PublishContext::class);
    }

    public function testCreateRelease(): void
    {
        $fixChangeOutput = self::getStreamOutput();
        $featureChangeOutput = self::getStreamOutput();
        $releaseOutput = self::getStreamOutput();

        /* 01 FIX CHANGE */

        runFixChangeCommand(
            "Fix article validation",
            "ID-123",
            "Foo Bar",
            $this->changeFacade,
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

        /* 02 FEATURE CHANGE */

        runFeatureChangeCommand(
            "Add article draft functionality",
            "ID-456",
            "John Doe",
            $this->changeFacade,
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

        runReleaseMinorCommand(
            $this->prepareContext,
            $this->publishContext,
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
        $releaseOutput = self::getStreamOutput();

        /* 01 FIX CHANGE */

        runFixChangeCommand(
            "Fix article validation",
            "ID-123",
            "Foo Bar",
            $this->changeFacade,
            self::getStreamOutput()
        );

        /* 02 RELEASE CHANGES WITH WRONG VERSION */

        runReleaseVersionCommand(
            $this->prepareContext,
            $this->publishContext,
            $releaseOutput,
            '10-01-2022'
        );

        $this->assertEquals(
            "Version format error\n",
            self::getDisplay($releaseOutput)
        );
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->changeFacade->clearChanges();
        $filesystem = $this->container->get(Filesystem::class);
        $filesystem->dumpFile($this->config->get('changelogName'), '');
    }
}
