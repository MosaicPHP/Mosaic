<?php

namespace Fresco\Definitions;

use Fresco\Definitions\FastRoute\FastRouteDispatcherDefinition;
use Fresco\Definitions\Fresco\FrescoRouterDefinition;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\DefinitionGroup;

class FastRouteDefinition implements DefinitionGroup
{
    /**
     * @return array|Definition[]
     */
    public function getDefinitions() : array
    {
        return [
            FrescoRouterDefinition::class,
            FastRouteDispatcherDefinition::class
        ];
    }
}
