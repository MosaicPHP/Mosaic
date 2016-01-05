<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Container\Container;
use Fresco\Definitions\LaravelContainerDefinition;

class LaravelContainerDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new LaravelContainerDefinition;
    }

    public function getAs()
    {
        return Container::class;
    }

    public function getAdapter()
    {
        return \Fresco\Container\Adapters\Laravel\Container::class;
    }
}
