<?php

declare(strict_types=1);

return [
    'path' => '/',
    'ignore' => ['/auth', '/app'],
    'secret' => \getenv('APP_SECRET'),
    'secure' => ('prod' === \getenv('APP_ENV')) ? true : false,
    'error' => function ($response, $arguments) {
        return $response->withJson([
            'error' => [
                'message' => 'You are note allowed to see this page',
                'fields' => [],
            ],
            'count' => 0,
            'data' => [],
        ], 401);
    },
];
