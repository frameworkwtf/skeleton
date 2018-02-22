<?php

declare(strict_types=1);

namespace App;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class ErrorHandler extends \Wtf\Root
{
    /**
     * Handle exception.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param Throwable              $e
     *
     * @return ResponseInterface
     */
    public function error500(ServerRequestInterface $request, ResponseInterface $response, Throwable $e): ResponseInterface
    {
        $this->logger->error($request->getUri()->__toString(), ['code' => 500, 'exception' => $e]);

        return $response->withStatus(500);
    }
}
