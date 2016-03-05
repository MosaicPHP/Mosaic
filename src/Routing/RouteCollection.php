<?php

namespace Mosaic\Routing;

use ArrayIterator;
use IteratorAggregate;

class RouteCollection implements IteratorAggregate
{
    /**
     * @var Route[]
     */
    protected $routes = [];

    /**
     * @param Route $route
     */
    public function add(Route $route)
    {
        $this->routes[] = $route;
    }

    /**
     * {@inheritdoc}
     * @return Route[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->routes);
    }
}
