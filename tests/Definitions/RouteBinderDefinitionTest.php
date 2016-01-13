<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Routing\RouteLoader;
use Fresco\Definitions\RouteBinderDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class RouteBinderDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new RouteBinderDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            RouteLoader::class
        ];
    }
}
