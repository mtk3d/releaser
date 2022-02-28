<?php


namespace MTK\Releaser\Tests\Functional;

use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Command\ChangeCommand;
use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use MTK\Releaser\Command\ReleaseCommand;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Shared\Common\OutputTestUtils;
use Symfony\Component\Filesystem\Filesystem;

class CreateReleaseTestCase extends BaseTestCase
{
    use OutputTestUtils;

    private ChangeFacade $changeFacade;
    private Filesystem $filesystem;
    private AppConfig $config;
    private PrepareContext $prepareContext;
    private PublishContext $publishContext;

    public function setUp(): void
    {
        parent::setUp();

        $this->config = $this->container->get(AppConfig::class);
        $this->filesystem = $this->container->get(Filesystem::class);
        $this->changeFacade = $this->container->get(ChangeFacade::class);
        $this->prepareContext = $this->container->get(PrepareContext::class);
        $this->publishContext = $this->container->get(PublishContext::class);
    }

    public function testCreateRelease(): void
    {
        $output = self::getStreamOutput();
        (new ChangeCommand())("fix", "Fix article validation", "ID-123", "Foo Bar", $this->changeFacade, $output);
        $changeOutput = self::getStreamOutput();
        (new ChangeCommand())("feature", "Add article draft functionality", "ID-456", "John Doe", $this->changeFacade, $changeOutput);
        $releaseOutput = self::getStreamOutput();
        (new ReleaseCommand())(null, "minor", $this->prepareContext, $this->publishContext, $releaseOutput);

        $changeExpected = <<<EOF
            Unreleased changes:
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
            
            EOF;

        $releaseExpected = <<<EOF
            Release details:
            Version: 0.1.0
            Release notes:
            ### Fix (1)
            - Fix article validation ID-123
            ### Feature (1)
            - Add article draft functionality ID-456
            
            Release created successfully

            EOF;

        $this->assertEquals($changeExpected, self::getDisplay($changeOutput));
        $this->assertEquals($releaseExpected, self::getDisplay($releaseOutput));
        $this->fail();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->changeFacade->clearChanges();
        $this->filesystem->dumpFile($this->config->get('changelogName'), "");
    }
}
