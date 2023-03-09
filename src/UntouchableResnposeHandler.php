<?php

namespace Hakone\Http\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface UntouchableResponseHandler extends RequestHandlerInterface
{
    /** @return \Hakone\Http\Message\UntouchableResponse */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
