<?php

namespace Hakone\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface RequestInterceptionMiddleware extends MiddlewareInterface
{
    /**
     * @param UntouchableResponseHandler $handler
     * @return \Hakone\Http\Message\UntouchableResponse
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface;
}
