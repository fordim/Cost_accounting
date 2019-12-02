<?php

namespace App\Middleware;

use App\Session;
use App\Utils;
use App\Settings;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class GoToMainIfGuest
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        return Session::getInstance()->isGuest()
            ? Utils::redirect(new Response(), Settings::ROUTE_ROOT)
            : $handler->handle($request);
    }
}
