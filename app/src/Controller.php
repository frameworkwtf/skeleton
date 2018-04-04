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
                $response = \call_user_func([$this, $action]);
            } else {
                $response = $this->notFoundHandler->__invoke($this->request, $this->response);
            }
        } else {
            $response = $this->notFoundHandler->__invoke($this->request, $this->response);
        }
        $this->logger->debug('Request '.$request->getUri()->__toString(), [
            'method' => $request->getMethod(),
            'status' => $response->getStatusCode(),
            'request body' => $request->getParsedBody(),
            'response body' => $response->getBody()->__toString(),
        ]);

        return $response;
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
