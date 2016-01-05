<?php

namespace Fresco\Routing\Adapters\FastRoute;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Routing\RouteDispatcher as RouteDispatcherContract;
use Fresco\Exceptions\MethodNotAllowedException;
use Fresco\Exceptions\NotFoundHttpException;
use Fresco\Routing\RouteCollection;

class RouteDispatcher implements RouteDispatcherContract
{
    /**
     * Dispatch the request
     *
     * @param Request         $request
     * @param RouteCollection $collection
     *
     * @throws \Exception
     * @return mixed
     */
    public function dispatch(Request $request, RouteCollection $collection)
    {
        $method = $request->method();
        $uri    = '/';

        $response = $this->createDispatcher($collection)->dispatch($method, $uri);

        switch ($response[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundHttpException;

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException($response[1]);

            case Dispatcher::FOUND:
                return 'Route was found';
        }
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
