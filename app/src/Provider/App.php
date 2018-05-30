<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Application Service Provider.
 */
class App implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container): void
    {
        $container['baseurl_middleware'] = function ($c) {
            return new \App\Middleware\Baseurl($c);
        };
    }
}
