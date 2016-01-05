<?php

namespace Fresco\Http\Middleware;

use Fresco\Contracts\Http\Request;
use Fresco\Http\Adapters\Psr7\Response;
use Zend\Diactoros\Response\HtmlResponse;

class DispatchRequest
{
    /**
     * Dispatch the request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        // TODO: send the request through the router

        return new Response(new HtmlResponse($request->get('name', 'No name given')));
    }
}
