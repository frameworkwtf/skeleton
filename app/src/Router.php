<?php

declare(strict_types=1);

namespace App;

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
                $name = ('/' === $group_name || !$group_name) ? 'index' : \trim($group_name, '/');
                $controller = '\App\Controller\\'.\ucfirst($name);
                if (!\class_exists($controller)) {
                    throw new \Exception('Controller for group '.$name.' not found');
                }

                foreach ($routes as $pattern => $info) {
                    $this->map($info['methods'] ?? ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'], $pattern, $controller)
                        ->setName($info['name'] ?? $name.'-'.($info['action'] ?? $pattern));
                }
            });
        }
    }
}
