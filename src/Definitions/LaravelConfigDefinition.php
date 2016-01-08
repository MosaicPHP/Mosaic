<?php

namespace Fresco\Definitions;

use Fresco\Config\Adapters\LaravelConfig;
use Fresco\Contracts\Config\Config;
use Fresco\Foundation\Components\Definition;
use Illuminate\Config\Repository;

class LaravelConfigDefinition implements Definition
{
    /**
     * @return mixed
     */
    public function define()
    {
        return new LaravelConfig(
            new Repository
        );
    }

    /**
     * @return string
     */
    public function defineAs() : string
    {
        return Config::class;
    }
}
