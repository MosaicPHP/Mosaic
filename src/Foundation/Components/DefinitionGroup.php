<?php

namespace Fresco\Foundation\Components;

interface DefinitionGroup
{
    /**
     * @return array|Definition[]
     */
    public function getDefinitions() : array;
}
