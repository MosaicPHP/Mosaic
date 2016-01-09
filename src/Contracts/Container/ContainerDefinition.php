<?php

namespace Fresco\Contracts\Container;

interface ContainerDefinition
{
    /**
     * @return Container
     */
    public function getDefinition() : Container;
}
