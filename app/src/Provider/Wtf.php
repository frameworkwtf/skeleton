<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Wtf implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container): void
    {
        $container['appErrorHandler'] = function ($c) {
            return new ErrorHandler($c);
        };
        $container['logger'] = $this->setLogger();
        $container['filters_middleware'] = function ($c) {
            return new \Wtf\Middleware\Filters($c);
        };
        $container['logger'] = function ($c) {
            $config = $c['config']('log');
            $logger = new \Monolog\Logger($config['channel'] ?? 'app');
            $handler = new \Monolog\Handler\ErrorLogHandler(\Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, $config['level'], true, true);
            $logger->pushHandler($handler);

            return $logger;
        };
    }
}
