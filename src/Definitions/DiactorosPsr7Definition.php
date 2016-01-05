<?php

namespace Fresco\Definitions;

use Fresco\Foundation\Components\Definition;
use Fresco\Foundation\Components\DefinitionGroup;

class DiactorosPsr7Definition implements DefinitionGroup
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
