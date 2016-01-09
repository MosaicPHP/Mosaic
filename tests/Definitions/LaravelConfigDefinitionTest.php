<?php

namespace Fresco\Tests\Definitions;

use Fresco\Contracts\Config\Config;
use Fresco\Definitions\LaravelConfigDefinition;
use Interop\Container\Definition\DefinitionProviderInterface;

class LaravelConfigDefinitionTest extends DefinitionTestCase
{
    public function getDefinition() : DefinitionProviderInterface
    {
        return new LaravelConfigDefinition();
    }

    public function shouldDefine() : array
    {
        return [
            Config::class
        ];
    }
}
