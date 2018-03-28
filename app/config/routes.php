<?php

declare(strict_types=1);

/**
 * Easy to use routing with route groups.
 *
 * @see https://www.slimframework.com/docs/objects/router.html#route-groups
 */
$routes = [
    '/' => [ //Default group for /
        '' => [
            'name' => 'index',
            'methods' => ['GET'],
        ],
        'second' => [
        ],
    ],
];

foreach (\glob(__DIR__.'/routes/*.php') as $item) {
    $group = \current(\explode('.', \basename($item)));
    $routes['/'.$group] = include $item;
}

return $routes;
