<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Routing\RouteDispatcher;
use Fresco\Definitions\FastRoute\FastRouteDispatcherDefinition;

class FastRouteDispatcherDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new FastRouteDispatcherDefinition();
    }

    public function getAs()
    {
        return RouteDispatcher::class;
    }

    public function getAdapter()
    {
        return \Fresco\Routing\Adapters\FastRoute\RouteDispatcher::class;
    }
}
