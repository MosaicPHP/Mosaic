<?php

namespace Fresco\Definitions;

use Fresco\Container\Adapters\Laravel\Container as Adapter;
use Fresco\Foundation\Components\Definition;
use Illuminate\Container\Container;

class LaravelContainerDefinition implements Definition
{
    /**
     * @return ContainerAdapter
     */
    public function define()
    {
        return new Adapter(new Container);
    }

    /**
     * @return string
     */
    public function defineAs()
    {
        return \Fresco\Contracts\Container\Container::class;
    }
}
