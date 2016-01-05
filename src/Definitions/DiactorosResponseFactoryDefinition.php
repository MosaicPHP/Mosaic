<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Http\ResponseFactory as ResponseFactoryContract;
use Fresco\Foundation\Components\Definition;
use Fresco\Http\Adapters\Psr7\ResponseFactory;

class DiactorosResponseFactoryDefinition implements Definition
{
    /**
     * @return Adapter
     */
    public function define()
    {
        return new ResponseFactory();
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return ResponseFactoryContract::class;
    }
}
