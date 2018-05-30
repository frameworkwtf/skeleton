<?php

declare(strict_types=1);

return [
    'entity' => 'user', // user entity
    'storage' => \Wtf\Auth\Storage\Session::class, // can be Session, Cookie, JWT
    'repository' => \Wtf\Auth\Repository\User::class, // default user repository
    'rbac' => [
        'defaultRole' => 'anonymous', //default unauthorized role
        'errorCallback' => function ($request, $response) {
            return $response->withHeader('Location', '/auth');
        },
    ],
];
