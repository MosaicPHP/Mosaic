<?php

namespace Fresco\Contracts\Routing;

interface RouteLoader
{
    /**
     * @param Router $router
     *
     * @return mixed
     */
    public function loadRoutes(Router $router);
}
