<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Http\Request;
use Fresco\Contracts\Http\Response;
use Fresco\Contracts\Http\ResponseFactory;
use Fresco\Definitions\DiactorosDefinition;
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
