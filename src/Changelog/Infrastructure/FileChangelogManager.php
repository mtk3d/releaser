<?php

declare(strict_types=1);


namespace MTK\Releaser\Changelog\Infrastructure;

use MTK\Releaser\Changelog\Changelog;
use MTK\Releaser\Changelog\ChangelogManager;
use MTK\Releaser\Shared\AppConfig;
use MTK\Releaser\Shared\ReleaseDTO;
use Munus\Collection\GenericList;
use Munus\Control\Option;
use Symfony\Component\Filesystem\Filesystem;

class FileChangelogManager implements ChangelogManager
{
    private Filesystem $filesystem;
    private string $path;

    public function __construct(AppConfig $config, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->path = $config->get('changelogName');
        if (!$this->filesystem->exists($this->path)) {
            $this->filesystem->touch($this->path);
        }
    }

    public function save(Changelog $changelog): void
    {
        $content = $changelog->getListReleaseDTO()
            ->map(function (ReleaseDTO $release): string {
                $title = "## " . $release->getVersion() . PHP_EOL;
                $releaseNotes = $release->getReleaseNotes();
                return $title . $releaseNotes;
            })->reduce(fn (string $content, string $release) => $content . $release);

        $this->filesystem->dumpFile($this->path, $content);
    }

    public function getChangelog(): Changelog
    {
        $content = $this->getFileContent($this->path);
        $releases = $this->splitContent($content)
            ->map(fn (string $releaseContent): ReleaseDTO => $this->parseRelease($releaseContent));

        return new Changelog($releases);
    }

    /**
     * @param string $path
     * @return string
     */
    private function getFileContent(string $path): string
    {
        return file_get_contents($path) ?: "";
    }

    /**
     * @return GenericList<string>
     */
    private function splitContent(string $content): GenericList
    {
        if (empty($content)) {
            return GenericList::empty();
        }
        return GenericList::ofAll(explode("\n## ", $content));
    }

    private function parseRelease(string $releaseContent): ReleaseDTO
    {
        $lines = GenericList::ofAll(explode("\n", $releaseContent));

        $version = Option::of($lines->head())
            ->map(fn ($version): string => str_replace("## ", "", $version))
            ->map('trim')
            ->get();

        $releaseNotes = $lines->tail()
            ->reduce(fn (string $content, string $line): string => $content . PHP_EOL . $line);

        return new ReleaseDTO($version, $releaseNotes);
    }
}
