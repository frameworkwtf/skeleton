<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Wtf implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container): void
    {
        $container['appErrorHandler'] = function ($c) {
            return new \App\ErrorHandler($c);
        };
        $container['notFoundHandler'] = function ($c) {
            return function (ServerRequestInterface $request, ResponseInterface $response) use ($c) {
                return $c['appErrorHandler']->error404($request, $response);
            };
        };
        $container['logger'] = function ($c) {
            $config = $c['config']('log');
            $logger = new \Monolog\Logger($config['channel'] ?? 'app');
            $handler = new \Monolog\Handler\ErrorLogHandler(\Monolog\Handler\ErrorLogHandler::OPERATING_SYSTEM, $config['level'], true, true);
            $logger->pushHandler($handler);

            return $logger;
        };

        $container->extend('view', function ($view, $container) {
            $view->addExtension(new \nochso\HtmlCompressTwig\Extension());

            return $view;
        });

        $container['service'] = $container->protect(function (string $name) use ($container) {
            if (!$container->has('service_'.$name)) {
                $parts = \explode('_', $name);
                $class = 'App\\Service';
                foreach ($parts as $part) {
                    $class .= '\\'.\ucfirst($part);
                }
                $container['service_'.$name] = function ($container) use ($class) {
                    return new $class($container);
                };
            }

            return $container['service_'.$name];
        });
        $container['auth_middleware'] = function ($c) {
            return function ($request, $response, $next) use ($c) {
                if ($c->has('user') && $c->get('user')) {
                    $request = $request->withAttribute('role', $c->get('user')->get('role', 'user'));
                }

                return $next($request, $response);
            };
        };
    }
}
