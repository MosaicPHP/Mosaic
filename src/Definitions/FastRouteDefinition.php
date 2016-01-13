<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Routing\RouteDispatcher as RouteDispatcherContract;
use Fresco\Contracts\Routing\Router as RouterContract;
use Fresco\Routing\Adapters\FastRoute\RouteDispatcher;
use Fresco\Routing\Router;
use Interop\Container\Definition\DefinitionProviderInterface;

class FastRouteDefinition implements DefinitionProviderInterface
{
    /**
     * @return array|Definition[]
     */
    public function getDefinitions() : array
    {
        return [
            RouteDispatcherContract::class => new RouteDispatcher,
            RouterContract::class          => new Router
        ];
    }
}
