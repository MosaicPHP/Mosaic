<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\Routing\RouteDispatcher;
use Mosaic\Contracts\Routing\Router;
use Mosaic\Definitions\FastRouteDefinition;
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
