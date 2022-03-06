<?php

declare(strict_types=1);

namespace MTK\Releaser\Command\Wizard;

use Symfony\Component\Console\Style\SymfonyStyle;

class ReleaseWizard
{
    /**
     * @return array{string|null, string|null}
     */
    public function run(SymfonyStyle $io): array
    {
        $semverPart = $io->choice(
            "Which part of semver would you to update?",
            ['major', 'minor', 'patch']
        );

        $wantStartVersion = $io->confirm("Would you like to specify the start from version?", false);

        $version = null;

        if ($wantStartVersion) {
            $version = $io->ask("Please specify the start version in semver format");
        }

        return [$version, $semverPart];
    }
}
