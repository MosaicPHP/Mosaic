<?php

namespace Fresco\Definitions\FastRoute;

use Fresco\Contracts\Routing\RouteDispatcher as RouteDispatcherContract;
use Fresco\Foundation\Components\Definition;
use Fresco\Routing\Adapters\FastRoute\RouteDispatcher;

class FastRouteDispatcherDefinition implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new RouteDispatcher;
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return RouteDispatcherContract::class;
    }
}
