<?php

namespace Fresco\Tests\fixtures\routes;

use Fresco\Contracts\Routing\RouteBinder;
use Fresco\Contracts\Routing\Router;

class StubRouteBinder implements RouteBinder
{
    /**
     * Bind routes to router
     *
     * @param Router $router
     */
    public function bind(Router $router)
    {
        $router->get('/', 'Controller@method');
    }
}
