<?php

declare(strict_types=1);

return [
    'login' => [
        'pattern' => '/login',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
        ],
    ],
    'register' => [
        'pattern' => '/register',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
        ],
    ],
    'forgot' => [
        'pattern' => '/forgot',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
        ],
    ],
    'reset' => [
        'pattern' => '/reset',
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
    'form' => [
        'pattern' => '[/{reset_code}]',
        'rbac' => [
            'anonymous' => ['GET'],
        ],
    ],
];
