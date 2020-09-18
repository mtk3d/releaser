<?php


namespace MTK\Releaser\Command;


use PHPUnit\Framework\TestCase;
use MTK\Releaser\Change\ChangeConfiguration;
use MTK\Releaser\Change\ChangeFacade;
use MTK\Releaser\Change\Infrastructure\FileChangeManager;
use MTK\Releaser\Changelog\ChangelogConfiguration;
use MTK\Releaser\Changelog\ChangelogFacade;
use MTK\Releaser\Changelog\Infrastructure\FileChangelogManager;
use MTK\Releaser\Command\Release\PrepareContext;
use MTK\Releaser\Command\Release\PublishContext;
use MTK\Releaser\Common\AppConfig;
use MTK\Releaser\Common\OutputTestUtils;
use MTK\Releaser\Git\GitConfiguration;
use MTK\Releaser\Git\GitFacade;
use MTK\Releaser\Publisher\PublisherConfiguration;
use MTK\Releaser\Publisher\PublisherFacade;
use MTK\Releaser\Release\ReleaseConfiguration;
use MTK\Releaser\Release\ReleaseFacade;
use Symfony\Component\Filesystem\Filesystem;

class CreateReleaseTest extends TestCase
{
    use OutputTestUtils;

    /**
     * @var ChangeFacade
     */
    private ChangeFacade $changeFacade;
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;
    /**
     * @var AppConfig
     */
    private AppConfig $config;
    /**
     * @var FileChangelogManager
     */
    private FileChangelogManager $fileChangelogManager;
    /**
     * @var PrepareContext
     */
    private PrepareContext $prepareContext;
    /**
     * @var PublishContext
     */
    private PublishContext $publishContext;
    /**
     * @var FileChangeManager
     */
    private FileChangeManager $fileChangeManager;
    /**
     * @var ChangelogFacade
     */
    private ChangelogFacade $changelogFacade;
    /**
     * @var ReleaseFacade
     */
    private ReleaseFacade $releaseFacade;
    /**
     * @var GitFacade
     */
    private GitFacade $gitFacade;
    /**
     * @var PublisherFacade
     */
    private PublisherFacade $publisherFacade;

    public function setUp(): void
    {
        parent::setUp();
        if (!file_exists('test-env')) {
            mkdir('test-env', 0777, true);
        }
        chdir('test-env');

        $this->config = new AppConfig(["git" => ["enabled" => false]]);
        $this->filesystem = new Filesystem();
        $this->fileChangelogManager = new FileChangelogManager($this->config, $this->filesystem);
        $this->fileChangeManager = new FileChangeManager($this->config, $this->filesystem);
        $this->changeFacade = (new ChangeConfiguration())->changeFacade($this->fileChangeManager);
        $this->changelogFacade = (new ChangelogConfiguration)->changelogFacade($this->fileChangelogManager);
        $this->releaseFacade = (new ReleaseConfiguration())->releaseFacade();
        $this->gitFacade = (new GitConfiguration())->gitFacade(null, $this->config);
        $this->publisherFacade = (new PublisherConfiguration())->publisherFacade();
        $this->prepareContext = new PrepareContext($this->changelogFacade, $this->changeFacade, $this->releaseFacade);
        $this->publishContext = new PublishContext($this->changelogFacade, $this->gitFacade, $this->publisherFacade);
    }

    public function testCreateRelease(): void
    {
        $output = self::getStreamOutput();
        (new ChangeCommand())("fix", "New fix", "PJ-355", "Foo Bar", $this->changeFacade, $output);
        $changeOutput = self::getStreamOutput();
        (new ChangeCommand())("feature", "New change", "PJ-345", "John Doe", $this->changeFacade, $changeOutput);
        $releaseOutput = self::getStreamOutput();
        (new ReleaseCommand())(null, "minor", $this->prepareContext, $this->publishContext, $releaseOutput);

        $changeExpected = <<<EOF
            Unreleased changes:
            ---
            Type:     fix
            Message:  New fix
            Author:   Foo Bar
            ChangeID: PJ-355
            ---
            Type:     feature
            Message:  New change
            Author:   John Doe
            ChangeID: PJ-345
            
            Change created successfully
            
            EOF;

        $releaseExpected = <<<EOF
            Release details:
            Version: 0.1.0
            Release notes:
            ### Fix (1)
            - New fix PJ-355
            ### Feature (1)
            - New change PJ-345
            
            Release created successfully

            EOF;

        $this->assertEquals($changeExpected, self::getDisplay($changeOutput));
        $this->assertEquals($releaseExpected, self::getDisplay($releaseOutput));
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->changeFacade->clearChanges();
        $this->filesystem->dumpFile($this->config->get('changelogName'), "");
    }
}