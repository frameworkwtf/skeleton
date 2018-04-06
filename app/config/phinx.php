<?php

declare(strict_types=1);
$db = require __DIR__.'/medoo.php';

return [
    'paths' => [
        'migrations' => \dirname(__DIR__).'/migrations',
        'seeds' => \dirname(__DIR__).'/seeds',
    ],

    'environments' => [
        'default_database' => 'default',
        'default' => [
            'name' => $db['database_name'],
            'host' => $db['server'],
            'user' => $db['username'],
            'pass' => $db['password'],
            'port' => $db['port'],
            'charset' => $db['charset'],
            'adapter' => $db['database_type'],
        ],
    ],
];
