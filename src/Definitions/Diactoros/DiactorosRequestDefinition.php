<?php

namespace Fresco\Definitions\Diactoros;

use Fresco\Contracts\Http\Request;
use Fresco\Foundation\Components\Definition;
use Fresco\Http\Adapters\Psr7\Request as Adapter;
use Zend\Diactoros\ServerRequestFactory;

class DiactorosRequestDefinition implements Definition
{
    /**
     * @return Adapter
     */
    public function define()
    {
        return new Adapter(
            ServerRequestFactory::fromGlobals()
        );
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return Request::class;
    }
}
