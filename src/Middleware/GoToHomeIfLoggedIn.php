<?php

namespace App\Middleware;

use App\Session;
use App\Utils;
use App\Settings;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class GoToHomeIfLoggedIn
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        return Session::getInstance()->isLoggedIn()
            ? Utils::redirect(new Response(), Settings::ROUTE_CABINET)
            : $handler->handle($request);
    }
}
