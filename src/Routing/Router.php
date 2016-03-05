<?php

namespace Mosaic\Routing;

use Mosaic\Contracts\Routing\Router as RouterContract;

class Router implements RouterContract
{
    /**
     * @var RouteCollection|Route[]
     */
    protected $routes;

    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = new RouteCollection;
    }

    /**
     * @return RouteCollection|Route[]
     */
    public function all() : RouteCollection
    {
        return $this->routes;
    }

    /**
     * Register a new GET route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function get($uri, $action)
    {
        return $this->addRoute(['GET', 'HEAD'], $uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function post($uri, $action)
    {
        return $this->addRoute('POST', $uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function put($uri, $action)
    {
        return $this->addRoute('PUT', $uri, $action);
    }

    /**
     * Register a new PATCH route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function patch($uri, $action)
    {
        return $this->addRoute('PATCH', $uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function delete($uri, $action)
    {
        return $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function options($uri, $action)
    {
        return $this->addRoute('OPTIONS', $uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function any($uri, $action)
    {
        $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'];

        return $this->addRoute($verbs, $uri, $action);
    }

    /**
     * Register a new route with the given verbs.
     *
     * @param array|string          $methods
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function match($methods, $uri, $action)
    {
        return $this->addRoute(array_map('strtoupper', (array)$methods), $uri, $action);
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param array|string          $methods
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    protected function addRoute($methods, $uri, $action)
    {
        return $this->routes->add(
            new Route($methods, $uri, $action)
        );
    }
}
