<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Controller extends \Wtf\Root
{
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
        $name = explode('-', $request->getAttribute('route')->getName());
        $action = strtolower(end($name)).'Action';

        if (method_exists($this, $action)) {
            $response = call_user_func([$this, $action]);
        } else {
            $response = $this->notFoundHandler($request, $response);
        }
        $this->logger->debug("Request\nURL     |> ".$request->getUri()->__toString(), [
            'method' => $request->getMethod(),
            'status' => $response->getStatusCode(),
            'request body' => $request->getParsedBody(),
            'response body' => $response->getBody()->__toString(),
        ]);

        return $response;
    }
}
