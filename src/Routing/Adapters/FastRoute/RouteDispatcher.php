<?php

namespace Fresco\Routing\Adapters\FastRoute;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Routing\RouteDispatcher as RouteDispatcherContract;
use Fresco\Exceptions\MethodNotAllowedException;
use Fresco\Exceptions\NotFoundHttpException;
use Fresco\Routing\Route;
use Fresco\Routing\RouteCollection;

class RouteDispatcher implements RouteDispatcherContract
{
    /**
     * Dispatch the request
     *
     * @param Request         $request
     * @param RouteCollection $collection
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundHttpException
     * @return Route
     */
    public function dispatch(Request $request, RouteCollection $collection)
    {
        $method = $request->method();
        $uri    = $request->path();

        $routeInfo = $this->createDispatcher($collection)->dispatch($method, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundHttpException;

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($routeInfo[1]);

            case Dispatcher::FOUND:
                $route = $routeInfo[1];
                $route->bind($routeInfo[2]);
        }

        return $route;
    }

    /**
     * @param RouteCollection $collection
     *
     * @return Dispatcher
     */
    private function createDispatcher(RouteCollection $collection)
    {
        return \FastRoute\simpleDispatcher(function (RouteCollector $collector) use ($collection) {
            foreach ($collection as $route) {
                $collector->addRoute($route->methods(), $route->uri(), $route);
            }
        });
    }
}
