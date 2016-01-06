<?php

namespace Fresco\Tests\Definitions;

use Fresco\Definitions\FastRoute\FastRouteDispatcherDefinition;
use Fresco\Definitions\FastRouteDefinition;
use Fresco\Definitions\Fresco\FrescoRouterDefinition;

class FastRouteDefinitionTest extends DefinitionGroupTestCase
{
    public function getDefinitions()
    {
        return [
            FrescoRouterDefinition::class,
            FastRouteDispatcherDefinition::class
        ];
    }

    public function getGroup()
    {
        return new FastRouteDefinition();
    }
}
