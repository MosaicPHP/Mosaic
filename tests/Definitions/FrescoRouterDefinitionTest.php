<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Routing\Router;
use Fresco\Definitions\Fresco\FrescoRouterDefinition;

class FrescoRouterDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new FrescoRouterDefinition();
    }

    public function getAs()
    {
        return Router::class;
    }

    public function getAdapter()
    {
        return \Fresco\Routing\Router::class;
    }
}
