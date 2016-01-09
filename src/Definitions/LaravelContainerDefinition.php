<?php

namespace Fresco\Definitions;

use Fresco\Container\Adapters\Laravel\Container as Adapter;
use Fresco\Contracts\Container\Container as ContainerContract;
use Fresco\Contracts\Container\ContainerDefinition;
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
