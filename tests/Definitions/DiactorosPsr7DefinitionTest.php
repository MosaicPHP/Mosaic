<?php

namespace Fresco\Tests\Definitions;

use Fresco\Definitions\DiactorosPsr7Definition;
use Fresco\Definitions\DiactorosRequestDefinition;
use Fresco\Definitions\DiactorosResponseDefinition;
use Fresco\Definitions\DiactorosResponseFactoryDefinition;

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
        return new DiactorosPsr7Definition();
    }
}
