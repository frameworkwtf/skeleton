<?php

declare(strict_types=1);

return [
    'loginForm' => [
        'pattern' => '',
        'rbac' => [
            'anonymous' => ['GET'],
        ],
    ],
    'login' => [
        'pattern' => '/login',
        'methods' => ['POST'],
        'rbac' => [
            'anonymous' => ['POST'],
        ],
    ],
    'registerForm' => [
        'pattern' => '/register',
        'rbac' => [
            'anonymous' => ['GET'],
        ],
    ],
    'create' => [
        'pattern' => '/create',
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
];
