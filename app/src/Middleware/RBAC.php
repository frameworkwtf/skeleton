<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Role-Based Access Control.
 */
class RBAC
{
    /**
     * PSR-11 Container.
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Default (anonymous) role name.
     *
     * @var string
     */
    protected $defaultRole;

    /**
     * Current user role name.
     *
     * @var string
     */
    protected $role;

    /**
     * Route pattern.
     *
     * @var string
     */
    protected $resource;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        /*
         * If route not found, delegate to next middleware,
         * because that allows application to handle 404 error on app level
         * with custom handlers
         */
        if (!$request->getAttribute('route')) {
            $this->record('No route pattern matched, process to 404 error handler');

            return $next($request, $response);
        }

        $this->preprocess($request);
        if ($this->isAllowed($this->role) || $this->isAllowed($this->defaultRole)) {
            $this->record('All correct, delegate to the next middleware');

            return $next($request, $response);
        }

        $this->record('Return unathorized error response');
        $error = $this->container['config']('rbac.errorCallback');

        return ($error) ? $error($request, $response) : $response->withJson([
                'error' => true,
                'message' => 'You are not allowed to see this page',
            ], 401);
    }

    /**
     * Preprocess configs and set class properties.
     *
     * @param ServerRequestInterface $request
     */
    protected function preprocess(ServerRequestInterface $request): void
    {
        $this->resource = $request->getAttribute('route')->getPattern();
        $this->defaultRole = $this->container['config']('rbac.defaultRole', 'anonymous');
        $roleAttribute = $this->container['config']('rbac.roleAttribute', 'role');
        $this->role = $request->getAttribute($roleAttribute) ?? $this->defaultRole;

        $this->record('Resource: '.$this->resource);
        $this->record('Role: '.$this->role);
    }

    /**
     * Check if resource is allowed for role.
     *
     * @param string $role User role
     *
     * @return bool
     */
    protected function isAllowed(string $role): bool
    {
        $allowed = in_array($this->resource, $this->container['config']('rbac.acl.'.$role, []), true);
        $this->record('Role "'.$role.'" allowed: '.(int) $allowed);

        return (bool) $allowed;
    }

    /**
     * Record sentry breadcrumb.
     *
     * @param string $message
     */
    protected function record(string $message): void
    {
        $this->container['sentry']->breadcrumbs->record([
            'category' => 'RBAC',
            'level' => 'info',
            'message' => $message,
        ]);
    }
}
