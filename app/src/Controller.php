<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Wtf\Root;

class Controller extends Root
{
    /**
     * Response template.
     *
     * @var array
     */
    protected $defaultResponse = [
        'error' => [
            'message' => null,
            'fields' => [],
        ],
        'count' => 0,
        'data' => [],
    ];

    /**
     * Invoke controller.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $args
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $this->request = $request;
        $this->response = $response;
        if ($request->getAttribute('route')) {
            $name = \explode('-', $request->getAttribute('route')->getName());
            $action = \strtolower(\end($name)).'Action';

            if (\method_exists($this, $action)) {
                return \call_user_func([$this, $action]);
            }

            return $this->notFound();
        }

        return $this->notFound();
    }

    /**
     * Render view.
     *
     * @param string $template    Template file name
     * @param array  $vars        Template vars
     * @param int    $status_code HTTP status code, default: 200
     *
     * @return ResponseInterface
     */
    public function render(string $template, array $vars = [], int $status_code = 200): ResponseInterface
    {
        return $this->view->render($this->response, $template, $vars)->withStatus($status_code);
    }

    /**
     * Return response with location header.
     *
     * @param string $location
     *
     * @return ResponseInterface
     */
    public function redirect(string $location): ResponseInterface
    {
        return $this->response->withHeader('Location', $location);
    }

    /**
     * Return 404 response.
     *
     * @return ResponseInterface
     */
    public function notFound(): ResponseInterface
    {
        return $this->notFoundHandler->__invoke($this->request, $this->response);
    }

    /**
     * Prepare JSON response.
     *
     * @param array $data
     * @param int   $status HTTP status code, default: null
     *
     * @return ResponseInterface
     */
    public function json(array $data, int $status = null): ResponseInterface
    {
        $response = $this->preprocessResponse($data);
        if (!$status) {
            $status = ($response['error']['message'] ?? null || $response['error']['fields'] ?? null) ? 400 : 200;
        }

        return $this->response->withStatus($status)->withJson($response);
    }

    /**
     * Pre-process response data.
     *
     * @param array $data
     *
     * @return array
     */
    protected function preprocessResponse(array $data): array
    {
        $response = $this->defaultResponse;
        if ($data['error']['message'] ?? null) {
            $response['error']['message'] = $data['error']['message'];
            unset($data['error']['message']);
        }
        if ($data['error']['fields'] ?? null) {
            $response['error']['fields'] = $data['error']['fields'];
            unset($data['error']['fields']);
        }

        if (isset($data['error'])) {
            unset($data['error']);
        }

        $response['count'] = \count($data);
        $response['data'] = $data;

        return $response;
    }
}
