<?php

namespace Fresco\Contracts\Routing;

use Fresco\Contracts\Http\Request;
use Fresco\Routing\RouteCollection;

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
