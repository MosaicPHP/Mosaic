<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Routing\RouteDispatcher;
use Fresco\Contracts\Routing\Router;
use Fresco\Definitions\FastRouteDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class FastRouteDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new FastRouteDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            RouteDispatcher::class,
            Router::class
        ];
    }
}
