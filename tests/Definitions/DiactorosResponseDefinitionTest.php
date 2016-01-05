<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Http\Response;
use Fresco\Definitions\DiactorosResponseDefinition;

class DiactorosResponseDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new DiactorosResponseDefinition();
    }

    public function getAs()
    {
        return Response::class;
    }

    public function getAdapter()
    {
        return \Fresco\Http\Adapters\Psr7\Response::class;
    }
}
