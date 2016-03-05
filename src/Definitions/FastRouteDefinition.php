<?php

namespace Mosaic\Definitions;

use Mosaic\Contracts\Routing\RouteDispatcher as RouteDispatcherContract;
use Mosaic\Contracts\Routing\Router as RouterContract;
use Mosaic\Routing\Adapters\FastRoute\RouteDispatcher;
use Mosaic\Routing\Router;
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
