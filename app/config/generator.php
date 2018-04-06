<?php

declare(strict_types=1);
$app = \dirname(__DIR__).'/';

return [
    'paths' => [
        'app' => $app,
        'controller' => $app.'src/Controller/',
        'entity' => $app.'src/Entity/',
        'test' => $app.'tests/',
        'route' => $app.'config/routes/',
    ],
];
