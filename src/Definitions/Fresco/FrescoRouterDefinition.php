<?php

namespace Fresco\Definitions\Fresco;

use Fresco\Contracts\Routing\Router as RouterContract;
use Fresco\Foundation\Components\Definition;
use Fresco\Routing\Router;

class FrescoRouterDefinition implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new Router();
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return RouterContract::class;
    }
}
