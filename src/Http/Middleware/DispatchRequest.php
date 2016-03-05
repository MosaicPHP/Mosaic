<?php

namespace Mosaic\Http\Middleware;

use Mosaic\Contracts\Http\Request;
use Mosaic\Contracts\Http\ResponseFactory;
use Mosaic\Contracts\Routing\RouteDispatcher;
use Mosaic\Contracts\Routing\Router;
use Mosaic\Contracts\View\Factory;
use Mosaic\Http\Adapters\Psr7\Response;
use Mosaic\Routing\Dispatchers\DispatchClosure;
use Mosaic\Routing\Dispatchers\DispatchController;

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
     * @var DispatchClosure
     */
    private $closure;

    /**
     * @var DispatchController
     */
    private $controller;

    /**
     * DispatchRequest constructor.
     *
     * @param RouteDispatcher    $dispatcher
     * @param Router             $router
     * @param DispatchController $controller
     * @param DispatchClosure    $closure
     * @param ResponseFactory    $factory
     */
    public function __construct(
        RouteDispatcher $dispatcher,
        Router $router,
        DispatchController $controller,
        DispatchClosure $closure,
        ResponseFactory $factory
    ) {
        $this->router     = $router;
        $this->factory    = $factory;
        $this->dispatcher = $dispatcher;
        $this->closure    = $closure;
        $this->controller = $controller;
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
        $route = $this->dispatcher->dispatch($request, $this->router->all());

        if ($this->closure->isSatisfiedBy($route)) {
            $response = $this->closure->dispatch($route);
        } else {
            $response = $this->controller->dispatch($route);
        }

        return $this->factory->make($response);
    }
}
