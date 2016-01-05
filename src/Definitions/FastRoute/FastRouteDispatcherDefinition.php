<?php

namespace Fresco\Definitions\FastRoute;

use Fresco\Contracts\Routing\RouteDispatcher;
use Fresco\Foundation\Components\Definition;
use Fresco\Routing\Adapters\FastRoute\RouteDispatcher as Adapter;

class FastRouteDispatcherDefinition implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new Adapter;
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return RouteDispatcher::class;
    }
}
