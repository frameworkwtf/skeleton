<?php

declare(strict_types=1);

return [
    'index' => [
        'rbac' => [
            'anonymous' => ['GET'],
        ],
    ],
    'second' => [
        'pattern' => '/second',
        'rbac' => [
            'anonymous' => ['GET'],
        ],
    ],
];
