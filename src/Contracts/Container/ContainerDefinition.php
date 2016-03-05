<?php

namespace Mosaic\Contracts\Container;

interface ContainerDefinition
{
    /**
     * @return Container
     */
    public function getDefinition() : Container;
}
