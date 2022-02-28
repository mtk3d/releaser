<?php


namespace MTK\Releaser\Change\Infrastructure;

use MTK\Releaser\Change\Change;
use MTK\Releaser\Change\ChangeManager;
use MTK\Releaser\Shared\AppConfig;
use Munus\Collection\GenericList;
use Munus\Control\Option;
use Symfony\Component\Filesystem\Filesystem;

class FileChangeManager implements ChangeManager
{
    private Filesystem $filesystem;
    private string $path;

    public function __construct(AppConfig $config, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->path = $config->get('changesDirectory');
        if (!$this->filesystem->exists($this->path)) {
            $this->filesystem->mkdir($this->path);
        }
    }

    public function save(Change $change): void
    {
        $author = $change->getChangeDTO()->getAuthor();
        $filePath = $this->getFilePathByAuthor($author);
        $this->filesystem->touch($filePath);
        $this->filesystem->dumpFile($filePath, serialize($change));
    }

    public function get(): GenericList
    {
        return $this->getListOfFiles()
            ->map(fn (string $fileName): string => $this->getFileContent($fileName))
            ->map(fn (string $fileContent): Change => unserialize($fileContent));
    }

    public function clearAll(): void
    {
        $this->getListOfFiles()
            ->map(function (string $fileName): void {
                $this->removeFile($fileName);
            });
    }

    /**
     * @return GenericList<string>
     */
    private function getListOfFiles(): GenericList
    {
        /** @var array<string> $files */
        $files = scandir($this->path);

        return GenericList::ofAll($files)
            ->filter(fn (string $fileName): bool => !in_array($fileName, ['.', '..']));
    }

    private function getFilePath(string $fileName): string
    {
        return join("/", [$this->path, $fileName]);
    }

    private function getFileName(string $author): string
    {
        return Option::of(/** @param string */$author)
            ->map('trim')
            ->map('strtolower')
            ->map(fn (string $author): string => str_replace(" ", "-", $author))
            ->map(fn (string $author): string => join("-", [time(), $author]))
            ->getOrElse('');
    }

    private function getFileContent(string $fileName): string
    {
        $content = file_get_contents($this->getFilePath($fileName));
        return $content ?: "";
    }

    private function removeFile(string $fileName): void
    {
        $this->filesystem->remove($this->getFilePath($fileName));
    }

    private function getFilePathByAuthor(string $author): string
    {
        return $this->getFilePath($this->getFileName($author));
    }
}
