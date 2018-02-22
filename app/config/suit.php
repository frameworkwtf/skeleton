<?php

declare(strict_types=1);
$cache_dir = dirname(__DIR__).'/cache';

return [
    'providers' => [
        '\App\Provider',
    ],
    'middlewares' => [
        'baseurl_middleware',
    ],
    'sentry' => [
        'dsn' => 'REPLACE ME',
        'options' => [
            'app_path' => dirname(__DIR__),
            'environment' => getenv('APP_ENV'),
            'release' => getenv('APP_RELEASE'),
            'excluded_app_paths' => [
                $cache_dir,
            ],
            'prefixies' => [
                dirname(__DIR__),
            ],
            'tags' => [
                'interface' => PHP_SAPI,
            ],
        ],
    ],

    'settings' => [
        'displayErrorDetails' => ('prod' === getenv('APP_ENV')) ? false : true,
        'determineRouteBeforeAppMiddleware' => true,
        'debug' => ('prod' === getenv('APP_ENV')) ? false : true,
        'routerCacheFile' => ('prod' === getenv('APP_ENV')) ? $cache_dir.'/routes' : false,
    ],
];
