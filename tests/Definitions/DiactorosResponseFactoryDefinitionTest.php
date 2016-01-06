<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Http\ResponseFactory;
use Fresco\Definitions\Diactoros\DiactorosResponseFactoryDefinition;

class DiactorosResponseFactoryDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new DiactorosResponseFactoryDefinition();
    }

    public function getAs()
    {
        return ResponseFactory::class;
    }

    public function getAdapter()
    {
        return \Fresco\Http\Adapters\Psr7\ResponseFactory::class;
    }
}
