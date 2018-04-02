<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Application level router.
 */
class Router extends \Wtf\Root
{
    /**
     * Map routes from `routes.php` config.
     *
     * @param \Slim\App $app
     */
    public function __invoke(\Slim\App $app): void
    {
        foreach ($this->config('routes') as $group_name => $routes) {
            $app->group($group_name, function () use ($group_name, $routes): void {
                $controller = ('/' === $group_name || !$group_name) ? 'index' : \trim($group_name, '/');
                foreach ($routes as $name => $route) {
                    $this->map(
                        $route['methods'] ?? ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                        $route['pattern'] ?? '',
                        function (Request $request, Response $response, array $args = []) use ($controller) {
                            return $this['controller']($controller)->__invoke($request, $response, $args);
                        }
                    )->setName($controller.'-'.$name);
                }
            });
        }
    }
}
