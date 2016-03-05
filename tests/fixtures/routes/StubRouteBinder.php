<?php

namespace Mosaic\Tests\fixtures\routes;

use Mosaic\Contracts\Routing\RouteBinder;
use Mosaic\Contracts\Routing\Router;

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
