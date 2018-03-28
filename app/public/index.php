<?php

declare(strict_types=1);
$root = __DIR__.'/..';
require $root.'/vendor/autoload.php';
if (\extension_loaded('session')) {
    \session_start();
}
$app = new \Wtf\App(['config_dir' => $root.'/config/']);
$app->run();
