<?php

namespace Fresco\Definitions;

use Fresco\Contracts\Http\Response;
use Fresco\Foundation\Components\Definition;
use Fresco\Http\Adapters\Psr7\Response as Adapter;

class DiactorosResponseDefinition implements Definition
{
    /**
     * @return Adapter
     */
    public function define()
    {
        return new Adapter(
            new \Zend\Diactoros\Response()
        );
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return Response::class;
    }
}
