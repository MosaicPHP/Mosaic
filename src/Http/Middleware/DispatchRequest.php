<?php

namespace Fresco\Http\Middleware;

use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\ResponseFactory;
use Fresco\Contracts\Routing\RouteDispatcher;
use Fresco\Contracts\Routing\Router;
use Fresco\Http\Adapters\Psr7\Response;

class DispatchRequest
{
    /**
     * @var ResponseFactory
     */
    private $factory;

    /**
     * @var RouteDispatcher
     */
    private $dispatcher;

    /**
     * @var Router
     */
    private $router;

    /**
     * DispatchRequest constructor.
     *
     * @param RouteDispatcher $dispatcher
     * @param Router          $router
     * @param ResponseFactory $factory
     */
    public function __construct(RouteDispatcher $dispatcher, Router $router, ResponseFactory $factory)
    {
        $this->router     = $router;
        $this->factory    = $factory;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Dispatch the request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return $this->factory->make(
            $this->dispatcher->dispatch($request, $this->router->all())
        );
    }
}
