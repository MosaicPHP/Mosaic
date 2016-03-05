<?php

namespace Mosaic\Tests\Definitions;

use Mosaic\Contracts\Config\Config;
use Mosaic\Definitions\LaravelConfigDefinition;
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
