<?php

namespace Fresco\Tests\Definitions;

use Fresco\Definitions\DiactorosDefinition;
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
        return new DiactorosDefinition();
    }
}
