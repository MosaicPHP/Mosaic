<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\Routing\RouteLoader;
use Mosaic\Definitions\RouteBinderDefinition;
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
