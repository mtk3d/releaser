<?php


namespace MTK\Releaser\Release\ReleaseNotes;

use MTK\Releaser\Shared\ChangeDTO;
use Munus\Collection\GenericList;
use Munus\Collection\Map;
use Munus\Tuple;

class ReleaseNotesFormatter
{
    private const CHANGE_TYPE_TEMPLATE = "### {changesType} ({numberOfChanges})" . PHP_EOL;
    private const SINGLE_CHANGE_TEMPLATE = "- {message} {changeId}" . PHP_EOL;

    private static ?ReleaseNotesFormatter $instance = null;

    public static function getInstance(): ReleaseNotesFormatter
    {
        if (self::$instance === null) {
            self::$instance = new ReleaseNotesFormatter();
        }

        return self::$instance;
    }

    /**
     * @param Map<string, GenericList<ChangeDTO>> $changes
     * @return string
     */
    public function format(Map $changes): string
    {
        /** @var Map<string, string> $changesTypes */
        $changesTypes = $changes->map( /** @phpstan-ignore-line */
            function (Tuple $keyValue): Tuple {
                /**
                 * @var string $key
                 * @var GenericList<ChangeDTO> $changesList
                 */
                list($key, $changesList) = $keyValue;

                $title = $this->getChangeTypeTitle(ucfirst($key), (string)$changesList->length());

                /** @var string $changesFormatted */
                $changesFormatted = $changesList
                    ->map(fn (ChangeDTO $change): string
                        => $this->getSingleChange($change->getMessage(), $change->getChangeId()))
                    ->reduce(fn (string $list, string $change): string
                        => $list . $change);

                return Tuple::of($key, $title . $changesFormatted);
            }
        );

        $changes = GenericList::ofAll($changesTypes->values());

        if ($changes->isEmpty()) {
            return "";
        }

        return $changes->reduce(fn (string $content, string $list) => $content . $list);
    }

    private function getChangeTypeTitle(string $changesType, string $numberOfChanges): string
    {
        return str_replace(
            ["{changesType}", "{numberOfChanges}"],
            [ $changesType, $numberOfChanges ],
            self::CHANGE_TYPE_TEMPLATE
        );
    }

    private function getSingleChange(string $message, string $changeId): string
    {
        return str_replace(
            ["{message}", "{changeId}"],
            [ $message, $changeId ],
            self::SINGLE_CHANGE_TEMPLATE
        );
    }
}
