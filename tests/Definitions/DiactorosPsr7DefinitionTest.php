<?php

namespace Fresco\Tests\Definitions;

use Fresco\Definitions\Diactoros\DiactorosRequestDefinition;
use Fresco\Definitions\Diactoros\DiactorosResponseDefinition;
use Fresco\Definitions\Diactoros\DiactorosResponseFactoryDefinition;
use Fresco\Definitions\DiactorosDefinition;

class DiactorosPsr7DefinitionTest extends DefinitionGroupTestCase
{
    public function getDefinitions()
    {
        return [
            DiactorosRequestDefinition::class,
            DiactorosResponseDefinition::class,
            DiactorosResponseFactoryDefinition::class
        ];
    }

    public function getGroup()
    {
        return new DiactorosDefinition();
    }
}
