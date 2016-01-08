<?php

namespace Fresco\Tests\Definitions;

use Fresco\Config\Adapters\LaravelConfig;
use Fresco\Contracts\Config\Config;
use Fresco\Definitions\LaravelConfigDefinition;

class LaravelConfigDefinitionTest extends DefinitionTestCase
{
    public function getDefinition()
    {
        return new LaravelConfigDefinition();
    }

    public function getAs()
    {
        return Config::class;
    }

    public function getAdapter()
    {
        return LaravelConfig::class;
    }
}
