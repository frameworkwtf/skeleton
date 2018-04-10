<?php
/**
 * Unused scanner config
 */
return [
    'composerJsonPath' => __DIR__ . '/composer.json',
    'vendorPath' => __DIR__ . '/app/vendor/',
    'scanDirectories' => [
        __DIR__.'/app/',

    ],
    'excludeDirectories' => [
        'cache',
        'vendor'
    ],
    'scanFiles' => [],
    'extensions' => ['*.php'],
    'requireDev' => false,
];
