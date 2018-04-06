<?php

declare(strict_types=1);

return [
    'login' => [
        'pattern' => '',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
        ],
    ],
    'logout' => [
        'pattern' => '/logout',
        'rbac' => [
            'user' => ['GET'],
        ],
    ],
    'forgot' => [
        'pattern' => '/forgot',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
            'user' => ['POST'],
        ],
    ],
    'reset' => [
        'pattern' => '/reset',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
            'user' => ['POST'],
        ],
    ],
];
