<?php

namespace Mosaic\Contracts\Routing;

use Mosaic\Contracts\Http\Request;
use Mosaic\Routing\RouteCollection;

interface RouteDispatcher
{
    /**
     * Dispatch the request
     *
     * @param Request         $request
     * @param RouteCollection $collection
     *
     * @return mixed
     */
    public function dispatch(Request $request, RouteCollection $collection);
}
