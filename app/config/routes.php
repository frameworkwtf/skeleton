<?php

declare(strict_types=1);

/**
 * Easy to use routing with route groups.
 *
 * @see https://www.slimframework.com/docs/objects/router.html#route-groups
 */
$routes = [
    '/' => [ //Default group for /
        'index' => [ //route name and action in controller
            'pattern' => '', //pattern
            'methods' => ['GET'], //Allowed HTTP methods
            'rbac' => [ //Role-Based Access Controll
                'anonymous' => ['GET'], //Key is role name, value is array of allowed HTTP methods for that role
            ],
        ],
        'second' => [ //route name
            'pattern' => 'second', //pattern
            'rbac' => [
                'anonymous' => ['GET'],
            ],
            //all other fields will be defaults
            //methods = ['GET']
        ],
    ],
];

foreach (\glob(__DIR__.'/routes/*.php') as $item) {
    $group = \current(\explode('.', \basename($item)));
    $routes['/'.$group] = include $item;
}

return $routes;
