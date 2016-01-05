<?php

namespace Fresco\Contracts\Routing;

use Fresco\Routing\Route;
use Fresco\Routing\RouteCollection;

interface Router
{
    /**
     * @return RouteCollection|Route[]
     */
    public function all() : RouteCollection;

    /**
     * Register a new GET route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function get($uri, $action);

    /**
     * Register a new POST route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function post($uri, $action);

    /**
     * Register a new PUT route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function put($uri, $action);

    /**
     * Register a new PATCH route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function patch($uri, $action);

    /**
     * Register a new DELETE route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function delete($uri, $action);

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function options($uri, $action);

    /**
     * Register a new route responding to all verbs.
     *
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function any($uri, $action);

    /**
     * Register a new route with the given verbs.
     *
     * @param array|string          $methods
     * @param string                $uri
     * @param \Closure|array|string $action
     *
     * @return Route
     */
    public function match($methods, $uri, $action);
}
