<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Http\Request;
use Fresco\Definitions\Diactoros\DiactorosRequestDefinition;

class DiactorosRequestDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new DiactorosRequestDefinition();
    }

    public function getAs()
    {
        return Request::class;
    }

    public function getAdapter()
    {
        return \Fresco\Http\Adapters\Psr7\Request::class;
    }
}
