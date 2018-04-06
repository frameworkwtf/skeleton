<?php

declare(strict_types=1);

namespace App;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Application Service Provider.
 */
class Provider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container): void
    {
        $container['appErrorHandler'] = $this->setAppErrorHandler();
        $container['logger'] = $this->setLogger();
        $container['baseurl_middleware'] = $this->setBaseurlMiddleware();
        $container['filters_middleware'] = function ($c) {
            return new \Wtf\Middleware\Filters($c);
        };
    }

    /**
     * Set App error handler.
     *
     * @return callable
     */
    protected function setAppErrorHandler(): callable
    {
        return function ($c) {
            return new ErrorHandler($c);
        };
    }

    /**
     * Set Baseurl middleware.
     *
     * @return callable
     */
    protected function setBaseurlMiddleware(): callable
    {
        return function ($c) {
            return new Middleware\Baseurl($c);
        };
    }

    /**
     * Set logger.
     *
     * @return callable
     */
    protected function setLogger(): callable
    {
        return function ($c) {
            $config = $c['config']('log');
            $logger = new \Monolog\Logger($config['channel']);
            $formatter = new \Monolog\Formatter\LineFormatter($config['format'], null, true, true);
            $handler = new \Monolog\Handler\ErrorLogHandler(\Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, $config['level'], true, true);
            $handler->setFormatter($formatter);
            $logger->pushHandler($handler);
            $logger->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
            $logger->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
            $logger->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor());
            $logger->pushProcessor(new \Monolog\Processor\MemoryPeakUsageProcessor());

            return $logger;
        };
    }
}
