<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../../../autoload.php')) {
    require __DIR__ . '/../../../autoload.php';
} else {
    fwrite(STDERR, 'ERROR: Composer dependencies not properly set up! Run "composer install" or see README.md for more details' . PHP_EOL);
    exit(1);
}

$app = new \MTK\Releaser\Application();
$app->run();
