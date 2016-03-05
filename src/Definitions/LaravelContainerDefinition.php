<?php

namespace Mosaic\Definitions;

use Mosaic\Container\Adapters\Laravel\Container as Adapter;
use Mosaic\Contracts\Container\Container as ContainerContract;
use Mosaic\Contracts\Container\ContainerDefinition;
use Illuminate\Container\Container;

class LaravelContainerDefinition implements ContainerDefinition
{
    /**
     * @return ContainerContract
     */
    public function getDefinition() : ContainerContract
    {
        return new Adapter(new Container);
    }
}
