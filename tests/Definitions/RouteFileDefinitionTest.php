<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\Routing\RouteLoader;
use Mosaic\Definitions\RouteFileDefinition;
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
