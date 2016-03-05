<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\Http\Request;
use Mosaic\Contracts\Http\Response;
use Mosaic\Contracts\Http\ResponseFactory;
use Mosaic\Definitions\DiactorosDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class DiactorosDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new DiactorosDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            Request::class,
            Response::class,
            ResponseFactory::class
        ];
    }
}
