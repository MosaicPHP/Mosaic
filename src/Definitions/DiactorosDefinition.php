<?php

namespace Fresco\Definitions;

use Fresco\Definitions\Diactoros\DiactorosRequestDefinition;
use Fresco\Definitions\Diactoros\DiactorosResponseDefinition;
use Fresco\Definitions\Diactoros\DiactorosResponseFactoryDefinition;
use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\DefinitionGroup;

class DiactorosDefinition implements DefinitionGroup
{
    /**
     * @return array|Definition[]
     */
    public function getDefinitions() : array
    {
        return [
            DiactorosRequestDefinition::class,
            DiactorosResponseDefinition::class,
            DiactorosResponseFactoryDefinition::class
        ];
    }
}
