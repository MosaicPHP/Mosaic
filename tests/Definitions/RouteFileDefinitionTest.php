<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Routing\RouteLoader;
use Fresco\Definitions\RouteFileDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class RouteFileDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new RouteFileDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            RouteLoader::class
        ];
    }
}
